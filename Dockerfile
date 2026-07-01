FROM php:8.4-apache

# Install system dependencies & PHP extensions needed for Laravel/SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Enable Apache mod_rewrite for Laravel routes
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set correct permissions for Laravel storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose web port
EXPOSE 80

# Run migrations and start Apache
CMD mkdir -p /var/www/html/storage/database && \
    touch /var/www/html/storage/database/database.sqlite && \
    chown -R www-data:www-data /var/www/html/storage/database && \
    php artisan migrate --force && \
    apache2-foreground