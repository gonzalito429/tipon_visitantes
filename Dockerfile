FROM php:8.2-apache

# Instalar extensiones necesarias del sistema para GD y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libwebp-dev \
    pkg-config \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd

# Copiar el código al contenedor
COPY . /var/www/html/

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html

# Render usa el puerto 8080 por defecto
EXPOSE 8080
ENV PORT 8080

CMD ["apache2-foreground"]
