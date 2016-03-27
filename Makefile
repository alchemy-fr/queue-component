test-fast:
	./vendor/bin/phpunit

test:
	php -dzend_extension=xdebug.so vendor/bin/phpunit --coverage-html=build/
