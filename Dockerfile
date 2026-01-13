# syntax=docker/dockerfile:1

ARG PHP_VERSION=8.5-fpm-trixie
ARG NGINX_VERSION=1-trixie
ARG COMPOSER_VERSION=2

FROM composer:${COMPOSER_VERSION} AS versionedcomposer
FROM php:${PHP_VERSION} AS versionedphp
FROM nginxinc/nginx-unprivileged:${NGINX_VERSION} AS versionednginx

FROM versionedphp AS base
WORKDIR /var/www/html
ENV APP_ENV=production
ENV NODE_ENV=production
RUN <<EOF
  set -euo pipefail
  apt-get update -y
  apt-get upgrade -y --no-install-recommends
  apt-get install -y --no-install-recommends ca-certificates curl wget build-essential git zip unzip apt-transport-https gnupg lsb-release libfcgi-bin
  docker-php-ext-install pdo pdo_mysql
  pecl install apcu redis
  docker-php-ext-enable apcu redis
  apt-get install -y --no-install-recommends libzip-dev
  docker-php-ext-install zip
  apt-get autoremove -y
  apt-get autoclean -y
  apt-get clean -y
  rm -rf /var/lib/apt/lists/*
EOF
COPY ./ops/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY --from=versionedcomposer /usr/bin/composer /usr/bin/composer
COPY ./ops/php/entrypoint.sh /usr/local/bin/docker-php-entrypoint

FROM base AS devcontainer
ENV APP_ENV=local
ENV NODE_ENV=development
RUN <<EOF
  set -euo pipefail
  docker-php-ext-install pcntl
  pecl install xdebug
  docker-php-ext-enable xdebug
  mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
  groupadd devcontainer
  useradd -s /bin/bash --gid devcontainer -m devcontainer
  wget https://nodejs.org/dist/v24.12.0/node-v24.12.0-linux-x64.tar.xz -O node.tar.xz
  tar -xf node.tar.xz -C /usr/local --strip-components=1
  rm node.tar.xz
EOF
COPY ./ops/php/z.ini /usr/local/etc/php/conf.d/z.ini
COPY ./ops/php/zz.ini /usr/local/etc/php/conf.d/zz.ini
COPY ./ops/php/zzz.ini /usr/local/etc/php/conf.d/zzz.ini

FROM base AS php
COPY ./bin ./bin
COPY ./composer.json ./composer.json
COPY ./composer.lock ./composer.lock
COPY ./config ./config
COPY ./index.php ./index.php
COPY ./src ./src
RUN <<EOF
  set -euo pipefail
  composer install --no-dev --no-autoloader
  composer dump-autoload --no-dev -a --strict-psr --strict-ambiguous
  composer audit --no-dev
	composer check-platform-reqs --no-dev
	composer validate --strict --with-dependencies --check-lock
  mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
EOF
COPY ./ops/php/z.ini /usr/local/etc/php/conf.d/z.ini
COPY ./ops/php/zz.ini /usr/local/etc/php/conf.d/zz.ini

FROM versionednginx AS nginx
WORKDIR /var/www/html
COPY ./ops/nginx /etc/nginx
COPY ./public ./
