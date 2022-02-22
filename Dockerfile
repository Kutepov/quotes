FROM php:8.1-fpm

COPY composer.lock composer.json /var/www/
RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www
COPY . /var/www

EXPOSE 9000
CMD ["php-fpm"]
