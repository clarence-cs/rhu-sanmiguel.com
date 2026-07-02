FROM php:8.4-apache

# Install system dependencies, Node.js, and PostgreSQL extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql

# Point Apache's root directly to the public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache mod_rewrite for Laravel routes
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy repository layout
COPY . .

# Ensure an .env file exists so configurations don't crash
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Install NPM dependencies and build your frontend assets
RUN npm install && npm run build

# Create framework folders that may be missing from your layout
RUN mkdir -p storage/framework/cache/data \
             storage/framework/sessions \
             storage/framework/views \
             storage/logs

# Open permissions completely so Apache can write to storage elements
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose web port
EXPOSE 80

# Configure environment fallback configurations, run migrations, and execute Apache
# Configure environment fallback configurations, run migrations, and execute Apache
# Configure environment fallback configurations, run migrations, and execute Apache
CMD export LOG_CHANNEL=stderr && \
    export APP_DEBUG=false && \
    export APP_ENV=production && \
    php artisan config:clear && \
    php artisan view:clear && \
    php artisan storage:link --force && \
    php artisan migrate --force && \
    apache2-foreground