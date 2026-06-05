<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumSeeder extends Seeder
{
    public function run(): void
    {

        /* =========================================================
           CATEGORÍAS DEL FORO
        ========================================================= */

        DB::table('forum_categories')->insert([

            [
                'name' => 'Cena de graduación',
                'description' => 'Organización de la cena y graduación',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Confirmación de asistencia graduación',
                'description' => 'Confirmación y datos de asistentes',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);


        /* =========================================================
           TEMAS DEL FORO
        ========================================================= */

        DB::table('forum_topics')->insert([

            // =========================
            // CENA DE GRADUACIÓN
            // =========================

            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Horario graduación',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Restaurantes posibles',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // =========================
            // CONFIRMACIÓN ASISTENCIA
            // =========================

            [
                'category_id' => 2,
                'user_id' => 2,
                'title' => 'Lista de asistentes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_id' => 2,
                'user_id' => 2,
                'title' => 'Datos completos de asistentes',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);


        /* =========================================================
           MENSAJES DEL FORO
        ========================================================= */

        DB::table('forum_posts')->insert([

            // =========================
            // HORARIO GRADUACIÓN
            // =========================

            [
                'topic_id' => 1,
                'user_id' => 1,
                'content' => 'Aquí podréis hablar sobre los horarios de la graduación y resolver dudas relacionadas con el evento.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'topic_id' => 1,
                'user_id' => 3,
                'content' => 'Perfecto, me parece muy buena idea poder hablarlo por aquí.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // =========================
            // RESTAURANTES POSIBLES
            // =========================

            [
                'topic_id' => 2,
                'user_id' => 1,
                'content' => 'Podéis proponer aquí posibles restaurantes para realizar la cena de graduación.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'topic_id' => 2,
                'user_id' => 3,
                'content' => 'A mí me gustaría un restaurante que tenga menú para grupos grandes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // =========================
            // LISTA DE ASISTENTES
            // =========================

            [
                'topic_id' => 3,
                'user_id' => 2,
                'content' => 'Por aquí tendrán que escribir todas las personas que asistirán a la graduación.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'topic_id' => 3,
                'user_id' => 3,
                'content' => 'Vale, perfecto 👍',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // =========================
            // DATOS COMPLETOS
            // =========================

            [
                'topic_id' => 4,
                'user_id' => 2,
                'content' => 'Necesitamos que se envíen todos los datos completos de cada alumno que vaya a asistir.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'topic_id' => 4,
                'user_id' => 3,
                'content' => 'Vale, mi nombre completo es Alejandro Gómez Fernández.',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}