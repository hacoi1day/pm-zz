FROM php:7.4-fpm-alpine

WORKDIR /var/www/html/backend

# Instal PDO and Extensions for Export Excel
# RUN docker-php-ext-install pdo pdo_mysql 

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN install-php-extensions pdo pdo_mysql zip gd simplexml
