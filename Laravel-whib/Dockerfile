# Use the official PHP image with Apache as base
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip exif pcntl bcmath

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents to the container
COPY . .

# Install Composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

# Copy Apache virtual host configuration
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Set environment variables for Laravel
ENV APP_NAME=${APP_NAME} \
    APP_ENV=${APP_ENV} \
    APP_KEY=${APP_KEY} \
    APP_DEBUG=${APP_DEBUG} \
    APP_URL=${APP_URL} \
    DB_CONNECTION=${DB_CONNECTION} \
    DB_HOST=${DB_HOST} \
    DB_PORT=${DB_PORT} \
    DB_DATABASE=${DB_DATABASE} \
    DB_USERNAME=${DB_USERNAME} \
    DB_PASSWORD=${DB_PASSWORD} \
    MAIL_MAILER=${MAIL_MAILER} \
    MAIL_HOST=${MAIL_HOST} \
    MAIL_PORT=${MAIL_PORT} \
    MAIL_USERNAME=${MAIL_USERNAME} \
    MAIL_PASSWORD=${MAIL_PASSWORD} \
    MAIL_ENCRYPTION=${MAIL_ENCRYPTION} \
    MAIL_FROM_ADDRESS=${MAIL_FROM_ADDRESS} \
    MAIL_FROM_NAME=${MAIL_FROM_NAME}

# Start Apache server
CMD ["apache2-foreground"]