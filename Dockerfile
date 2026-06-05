FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd opcache bcmath

RUN a2enmod rewrite

# Configuración OPcache
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Copiar proyecto
COPY . /var/www/html

WORKDIR /var/www/html

# Permisos iniciales para el dueño
RUN chown -R www-data:www-data /var/www/html

# Marcar el proyecto como seguro para Git
RUN git config --global --add safe.directory /var/www/html

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar dependencias de producción
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Apache apunta a /public
RUN sed -i 's#/var/www/html#/var/www/html/public#g' \
    /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Comando de arranque único: Copia .env, da permisos en vivo, genera claves, cachea y arranca Apache
CMD cp .env.example .env && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    php artisan key:generate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate:fresh --seed --force && \
    apache2-foreground