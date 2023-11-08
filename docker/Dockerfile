FROM php:7.1.33-apache

WORKDIR /var/www

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
      libicu-dev \
      libpq-dev \
      ca-certificates \
      ssl-cert \
      libcurl4-gnutls-dev \
      git \
      unzip \
      nodejs \
      zlib1g-dev \
    && update-ca-certificates \
    && docker-php-ext-install \
      pdo_mysql \
      opcache \
      curl \
      zip \
    && apt-get -y autoremove \
    && rm -r /var/lib/apt/lists/*

RUN a2enmod rewrite expires deflate ssl cgi alias env headers

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --1 --filename=composer

ENV NODE_VERSION=16.20.0
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

RUN mkdir git \
    && touch v4 \
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

# After first install, run:
# docker compose exec gitexercises sh -c "cd website/backend && composer install"
# docker compose exec gitexercises sh -c "cd website/frontend && npm install"
# docker compose exec gitexercises sh -c "cd website/frontend && npm run dist"
