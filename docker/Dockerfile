FROM php:7.1-apache

WORKDIR /var/www

RUN apt-get update \
    && curl -sL https://deb.nodesource.com/setup_4.x | bash - \
    && apt-get install -y --no-install-recommends \
      libicu-dev \
      libpq-dev \
      ca-certificates \
      ssl-cert \
      libcurl4-gnutls-dev \
      git \
      unzip \
      nodejs \
    && update-ca-certificates \
    && docker-php-ext-install \
      pdo_mysql \
      opcache \
      curl \
      zip \
    && apt-get autoremove \
    && rm -r /var/lib/apt/lists/*

RUN a2enmod rewrite expires deflate ssl cgi alias env proxy_http

RUN mkdir git \
    && mkdir workingarea \
    && git clone --bare https://github.com/fracz/git-exercises.git git/exercises.git \
    && ln -s /var/www/website/backend/hook/hook.php /var/www/git/exercises.git/hooks/update
COPY git-config git/exercises.git/config

WORKDIR /var/www/git/exercises.git
RUN git checkout master && git branch -D verifications

WORKDIR /var/www

ARG WWW_DATA_UID=1001
RUN usermod --uid "$WWW_DATA_UID" www-data \
           && groupmod --gid "$WWW_DATA_UID" www-data \
           && chown -hR www-data:www-data /var/www
