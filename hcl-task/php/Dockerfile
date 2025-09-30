# FROM php:8.1-fpm
# RUN apt-get update \
#     && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip \
#     && pecl install redis \
#     && docker-php-ext-enable redis
# COPY conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf


FROM php:8.1-fpm
RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && pecl install redis \
    && docker-php-ext-enable redis
COPY conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf

