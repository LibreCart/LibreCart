FROM php:8.3-fpm

WORKDIR /var/www

# Install php extentions
RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www
RUN chown -R www-data:www-data /var/www/var
RUN chown -R www-data:www-data /var/www/public

# Run composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install

EXPOSE 9000
CMD ["php-fpm"]