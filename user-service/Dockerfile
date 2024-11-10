# Use the official PHP image
FROM php:8.2-cli


# Install PHP zip extension
RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev \
    && docker-php-ext-install zip

# Install other dependencies
RUN apt-get install -y git unzip

# Set the working directory inside the container
WORKDIR /var/www/html

# Install necessary extensions (if required)
#RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the project files into the container
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 8080
EXPOSE 8080

# Start the Slim application using PHP's built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
