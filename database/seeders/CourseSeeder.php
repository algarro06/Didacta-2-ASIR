<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('course')->upsert([
            [
                'title'         => 'Matematicas',
                'view_name'     => 'matematicas',
                'description'   => 'Curso de Matemáticas: álgebra, ecuaciones y geometría.',
                'status'        => 'Activo',
                'creation_date' => now(),
            ],
            [
                'title'         => 'Historia',
                'view_name'     => 'historia',
                'description'   => 'Curso de Historia: civilizaciones y eventos históricos.',
                'status'        => 'Activo',
                'creation_date' => now(),
            ],
            [
                'title'         => 'Lengua',
                'view_name'     => 'lengua',
                'description'   => 'Curso de Lengua: gramática, ortografía y literatura.',
                'status'        => 'Activo',
                'creation_date' => now(),
            ],
            [
                'title'         => 'Biologia',
                'view_name'     => 'biologia',
                'description'   => 'Curso de Biología: células, ecosistemas y genética.',
                'status'        => 'Activo',
                'creation_date' => now(),
            ],
        ], ['title'], ['view_name', 'description', 'status']);
    }
}
