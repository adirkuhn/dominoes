unit-tests:
	./vendor/bin/phpunit -c phpunit.xml

analyser:
	./vendor/bin/phpstan analyse src tests -l7

psr2:
	./vendor/bin/phpcs --standard=PSR2 --severity=1 src/ tests/

tests: psr2 analyser unit-tests