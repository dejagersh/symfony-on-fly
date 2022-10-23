# syntax = docker/dockerfile:experimental

# Default to PHP 8.1, but we attempt to match
# the PHP version from the user (wherever `flyctl launch` is run)
# Valid version values are PHP 7.4+
ARG PHP_VERSION=8.1
ARG NODE_VERSION=14
FROM serversideup/php:${PHP_VERSION}-fpm-nginx as base

# PHP_VERSION needs to be repeated here
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION

LABEL fly_launch_runtime="laravel"

RUN apt-get update && apt-get install -y \
    git curl zip unzip rsync ca-certificates vim htop cron \
    php${PHP_VERSION}-pgsql php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-swoole php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
# copy application code, skipping files based on .dockerignore
COPY . /var/www/html

RUN composer install --optimize-autoloader --no-dev --no-scripts \
    && chown -R webuser:webgroup /var/www/html \
    && rm -rf /etc/cont-init.d/* \
    && cp .fly/nginx-websockets.conf /etc/nginx/conf.d/websockets.conf \
    && cp .fly/nginx-default /etc/nginx/sites-available/default \
    && cp .fly/entrypoint.sh /entrypoint \
    && chmod +x /entrypoint

EXPOSE 8080

ENTRYPOINT ["/entrypoint"]
