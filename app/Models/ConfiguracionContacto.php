<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionContacto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuracion_contacto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'direccion',
        'telefono',
        'email',
        'horario_semana',
        'horario_sabado',
        'horario_domingo',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'youtube_url',
        'mapa_url',
    ];

    /**
     * Obtener la configuración de contacto (singleton).
     * Si no existe, retorna una instancia con valores por defecto.
     *
     * @return ConfiguracionContacto
     */
    public static function obtener()
    {
        $config = self::first();
        
        if (!$config) {
            $config = new self([
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
        
        return $config;
    }
}
