FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libpng-dev \
        nodejs \
        npm \
        libicu-dev \ 
    && docker-php-ext-install mysqli pdo pdo_mysql gd intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && npm install -g npm@latest \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y locales locales-all \
    && locale-gen uk_UA.utf8 \
    && update-locale LANG=uk_UA.utf8

COPY . /var/www
WORKDIR /var/www

RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist \
    && npm init -y \
    && npm install tailwindcss postcss autoprefixer

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 80

CMD ["php-fpm"]
