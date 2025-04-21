<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Usuarios')->updateOrInsert([
            'id_usuario' => 1,
            'id_rol' => 1, // Rol de administrador
            'nombre' => 'Carlos',
            'apellido' => 'Pérez',
            'telefono' => '555-1234',
            'email' => 'admin@ejemplo.com',
            'password' => Hash::make('admin123'), // Encriptación segura de la contraseña
            'fecha_registro' => now()
        ]);
        DB::table('Usuarios')->updateOrInsert(
            ['email' => 'usuario@ejemplo.com'], // condición para evitar duplicados
            [
                'id_usuario' => 2,
                'id_rol' => 2,
                'nombre' => 'Lucía',
                'apellido' => 'Gómez',
                'telefono' => '555-5678',
                'password' => Hash::make('usuario123'),
                'fecha_registro' => now(),
            ]
        );
    }
}
