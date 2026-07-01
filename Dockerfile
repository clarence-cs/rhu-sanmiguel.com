FROM php:8.4-apache

# Install system dependencies, Node.js, and SQLite extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_sqlite

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
             storage/logs \
             database

# Create the SQLite database precisely where your config file expects it
RUN touch /var/www/html/database/database.sqlite

# Open permissions completely so Apache and SQLite can write to both directories
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Expose web port
EXPOSE 80

# Configure environment fallback configurations, run migrations, and execute Apache
CMD export LOG_CHANNEL=stderr && \
    export APP_DEBUG=false && \
    export APP_ENV=production && \
    export APP_URL=https://rhu-sanmiguel-com.onrender.com && \
    export DB_CONNECTION=sqlite && \
    export DB_DATABASE=/var/www/html/database/database.sqlite && \
    php artisan config:clear && \
    php artisan view:clear && \
    php artisan key:generate --no-interaction && \
    php artisan migrate --force && \
    apache2-foreground