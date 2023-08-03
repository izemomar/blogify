DEV_COMPOSE_FILE = ./docker/docker-compose.dev.yml
DEV_API_ENV_FILE = ./api/src/.env.dev
DEV_FRONTEND_ENV_FILE = ./client/.env.dev

build.dev:
	cd ./api && \
	$(MAKE) build.dev
	cd ./client && \
	$(MAKE) build.dev

up.dev:
	docker-compose --env-file $(DEV_API_ENV_FILE) \
	-f $(DEV_COMPOSE_FILE) up --build --force-recreate -d

build.up.dev:
	$(MAKE) build.dev
	$(MAKE) up.dev
	
container ?=  blogify-php
it.dev:
	docker exec -it $(container) sh

clear.dev:
	docker compose --file $(DEV_COMPOSE_FILE) \
	--env-file $(DEV_API_ENV_FILE) \
	down --rmi all --volumes --remove-orphans
	rmdir /s /q data
