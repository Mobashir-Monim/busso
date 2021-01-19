FROM php:7.4-fpm

# COPY composer.lock composer.json /var/www/

WORKDIR /var/www

RUN apt update && apt install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    zip 

RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

COPY ./config/php/local.ini /usr/local/etc/php/conf.d/local.ini

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

USER www

COPY --chown=www:www . /var/www

EXPOSE 9000