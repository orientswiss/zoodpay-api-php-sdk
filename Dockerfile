ARG PHP_VERSION=7.4
FROM php:$PHP_VERSION
RUN apt-get update && apt-get install zip unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer install

CMD php Usage.php