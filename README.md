# Dominoes

Basic usage information

## cli

### install composer packages
```
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
$ php composer-setup.php --install-dir=.
$ php -r "unlink('composer-setup.php');"

$ php ./composer.phar install
```

### play the game

CLI mode
```
$ php ./play-cli.php
```

Web mode
```
$ php -S localhost:8080 -t .
```

Then go to http://localhost:8080/index.php

### run the tests

PSR2 checking
```
$ php ./vendor/bin/phpcs --standard=PSR2 --severity=1 src/ tests/
```

Static code analyser
```
$ php ./vendor/bin/phpstan analyse src tests -l7
```

Unit tests
```
php ./vendor/bin/phpunit -c phpunit.xml --colors=auto
```

## Running with `make`

### install composer packages
```
$ make install-composer
$ make composer
```

### play the game

CLI mode
```
$ make play-cli
```

Web mode
```
$ make play-web
```

Then go to http://localhost:8080/index.php

### run the tests

PSR2 checking
```
$ make psr2
```

Static code analyser
```
$ make analyser
```

Unit tests
```
$ make unit-tests
```

All together PSR2 - Analyser - Unit Tests
```
$ make tests
```

## Running with `make` and `docker/docker-compose`

### install composer packages
```
$ make install-composer
$ make composer
```

### play the game

CLI mode
```
$ make play-cli-in-docker
```

Web mode
```
$ make play-web-in-docker
```

Then go to http://localhost:8080/index.php

### run the tests

All together PSR2 - Analyser - Unit Tests
```
$ make test-in-docker
```