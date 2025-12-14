<?php

namespace Database\Seeders;

// Asegúrate de importar Hash para encriptar la contraseña
use Illuminate\Support\Facades\Hash; 
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Llamamos al Seeder de ejercicios (para que no se borren)
        $this->call([
            EjerciciosSeeder::class,
        ]);

        // 2. Creamos TU usuario administrador
        User::factory()->create([
            'nombre' => 'Administrador',
            'email' => 'admin@admin.com', // Usa este correo fácil
            'password' => Hash::make('12345678'), // <--- TU CONTRASEÑA NUEVA
            'rol' => 'estudiante', // <--- IMPORTANTE para poder crear/editar ejercicios
        ]);
    }
}