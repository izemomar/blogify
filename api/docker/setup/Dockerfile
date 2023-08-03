FROM php:8-fpm-alpine as prepare

LABEL maintainer="Omar IZEM <contact@izem.dev>"

# build args
ARG UID=1000
ARG GID=1000

# set user env vars
ENV UID=${UID} GID=${GID}

# workdir
WORKDIR /var/www/html

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# add user and group
RUN addgroup -g ${GID} --system yc-coding-challeng
RUN adduser -G yc-coding-challeng --system -D -s /bin/sh -u ${UID} yc-coding-challeng

# set user
USER yc-coding-challeng

# add entrypoint
COPY --chown=yc-coding-challeng:yc-coding-challeng ./docker/setup/create-project.entrypoint.sh /usr/local/bin/create-project.entrypoint.sh
RUN chmod +x /usr/local/bin/create-project.entrypoint.sh
ENTRYPOINT [ "sh" , "/usr/local/bin/create-project.entrypoint.sh" ]




