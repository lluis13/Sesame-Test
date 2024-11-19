# Start with the official PHP 8.2 image
FROM php:8.2-fpm

# Install system dependencies and clean cache
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy all files from the host machine to the container's /var/www directory
COPY . /var/www

# Run Composer install to install dependencies during the build process as root
RUN composer install --no-interaction --prefer-dist

# Fix permissions after running Composer install to ensure www-data can write
RUN chown -R www-data:www-data /var/www

# Switch to the www-data user
USER www-data
