#!/bin/sh

# Generar clave de la aplicación
php artisan key:generate --force

# Limpiar y cachear configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
php artisan migrate:fresh --seed --force

# Iniciar Apache
exec apache2-foreground