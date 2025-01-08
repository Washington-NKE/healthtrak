# Use the official PHP image from Docker Hub
FROM php:8.0-apache

# Install dependencies (optional)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd

#Install the mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Copy your PHP files into the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Expose port 80 for the web service
EXPOSE 80
