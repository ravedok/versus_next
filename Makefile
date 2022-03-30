#!/bin/bash

PHP-SERVICE = versus_next-php
NGINX-SERVICE= versus_next-nginx
OS := $(shell uname)


ifeq ($(OS),Darwin)
	UID = $(shell id -u)
else ifeq ($(OS),Linux)
	UID = $(shell id -u)
else
	UID = 1000
endif

HOST_IP = $(shell ip a | grep eth0 | grep -Eo '([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})' | head -1 | grep . || echo '127.0.0.1')

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

run: ## Start the containers
	docker network create atlas-network || true
	docker start atlas-proxy
	U_ID=${UID} HOST_IP=${HOST_IP} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) run

build: ## Rebuilds all the containers
	U_ID=${UID} HOST_IP=${HOST_IP} docker-compose build

ssh: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${PHP-SERVICE} bash

ssh-nginx: ## ssh's into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${NGINX-SERVICE} bash

xdebug-enable:
	chmod +x docker/php/xdebug.sh
	U_ID=${UID} SERVICE_ID=${PHP-SERVICE} ./docker/php/xdebug.sh enable

xdebug-disable:
	chmod +x docker/php/xdebug.sh
	U_ID=${UID} SERVICE_ID=${PHP-SERVICE} ./docker/php/xdebug.sh disable
