FROM php:7.4-fpm-alpine

WORKDIR /var/www/html/backend

# Instal PDO
RUN docker-php-ext-install pdo pdo_mysql

# Install Compose
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer