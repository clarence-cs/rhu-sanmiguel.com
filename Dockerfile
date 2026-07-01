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

# Explicitly point Apache to your nested public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/rhu-sanmiguel.com/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite for Laravel routes
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory to the actual Laravel folder
WORKDIR /var/www/html

# Copy all project files
COPY . .

# Install PHP dependencies inside the nested subfolder
WORKDIR /var/www/html/rhu-sanmiguel.com
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set correct permissions for the nested storage and cache
RUN chown -R www-data:www-data /var/www/html/rhu-sanmiguel.com/storage /var/www/html/rhu-sanmiguel.com/bootstrap/cache

# Expose web port
EXPOSE 80

# Run migrations and start Apache from the nested folder perspective
CMD mkdir -p /var/www/html/rhu-sanmiguel.com/storage/database && \
    touch /var/www/html/rhu-sanmiguel.com/storage/database/database.sqlite && \
    chown -R www-data:www-data /var/www/html/rhu-sanmiguel.com/storage/database && \
    php artisan migrate --force && \
    apache2-foreground