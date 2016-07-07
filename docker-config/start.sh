#!/bin/bash

# Disable Strict Host checking for non interactive git clones

mkdir -p -m 0700 /root/.ssh
echo -e "Host *\n\tStrictHostKeyChecking no\n" >> /root/.ssh/config

if [ ! -z "$SSH_KEY" ]; then
 echo $SSH_KEY > /root/.ssh/id_rsa.base64
 base64 -d /root/.ssh/id_rsa.base64 > /root/.ssh/id_rsa
 chmod 600 /root/.ssh/id_rsa
fi

# Set custom webroot
if [ ! -z "$WEBROOT" ]; then
 sed -i "s#root /var/www/html;#root ${WEBROOT};#g" /etc/nginx/sites-available/default.conf
fi

# Setup git variables
if [ ! -z "$GIT_EMAIL" ]; then
 git config --global user.email "$GIT_EMAIL"
fi
if [ ! -z "$GIT_NAME" ]; then
 git config --global user.name "$GIT_NAME"
 git config --global push.default simple
fi

# Dont pull code down if the .git folder exists
if [ ! -d "/var/www/html/.git" ]; then
 # Pull down code from git for our site!
 if [ ! -z "$GIT_REPO" ]; then
   # Remove the test index file
   rm -Rf /var/www/html/index.php
   if [ ! -z "$GIT_BRANCH" ]; then
     git clone -b $GIT_BRANCH $GIT_REPO /var/www/html/
   else
     git clone $GIT_REPO /var/www/html/
   fi
   chown -Rf nginx.nginx /var/www/html
 fi
fi

# Display PHP error's or not
if [[ "$ERRORS" != "1" ]] ; then
 echo php_flag[display_errors] = off >> /etc/php5/php-fpm.conf
else
 echo php_flag[display_errors] = on >> /etc/php5/php-fpm.conf
fi

# Very dirty hack to replace variables in code with ENVIRONMENT values
if [[ "$TEMPLATE_NGINX_HTML" == "1" ]] ; then
  for i in $(env)
  do
    variable=$(echo "$i" | cut -d'=' -f1)
    value=$(echo "$i" | cut -d'=' -f2)
    if [[ "$variable" != '%s' ]] ; then
      replace='\$\$_'${variable}'_\$\$'
      find /var/www/html -type f -exec sed -i -e 's/'${replace}'/'${value}'/g' {} \;
    fi
  done
fi

# Start mysql daemon
if [ -d /app/mysql ]; then
  echo "[i] MySQL directory already present, skipping creation"
else
  echo "[i] MySQL data directory not found, creating initial DBs"

  mysql_install_db --user=root > /dev/null

  if [ "$MYSQL_ROOT_PASSWORD" = "" ]; then
    MYSQL_ROOT_PASSWORD=root
    echo "[i] MySQL root Password: $MYSQL_ROOT_PASSWORD"
  fi

  MYSQL_DATABASE="oversquad"
  MYSQL_USER="oversquad"
  MYSQL_PASSWORD="oversquad"

  if [ ! -d "/run/mysqld" ]; then
    mkdir -p /run/mysqld
  fi

  tfile=`mktemp`
  if [ ! -f "$tfile" ]; then
      return 1
  fi

  cat << EOF > $tfile
USE mysql;
FLUSH PRIVILEGES;
UPDATE user SET password=PASSWORD("$MYSQL_ROOT_PASSWORD") WHERE user='root';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;
UPDATE user SET password=PASSWORD("") WHERE user='root' AND host='localhost';
EOF

  if [ "$MYSQL_DATABASE" != "" ]; then
    echo "[i] Creating database: $MYSQL_DATABASE"
    echo "CREATE DATABASE IF NOT EXISTS \`$MYSQL_DATABASE\` CHARACTER SET utf8 COLLATE utf8_general_ci;" >> $tfile

    if [ "$MYSQL_USER" != "" ]; then
      echo "[i] Creating user: $MYSQL_USER with password $MYSQL_PASSWORD"
      echo "CREATE USER '$MYSQL_USER'@'localhost' IDENTIFIED BY '$MYSQL_PASSWORD';" >> $tfile
      echo "GRANT ALL ON \`$MYSQL_DATABASE\`.* to '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';" >> $tfile
      echo "FLUSH PRIVILEGES;" >> $tfile
    fi
  fi

  /usr/bin/mysqld --user=root --bootstrap --verbose=0 < $tfile
  rm -f $tfile
fi

echo "[i] Starting mysql daemon"
exec /usr/bin/mysqld --user=root &
sleep 3

BOOTSTRAP_FILE="/var/www/docker-config/bootstrap.sh"
if [ -f "$BOOTSTRAP_FILE" ]; then
  echo "[i] Running sh $BOOTSTRAP_FILE"
  cd /var/www && sh "$BOOTSTRAP_FILE" 
fi

echo "[i] Seeding database"
cd /var/www && php artisan db:seed

echo "[i] Running the level update"
cd /var/www && php artisan oversquad:refresh

echo "[i] Starting the websocket server"
cd /var/www && php artisan ws:serve &

# Start supervisord and services
/usr/bin/supervisord -n -c /etc/supervisord.conf
