<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DniController extends Controller
{
    public function buscarDni($dni)
    {
        //Token de API (ya integrado)
        $token = "ff7620efb7b68019eb90e71ec5e422e140b4b5c95748d19c4d04f124b8440e7e";

        try {
            // 🔎 Consulta a la API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get("https://apiperu.dev/api/dni/$dni");

            if (!$response->successful()) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'DNI no encontrado'
                ], 404);
            }

            $data = $response->json()['data'];

            // Devolver los datos listos para autocompletar
            return response()->json([
                'error' => false,
                'nombres'          => $data['nombres'] ?? "",
                'apellido_paterno' => $data['apellido_paterno'] ?? "",
                'apellido_materno' => $data['apellido_materno'] ?? "",
                'fecha_nacimiento' => $data['fecha_nacimiento'] ?? ""
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => true,
                'mensaje' => 'Error al consultar DNI',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}