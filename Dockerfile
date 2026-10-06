# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos dependencias del sistema y extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

# Limpiamos caché de apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos extensiones de PHP requeridas por Laravel (incluyendo pdo_pgsql para PostgreSQL)
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Habilitamos mod_rewrite de Apache para las URLs amigables de Laravel
RUN a2enmod rewrite

# Instalamos Composer (el gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecemos el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiamos todo el contenido de tu proyecto al contenedor
COPY . /var/www/html

# Cambiamos la ruta raíz de Apache para que apunte a la carpeta 'public' de Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Ajustamos permisos de las carpetas de almacenamiento y caché de Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto por defecto que Render asigna mediante la variable $PORT
EXPOSE 8080

# Script de inicio para ejecutar migraciones y levantar Apache adaptado al puerto de Render
CMD php artisan config:cache && \
    php artisan migrate --force && \
    sed -i "s/80/\$PORT/g" /etc/apache2/ports.conf && \
    sed -i "s/80/\$PORT/g" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground