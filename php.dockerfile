FROM php:7.4-fpm

WORKDIR /var/www/html/backend

# Instal PDO and Extensions for Export Excel
# RUN docker-php-ext-install pdo pdo_mysql 

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

COPY --from=composer /usr/bin/composer /usr/bin/composer
# Copy composer.lock and composer.json
COPY /backend/composer.lock /backend/composer.json /var/www/html/backend/

RUN install-php-extensions pdo pdo_mysql zip gd simplexml

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user