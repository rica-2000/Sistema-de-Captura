# syntax=docker/dockerfile:1.7

FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

FROM composer:2.8 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts

FROM php:8.3-cli-alpine
WORKDIR /var/www/html

RUN apk add --no-cache \
    bash \
    libpq \
    icu-libs \
    oniguruma \
    zip \
    unzip \
    libzip \
    postgresql-dev \
    icu-dev \
    libzip-dev \
    && docker-php-ext-install pdo_pgsql bcmath intl zip \
    && apk del postgresql-dev icu-dev libzip-dev

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

RUN chmod +x docker/start.sh \
    && mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=8080

EXPOSE 8080

CMD ["sh", "docker/start.sh"]
