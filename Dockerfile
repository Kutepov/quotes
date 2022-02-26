FROM php:8.1-fpm

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www
COPY . /var/www

EXPOSE 9000
CMD ["php-fpm"]
