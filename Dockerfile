# Menggunakan image PHP 7.4
FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
COPY composer.lock composer.json ./
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apt-get install -y libzip-dev \
    && docker-php-ext-install zip \
    && apt-get install -y libonig-dev \
    && docker-php-ext-install mbstring \
    && apt-get install -y libxml2-dev \
    && docker-php-ext-install soap \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy aplikasi
COPY . .

# Install dependencies
RUN composer install

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
