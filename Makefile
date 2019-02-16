unit-tests:
	./vendor/bin/phpunit -c phpunit.xml --colors=auto

analyser:
	./vendor/bin/phpstan analyse src tests -l7

psr2:
	./vendor/bin/phpcs --standard=PSR2 --severity=1 src/ tests/

tests: psr2 analyser unit-tests

install-composer:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php --install-dir=.
	php -r "unlink('composer-setup.php');"

composer:
	php ./composer.phar install