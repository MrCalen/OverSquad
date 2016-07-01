check:
	vendor/phpunit/phpunit/phpunit
coverage:
	vendor/phpunit/phpunit/phpunit --coverage-html report
	firefox report/index.html &
