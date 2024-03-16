FROM php:8.2-apache as prod

# Install system dependencies
RUN apt-get update && apt-get install -y \
    apt-transport-https \
    git \
    zip \
    nano \
    vim \
    curl \
    sudo \
    unzip \
    supervisor \
    htop
RUN apt-get update && apt-get install -y \
    libcurl3-dev \
    libxml2-dev  \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libgmp-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libfontconfig1-dev
RUN apt-get update && apt-get install -y \
    xclip \
    libreadline-dev \
    libfreetype6-dev \
    libjpeg62 \
    libjpeg62-turbo-dev \
    libssl-dev \
    g++
RUN apt-get update && apt-get install -y \
    libsodium-dev \
    libonig-dev \
    librdkafka-dev \
    default-mysql-client \
    gettext-base \
    cron


# Apache configuration
ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite headers

WORKDIR /var/www

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    sockets \
    sodium \
    gd \
    zip \
    mbstring \
    xml \
    dom \
    curl \
    ctype \
    pcntl \
    gmp

RUN docker-php-ext-configure gmp

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg

RUN a2enmod remoteip

RUN echo "RemoteIPHeader X-Forwarded-For" >> /etc/apache2/apache2.conf

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

COPY docker/000-default.conf /etc/apache2/sites-available/
COPY docker/php.ini /usr/local/etc/php

RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > /usr/local/etc/php/php.ini

COPY . .

RUN rm -rf storage/framework/{sessions,views,cache}

RUN mkdir storage/framework/{sessions,views,cache}

RUN composer install

EXPOSE 80

RUN ["chmod", "+x", "./docker/entrypoint.sh"]

ENTRYPOINT [ "bash", "./docker/entrypoint.sh" ]
