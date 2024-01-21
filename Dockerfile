FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libpng-dev \
        nodejs \
        npm \
    && docker-php-ext-install mysqli pdo pdo_mysql gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && npm install -g npm@latest \
    && rm -rf /var/lib/apt/lists/*

COPY . /var/www
WORKDIR /var/www

RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist \
    && ls -la 

RUN npm init -y \
    && npm install tailwindcss postcss autoprefixer \
    && ls -la

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 80

CMD ["php-fpm"]
