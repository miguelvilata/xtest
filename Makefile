make.DEFAULT_GOAL := help

DOCKER_COMPOSE := docker-compose --file docker/docker-compose.yml
PHP_UNIT := vendor/bin/phpunit

.PHONY: init
init:
	make recreate
	make composer-install
	make restart

.PHONY: execute
execute:
	$(DOCKER_COMPOSE) exec docker-php-fpm bash -c "cd src && php index.php"

execute-verbose:
	$(DOCKER_COMPOSE) exec docker-php-fpm bash -c "cd src && php index_verbose.php"

.PHONY: start
start:
	$(DOCKER_COMPOSE) up -d --remove-orphans

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart: stop start

.PHONY: recreate
recreate:
	$(DOCKER_COMPOSE) up -d --build

#Access shell on container
.PHONY: shell-php
shell-php:
	$(DOCKER_COMPOSE) exec docker-php-fpm bash

.PHONY: composer-install
composer-install:
	$(DOCKER_COMPOSE) run --rm docker-php-fpm composer install -vvv

.PHONY: test
test:
	make start
	$(DOCKER_COMPOSE) run --rm -u $(UID):$(GID) docker-php-fpm php $(PHP_UNIT) --bootstrap vendor/autoload.php --testdox test
