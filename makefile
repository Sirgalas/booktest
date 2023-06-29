SHELL = /bin/bash

docker_compose_bin := $(shell command -v docker-compose 2> /dev/null)
APP_CONTAINER_NAME := backend

.DEFAULT_GOAL := help

help: ## Show this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

init: down build up composer-update migrations-migrate migrations-rbac rbac-init

up: ## Start all containers in background for developers
	$(docker_compose_bin) up --no-recreate -d

down: ## Stop all containers
	$(docker_compose_bin) down

build : ## Stop all containers
	$(docker_compose_bin) build

restart: ## Restart all containers
	$(docker_compose_bin) restart

shell: up ## Start shell in backend
	$(docker_compose_bin) exec "${APP_CONTAINER_NAME}" $(SHELL)

composer-install:
	docker-compose run --rm backend composer install

composer-update:
	docker-compose run --rm backend composer update

backend-migration:
	shell php yii migrate

drop-all:
	docker kill $(docker ps -q)
	docker rm $(docker ps -a -q)
	docker rmi $(docker images -q)

init-project: docker-down-clear docker-pull docker-build docker-up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

migrations-create:
	docker-compose run --rm backend php yii migrate/create $(name) --interactive=0
	
migrations-down:
	docker-compose run --rm backend php yii migrate/down --interactive=0

migrations-migrate:
	docker-compose run --rm backend php yii migrate --interactive=0

migrations-rbac:
	docker-compose run --rm backend php yii migrate --migrationPath=@yii/rbac/migrations --interactive=0

init-rbac:
	docker-compose run --rm backend php yii rbac/init



