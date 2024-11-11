# Use an official PHP CLI runtime as a parent image
FROM php:8.2-cli

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libssl-dev \
    pkg-config \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl pdo pdo_mysql zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files and set permissions
COPY --chown=www-data:www-data . /var/www/html

# Set permissions for the www-data user
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Switch to www-data user
USER www-data

# Install PHP dependencies using Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port 8080 for PHP’s built-in server
EXPOSE 8080

# Start the Slim application using PHP’s built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
