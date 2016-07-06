#! /bin/sh

docker build -t oversquad .
docker run -dt --name oversquad -p 4242:80 -p 8090:8090 oversquad
