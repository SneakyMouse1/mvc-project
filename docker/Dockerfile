FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli gd zip

# Enable mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application code
# Note: In development with volumes, this is overlapping, but good for production builds
COPY src/ /var/www/html/

# Adjust permissions if needed (optional, often handled by volume or entrypoint)
RUN chown -R www-data:www-data /var/www/html
