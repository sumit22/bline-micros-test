# Use the official PHP image
FROM php:8.2-cli

# Install PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-install zip

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the project files into the container
COPY . /var/www/html

# Fix permissions for the project directory
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Install PHP dependencies with Composer, allowing for network access and using the cache
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --ignore-platform-reqs

# Expose port 8080
EXPOSE 8080

# Start the Slim application using PHP's built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
