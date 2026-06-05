<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Userr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('role')->count() == 0) {
            DB::table('role')->insert([
                ['id_role' => 1, 'name' => 'admin', 'description' => 'Administrador'],
                ['id_role' => 2, 'name' => 'profesor', 'description' => 'Profesor'],
                ['id_role' => 3, 'name' => 'alumno', 'description' => 'Alumno'],
            ]);
        }

        Userr::create([
            'name' => 'Admin',
            'surname' => 'Principal',
            'mail' => 'admin@didacta.com',
            'password' => Hash::make('admin123'),
            'id_role' => 1,
            'status' => 'Activo',
        ]);

        Userr::create([
            'name' => 'Profesor',
            'surname' => 'Demo',
            'mail' => 'profe@didacta.com',
            'password' => Hash::make('profesor123'),
            'id_role' => 2,
            'status' => 'Activo',
        ]);

        Userr::create([
            'name' => 'Alumno',
            'surname' => 'Test',
            'mail' => 'alumno@didacta.com',
            'password' => Hash::make('alumno123'),
            'id_role' => 3,
            'status' => 'Activo',
        ]);
    }
}