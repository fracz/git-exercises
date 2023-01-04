# Backend build stage
FROM composer:latest AS backend_build

COPY backend/composer.json /var/www/
RUN composer install -d /var/www/

# Frontend build stage
FROM node:lts-alpine as frontend_build
ARG DOMAIN_NAME

RUN apk add git

COPY frontend /app/
RUN sed -i -r "s|REPLACE_ME|https:\/\/${DOMAIN_NAME}|g"  /app/app/home/startCommands.coffee

WORKDIR /app

RUN npm install
RUN npm install bower -g

RUN bower --allow-root install
RUN npm run-script dist

# Production stage
FROM php:7.4.33-apache

RUN apt-get update
RUN apt-get install -y --no-install-recommends \
      libicu-dev \
      libpq-dev \
      ca-certificates \
      ssl-cert \
      libcurl4-gnutls-dev \
      git \
      unzip \
      libzip-dev

RUN update-ca-certificates
RUN docker-php-ext-install \
      pdo_mysql \
      opcache \
      curl \
      zip

RUN apt-get autoremove \
    && rm -r /var/lib/apt/lists/*

COPY ./docker/apache-conf/000-default.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite expires deflate ssl cgi alias env headers

ARG GIT_REPO
ARG SITE_ADMIN_NAME
ARG SITE_ADMIN_EMAIL

WORKDIR /var/www
RUN mkdir website

COPY ./backend website/backend
COPY --from=backend_build /var/www/vendor website/backend/vendor
COPY --from=frontend_build /app/ website/frontend/

RUN mkdir git workingarea

# Get the exercises
RUN git clone ${GIT_REPO} /tmp/exercises
# Copy the hints and verifications into the backend
RUN mkdir /var/www/git/exercises.git

# Create the exercise branches
WORKDIR /var/www/git/exercises.git
COPY docker/init-exercises.sh .
RUN ./init-exercises.sh
RUN rm -rf /tmp/exercises init-exercises.sh

RUN mkdir hooks && ln -s /var/www/website/backend/hook/hook.php .git/hooks/update
COPY ./docker/git-config .git/config

RUN git checkout main

ARG WWW_DATA_UID=1001
RUN usermod --uid "$WWW_DATA_UID" www-data \
           && groupmod --gid "$WWW_DATA_UID" www-data \
           && chown -hR www-data:www-data /var/www
