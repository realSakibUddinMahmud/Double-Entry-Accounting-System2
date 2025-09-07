# syntax=docker/dockerfile:1.7

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress --optimize-autoloader

FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* ./
RUN npm ci || true
COPY resources/ resources/
COPY vite.config.js .
RUN npm run build || true

FROM php:8.4-fpm-alpine AS php
WORKDIR /var/www/html
RUN apk add --no-cache bash icu-dev oniguruma-dev libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev zlib-dev git
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd intl opcache
COPY --from=vendor /app/vendor/ ./vendor/
COPY . .
COPY --from=assets /app/public/build ./public/build
COPY ops/php/php.ini /usr/local/etc/php/conf.d/app.ini
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

FROM nginx:alpine AS runtime
WORKDIR /var/www/html
COPY --from=php /usr/local/etc/php/conf.d/app.ini /usr/local/etc/php/conf.d/app.ini
COPY --from=php /usr/local/bin/php /usr/local/bin/php
COPY --from=php /usr/local/sbin/php-fpm /usr/local/sbin/php-fpm
COPY --from=php /usr/lib/ /usr/lib/
COPY --from=php /usr/local/lib/ /usr/local/lib/
COPY --from=php /var/www/html /var/www/html
COPY ops/nginx/nginx.conf /etc/nginx/nginx.conf
EXPOSE 80
CMD ["/bin/sh", "-lc", "php-fpm -D && nginx -g 'daemon off;' "]

