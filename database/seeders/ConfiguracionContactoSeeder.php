<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfiguracionContacto;

class ConfiguracionContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConfiguracionContacto::create([
            'direccion' => 'Trujillo, La Libertad - Perú',
            'telefono' => '+51 921456783',
            'email' => 'contacto@jeffacademy.pe',
            'horario_semana' => '8:00 AM - 8:00 PM',
            'horario_sabado' => '8:00 am - 8:00 pm',
            'horario_domingo' => 'Cerrado',
            'facebook_url' => 'https://facebook.com/jeffacademy',
            'twitter_url' => 'https://twitter.com/jeffacademy',
            'instagram_url' => 'https://instagram.com/jeffacademy',
            'youtube_url' => 'https://youtube.com/@jeffacademy',
            'mapa_url' => 'https://www.google.com/maps?q=Trujillo,Peru&output=embed',
        ]);
    }
}
