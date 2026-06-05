<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // En Aiven la base de datos se llama defaultdb, en local proyecto_alival
        $dbName = config('database.connections.mysql.database');

        // 1. Crear usuario de aplicación (CRUD) si no existe y darle permisos
        DB::statement("CREATE USER IF NOT EXISTS 'didacta_app'@'%' IDENTIFIED BY 'didacta_app';");
        DB::statement("GRANT SELECT, INSERT, UPDATE, DELETE ON `{$dbName}`.* TO 'didacta_app'@'%';");

        // 2. Crear usuario de solo lectura si no existe y darle permisos
        DB::statement("CREATE USER IF NOT EXISTS 'didacta_read'@'%' IDENTIFIED BY 'didacta_read';");
        DB::statement("GRANT SELECT ON `{$dbName}`.* TO 'didacta_read'@'%';");

        // Aplicar cambios
        DB::statement("FLUSH PRIVILEGES;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP USER IF EXISTS 'didacta_app'@'%';");
        DB::statement("DROP USER IF EXISTS 'didacta_read'@'%';");
        DB::statement("FLUSH PRIVILEGES;");
    }
};