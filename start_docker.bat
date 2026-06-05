@echo off
echo ==========================================
echo Iniciando contenedores Docker de Didacta
echo ==========================================

docker-compose down -v
docker-compose build
docker-compose up -d

echo.
echo Esperando a que MySQL este listo...

:wait
docker exec didacta_mysql mysqladmin ping -u root -proot >nul 2>&1

if %errorlevel% neq 0 (
    timeout /t 2 >nul
    goto wait
)

echo.
echo Esperando a que Laravel termine de arrancar...
timeout /t 5 >nul

echo.
echo Generando APP_KEY...
docker exec didacta_app php artisan key:generate --force

echo.
echo Arreglando permisos de Laravel...
docker exec didacta_app chmod -R 777 storage
docker exec didacta_app chmod -R 777 bootstrap/cache

echo.
echo Deteniendo workers antiguos si existen...
docker exec didacta_app pkill -f "queue:work" >nul 2>&1

echo.
echo Iniciando Queue Worker...
start cmd /k "docker exec -it didacta_app php artisan queue:work --sleep=3 --tries=3"

echo.
echo ==========================================
echo Proyecto levantado correctamente
echo ==========================================
echo Aplicacion:  http://localhost:8000
echo phpMyAdmin:  http://localhost:8080
echo Queue Worker: ACTIVO
echo ==========================================

pause