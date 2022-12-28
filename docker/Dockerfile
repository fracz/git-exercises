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

WORKDIR /var/www
RUN mkdir website

COPY ./backend website/backend
COPY --from=backend_build /var/www/vendor website/backend/vendor
COPY --from=frontend_build /app/ website/frontend/

RUN mkdir git workingarea \
    && touch v5

# Get the exercises 
RUN git clone --bare ${GIT_REPO} git/exercises.git
# Copy the hints into the backend
RUN cd git/exercises.git && \
	git worktree add /tmp/hints hints && \
	mv /tmp/hints /var/www/website/backend/hook/hints && \
	git worktree prune
	
RUN ln -s /var/www/website/backend/hook/hook.php git/exercises.git/hooks/update
COPY ./docker/git-config git/exercises.git/config

WORKDIR /var/www/git/exercises.git
RUN git checkout master && git branch -D verifications hints

ARG WWW_DATA_UID=1001
RUN usermod --uid "$WWW_DATA_UID" www-data \
           && groupmod --gid "$WWW_DATA_UID" www-data \
           && chown -hR www-data:www-data /var/www
