FROM php:8.2-apache

# 1. Define Build Arguments for Vite (Pusher/Chat)
# These allow Render to "pass" your keys into the JavaScript bundle
ARG VITE_PUSHER_APP_KEY
ARG VITE_PUSHER_APP_CLUSTER
ENV VITE_PUSHER_APP_KEY=$VITE_PUSHER_APP_KEY
ENV VITE_PUSHER_APP_CLUSTER=$VITE_PUSHER_APP_CLUSTER

# 2. Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    gnupg

# 3. Install Node.js 20.x
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 4. Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd curl

# 5. Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Set working directory
WORKDIR /var/www/html

# 7. Copy all project files
COPY . .

# 8. Install Laravel dependencies (including the new Brevo driver)
RUN composer install --no-dev --optimize-autoloader

# 9. Install NPM and Build assets (This now uses the ARG keys from Step 1)
RUN npm install && npm run build

# 10. Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Apache Configuration
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]