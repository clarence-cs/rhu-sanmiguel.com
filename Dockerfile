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

# Copy the CONTENTS of your subfolder straight into the main directory
COPY rhu-sanmiguel.com/ .

# Ensure an .env file exists so production configurations don't crash
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Install PHP dependencies at the root level
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Create necessary Laravel framework directories that might be missing from gitignore
RUN mkdir -p storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/views \
             storage/logs

# Create the SQLite database precisely where the environment expects it
RUN mkdir -p /var/www/html/storage/database && \
    touch /var/www/html/storage/database/database.sqlite

# Give completely open permissions to storage and cache so Apache can read/write without ownership restrictions
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose web port
EXPOSE 80

# Clean old cache files, generate an APP_KEY if missing, run migrations, and start Apache
CMD php artisan config:clear && \
    php artisan view:clear && \
    php artisan key:generate --no-interaction && \
    php artisan migrate --force && \
    apache2-foreground