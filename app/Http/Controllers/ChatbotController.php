<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionContacto;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function getData()
    {
        // Obtener configuración
        $config = ConfiguracionContacto::obtener();
        
        // Obtener planes activos
        $planes = Plan::where('estado', 'activo')->get(['nombre', 'precio', 'duracion', 'tipo']);
        
        // Obtener disciplinas activas
        $disciplinas = \App\Models\Disciplina::where('estado', 'activo')
            ->get(['nombre', 'categoria', 'edad_minima', 'edad_maxima']);
            
        return response()->json([
            'config' => $config,
            'planes' => $planes,
            'disciplinas' => $disciplinas
        ]);
    }
}
