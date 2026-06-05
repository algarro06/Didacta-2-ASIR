@echo off
echo Ejecutando migraciones y seeders...

docker exec didacta_app php artisan config:clear
docker exec didacta_app php artisan cache:clear
docker exec didacta_app php artisan config:cache

docker exec didacta_app php artisan migrate:fresh --seed --force

echo Migraciones y seeders ejecutados correctamente
pause
