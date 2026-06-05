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
        DB::unprepared("
            CREATE TRIGGER after_event_insert
            AFTER INSERT ON events
            FOR EACH ROW
            BEGIN
                INSERT INTO event_logs (event_id, action)
                VALUES (NEW.id, 'INSERT');
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_event_insert");
    }
};