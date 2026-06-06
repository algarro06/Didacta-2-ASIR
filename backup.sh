#!/bin/bash

echo "Esperando a la base de datos de Aiven..."

# Intentar conectar usando las variables de entorno de tu servidor
until mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USERNAME" -p"$DB_PASSWORD" --ssl-mode=REQUIRED -e "SELECT 1" >/dev/null 2>&1
do
    echo "Base de datos no disponible todavía. Reintentando en 10 segundos..."
    sleep 10
done

echo "¡Conexión con Aiven establecida con éxito!"
echo "Servicio de backups automáticos iniciado..."

while true
do
    FECHA=$(date +"%Y-%m-%d_%H-%M-%S")

    echo "Generando backup en Aiven: $FECHA"

    # mysqldump adaptado a Aiven con SSL obligatorio
    mysqldump \
        -h "$DB_HOST" \
        -P "$DB_PORT" \
        -u "$DB_USERNAME" \
        -p"$DB_PASSWORD" \
        --ssl-mode=REQUIRED \
        --column-statistics=0 \
        "$DB_DATABASE" \
        > /backups/backup_$FECHA.sql 2>error_backup.log

    if [ $? -eq 0 ]; then
        echo "Backup completado con éxito: backup_$FECHA.sql"
    else
        echo "ERROR al generar el backup. Revisa 'error_backup.log'"
    fi

    # Esperar 24 horas (86400 segundos) para el siguiente backup
    echo "Esperando 24 horas para el próximo ciclo..."
    sleep 86400
done