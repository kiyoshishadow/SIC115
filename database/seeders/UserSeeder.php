<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@contabilidad.com' // El campo único para buscar
            ],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin') // La contraseña por defecto
            ]
        );
    }
}
