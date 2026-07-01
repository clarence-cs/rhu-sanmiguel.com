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

# Point Apache's root directly to the public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite for Laravel routes
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory to standard Apache root
WORKDIR /var/www/html

# CRUCIAL: Copy the CONTENTS of your subfolder straight into the main directory
COPY rhu-sanmiguel.com/ .

# Install PHP dependencies at the root level
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Create the SQLite database precisely where the environment expects it
RUN mkdir -p /var/www/html/storage/database && \
    touch /var/www/html/storage/database/database.sqlite

# Fix folder permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose web port
EXPOSE 80

# Run migrations and start Apache normally
CMD php artisan migrate --force && apache2-foreground