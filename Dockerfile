FROM php:8.2-apache

# Instalamos dependencias y añadimos default-mysql-client para los backups
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip gd opcache bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Configuración de rendimiento (OPcache)
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Configuración de límites de subida en PHP (100MB para PDFs y archivos)
RUN echo "upload_max_filesize=100M" > /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size=100M" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "memory_limit=512M" >> /usr/local/etc/php/conf.d/uploads.ini

# Configuración de límites en Apache
COPY apache-limits.conf /etc/apache2/conf-available/apache-limits.conf
RUN a2enconf apache-limits

# Copiar el proyecto al contenedor
COPY . /var/www/html

WORKDIR /var/www/html

# Permisos iniciales para el dueño del servidor web
RUN chown -R www-data:www-data /var/www/html

# Marcar el proyecto como seguro para Git
RUN git config --global --add safe.directory /var/www/html

# Copiar e instalar Composer para producción
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Redirigir la raíz de Apache a la carpeta /public de Laravel
RUN sed -i 's#/var/www/html#/var/www/html/public#g' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Comando de arranque corregido (Ejecuta migraciones seguras sin borrar datos reales)
CMD cp .env.example .env && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    php artisan key:generate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force && \
    apache2-foreground