# Change the image version if you want to test it on other php version.
# versions are listed on https://hub.docker.com/_/php?tab=tags
# always use the *-apache tags. It have apache to serve the thing.
FROM php:8.1-apache

RUN apt-get update && apt-get install -y --fix-missing \
    apt-utils \
    gnupg

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libssl-dev \
    libicu-dev \
    libonig-dev

# Installing required extensions for the PHP.
RUN docker-php-ext-install pdo pdo_mysql mysqli zip intl mbstring

## GD SUPPORT
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev

RUN docker-php-ext-configure gd --with-webp=/usr/include/ --with-jpeg=/usr/include/ \
    --with-xpm=/usr/include/ --with-freetype=/usr/include/

RUN docker-php-ext-install gd

RUN docker-php-ext-enable gd


# ENV APACHE_DOCUMENT_ROOT /var/www/html/public
## Enable this if you run CI3!
ENV APACHE_DOCUMENT_ROOT /var/www/html/httpdocs
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Add rewrite engine for APACHE
RUN a2enmod rewrite headers

## Add xDebug Support
RUN pecl install xdebug

RUN docker-php-ext-enable xdebug

# Create a non-root user
RUN useradd --create-home --shell /bin/bash --groups sudo pndevworks
# Run as the User.
USER pndevworks