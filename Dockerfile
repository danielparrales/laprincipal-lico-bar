FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

# Instalamos las dependencias de PHP con Composer
RUN composer install --no-dev --optimize-autoloader

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force || true && \
    sed -i "s/80/${PORT:-8080}/g" /etc/apache2/ports.conf && \
    sed -i "s/80/${PORT:-8080}/g" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground