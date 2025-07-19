# Multi-stage build for Laravel Furniture E-commerce Application
# Stage 1: Build stage with Composer and Node.js
FROM php:8.2-fpm as build

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy package.json for Node.js dependencies (if exists)
COPY package*.json ./

# Install Node.js dependencies (if package.json exists)
RUN npm ci --only=production || true

# Copy application code
COPY . .

# Build frontend assets (if needed)
RUN npm run build || true

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Stage 2: Production image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Create system user for Laravel
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Install system dependencies for production
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    cron \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Redis extension for caching
RUN pecl install redis && docker-php-ext-enable redis

# Copy built application from build stage
COPY --from=build --chown=www:www /var/www/html .

# Create necessary directories and set permissions
RUN mkdir -p \
    storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    bootstrap/cache \
    && chown -R www:www storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy environment file
COPY .env.example .env

# Generate application key
RUN php artisan key:generate || true

# Create storage symlink
RUN php artisan storage:link || true

# Set proper permissions for web server
RUN chown -R www:www /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && chmod -R 775 storage bootstrap/cache

# Create nginx configuration
RUN echo 'server { \
    listen 80; \
    server_name localhost; \
    root /var/www/html/public; \
    index index.php index.html index.htm; \
    \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
    \
    location ~ /\.ht { \
        deny all; \
    } \
}' > /etc/nginx/sites-available/default

# Create supervisor configuration
RUN echo '[supervisord] \
nodaemon=true \
user=root \
logfile=/var/log/supervisor/supervisord.log \
pidfile=/var/run/supervisord.pid \
\
[program:nginx] \
command=nginx -g "daemon off;" \
autostart=true \
autorestart=true \
stderr_logfile=/var/log/nginx/error.log \
stdout_logfile=/var/log/nginx/access.log \
\
[program:php-fpm] \
command=php-fpm -F \
autostart=true \
autorestart=true \
stderr_logfile=/var/log/php-fpm.log \
stdout_logfile=/var/log/php-fpm.log \
\
[program:laravel-queue] \
process_name=%(program_name)s_%(process_num)02d \
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3 --max-time=3600 \
autostart=true \
autorestart=true \
user=www \
numprocs=2 \
redirect_stderr=true \
stdout_logfile=/var/www/html/storage/logs/queue-worker.log \
\
[program:laravel-schedule] \
command=bash -c "while true; do php /var/www/html/artisan schedule:run; sleep 60; done" \
autostart=true \
autorestart=true \
user=www \
redirect_stderr=true \
stdout_logfile=/var/www/html/storage/logs/schedule.log' > /etc/supervisor/conf.d/supervisord.conf

# Create PHP configuration
RUN echo 'memory_limit = 512M \
upload_max_filesize = 20M \
post_max_size = 20M \
max_execution_time = 300 \
max_input_vars = 3000 \
date.timezone = "Asia/Kolkata"' > /usr/local/etc/php/conf.d/99-custom.ini

# Create health check endpoint
RUN echo '<?php \
if (file_exists(__DIR__ . "/index.php")) { \
    http_response_code(200); \
    echo "OK"; \
} else { \
    http_response_code(503); \
    echo "Service Unavailable"; \
}' > /var/www/html/public/health.php

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
    CMD curl -f http://localhost/health.php || exit 1

# Create entrypoint script
RUN echo '#!/bin/bash \
set -e \
\
# Wait for database to be ready \
echo "Waiting for database..." \
while ! php artisan migrate:status >/dev/null 2>&1; do \
    echo "Database not ready, waiting..." \
    sleep 5 \
done \
\
# Run migrations \
echo "Running migrations..." \
php artisan migrate --force \
\
# Seed database if needed \
if [ "$SEED_DATABASE" = "true" ]; then \
    echo "Seeding database..." \
    php artisan db:seed --force \
fi \
\
# Clear and cache configurations \
php artisan config:cache \
php artisan route:cache \
php artisan view:cache \
\
# Start supervisor \
echo "Starting application..." \
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /entrypoint.sh \
    && chmod +x /entrypoint.sh

# Expose ports
EXPOSE 80 9000

# Switch to non-root user for application processes
# USER www

# Set entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Labels for metadata
LABEL maintainer="FurnitureStore Dev Team"
LABEL version="1.0"
LABEL description="Laravel Furniture E-commerce Application"
LABEL org.opencontainers.image.source="https://github.com/fister12/LavarelPage"
