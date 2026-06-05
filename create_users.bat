@echo off
echo ==========================================
echo CREANDO USUARIOS MYSQL
echo ==========================================

echo.

echo Creando usuario de aplicacion (CRUD)...

docker exec didacta_mysql mysql -u root -proot -e "CREATE USER IF NOT EXISTS 'didacta_app'@'%%' IDENTIFIED BY 'didacta_app'; GRANT SELECT, INSERT, UPDATE, DELETE ON proyecto_alival.* TO 'didacta_app'@'%%'; FLUSH PRIVILEGES;"

echo Usuario didacta_app creado correctamente.

echo.

echo Creando usuario de solo lectura...

docker exec didacta_mysql mysql -u root -proot -e "CREATE USER IF NOT EXISTS 'didacta_read'@'%%' IDENTIFIED BY 'didacta_read'; GRANT SELECT ON proyecto_alival.* TO 'didacta_read'@'%%'; FLUSH PRIVILEGES;"

echo Usuario didacta_read creado correctamente.

echo.

echo ==========================================
echo USUARIOS MYSQL CREADOS CORRECTAMENTE
echo ==========================================

pause