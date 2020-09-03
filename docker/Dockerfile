FROM php:7.1.26-apache

WORKDIR /var/www

RUN apt-get update \
    && curl -sL https://deb.nodesource.com/setup_6.x | bash - \
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
      nano \
      iputils-ping \ 
      mysql-server \
    && update-ca-certificates \
    && docker-php-ext-install \
      pdo_mysql \
      opcache \
      curl \
      zip \
    && apt-get autoremove \
    && rm -r /var/lib/apt/lists/* \
    && curl -s https://getcomposer.org/installer  | php \
    && mv composer.phar /usr/local/bin/composer

ADD ./apache-conf/000-default.conf /etc/apache2/sites-available

RUN a2enmod rewrite expires deflate ssl cgi alias env headers

ARG GIT_REPO
ARG DOMAIN_NAME

RUN mkdir git \
    && touch v4 \
    && mkdir workingarea \
    && git clone --bare ${GIT_REPO} git/exercises.git   \
    && git clone ${GIT_REPO} website  \
    && ln -s /var/www/website/backend/hook/hook.php /var/www/git/exercises.git/hooks/update \
    && cp /var/www/website/docker/git-config git/exercises.git/config

RUN sed -i -r "s|REPLACE_ME|http:\/\/${DOMAIN_NAME}|g"  /var/www/website/frontend/app/home/startCommands.coffee

WORKDIR /var/www/git/exercises.git
RUN git checkout master && git branch -D verifications

WORKDIR /var/www/website/backend
RUN composer install

WORKDIR /var/www/website/frontend
RUN npm install

RUN npm install bower -g
RUN bower --allow-root install
RUN npm run-script dist

WORKDIR /var/www
ARG WWW_DATA_UID=1001
RUN usermod --uid "$WWW_DATA_UID" www-data \
           && groupmod --gid "$WWW_DATA_UID" www-data \
           && chown -hR www-data:www-data /var/www
RUN echo ${GIT_REPO}