FROM php:8.1-fpm

# Install SQLite and PDO SQLite extension
RUN apt-get update && apt-get install -y \
    git \
    sqlite3 \
    libsqlite3-dev \
    pdo_sqlite \
    zip \
    && docker-php-ext-install 


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Set working directory
WORKDIR /var/www/app

COPY composer.json .

# Install PHP dependencies
RUN composer update

EXPOSE 9000
