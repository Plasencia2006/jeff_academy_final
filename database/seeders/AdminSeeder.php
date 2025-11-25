<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Entrenador Prueba',
            'email' => 'coach@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'coach'
        ]);
    }
}