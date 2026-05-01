FROM php:8.2-apache

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    zip unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite (safe for PHP apps)
RUN a2enmod rewrite

# Copy project
COPY Saniya_Mallick/code/ /var/www/html/

# Set permissions (important fix for Apache)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80