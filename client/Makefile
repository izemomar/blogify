CLIENT_IMAGE_NAME = blogify-client
DEV_IMAGE_TAG = dev
CLIENT_DEV_DOCKER_FILE = ./docker/Dockerfile.dev


build.dev:
	docker build -t $(CLIENT_IMAGE_NAME):$(DEV_IMAGE_TAG) \
	-f $(CLIENT_DEV_DOCKER_FILE) .

setup-project:
	docker build -t front-project-creator \
	-f ./docker/setup/Dockerfile . --no-cache
	docker run --rm -it \
	-v $(CURDIR)/app:/usr/app front-project-creator
	docker rmi front-project-creator --force



	