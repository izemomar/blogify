DEV_IMAGE_TAG = dev
PHP_IMAGE_NAME = blogify-php
PHP_DEV_DOCKER_FILE = ./docker/php/Dockerfile.dev
NGINX_IMAGE_NAME = blogify-nginx
NGINX_DEV_DOCKER_FILE = ./docker/nginx/Dockerfile.dev



build.dev:
	docker build -t $(PHP_IMAGE_NAME):$(DEV_IMAGE_TAG) \
	-f $(PHP_DEV_DOCKER_FILE) .

setup-project:
	docker build -t project-creator \
	-f ./docker/setup/Dockerfile . --no-cache
	docker run --rm \
	-v $(CURDIR)/src:/var/www/html project-creator
	docker rmi project-creator --force
	
	




	