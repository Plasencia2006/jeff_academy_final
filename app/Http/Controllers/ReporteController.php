<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Noticia;
use App\Models\Plan;
use App\Models\Disciplina;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function mostrarReportes()
    {
        return view('reportes.reportes');
    }

    public function generarReporte(Request $request)
    {
        $tipo = $request->tipo_reporte;
        $formato = $request->formato;

        // Obtener datos según el tipo
        $datos = match($tipo) {
            'usuarios' => User::all(),
            'noticias' => Noticia::all(),
            'planes' => Plan::all(),
            'disciplinas' => Disciplina::all(),
            'inscripciones' => Inscripcion::with(['jugador', 'entrenador'])->get(),
            'asignar_jugadores' => Inscripcion::with(['jugador', 'entrenador'])->whereNotNull('entrenador_id')->get(),
            'entrenadores' => User::where('role', 'coach')->get(),
            default => collect()
        };

        // Títulos
        $titulos = [
            'usuarios' => 'Reporte de Usuarios',
            'noticias' => 'Reporte de Noticias', 
            'planes' => 'Reporte de Planes',
            'disciplinas' => 'Reporte de Disciplinas',
            'inscripciones' => 'Reporte de Inscripciones',
            'asignar_jugadores' => 'Reporte de Jugadores Asignados',
            'entrenadores' => 'Reporte de Entrenadores'
        ];

        $titulo = $titulos[$tipo] ?? 'Reporte';

        if ($formato === 'pdf') {
            // Si DomPDF no está instalado, redirigir con error
            if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
                return back()->with('error', 'Funcionalidad PDF temporalmente no disponible. Instalando dependencias...');
            }
            return $this->descargarPDF($datos, $titulo);
        } else {
            return $this->descargarExcel($datos, $titulo);
        }
    }

    private function descargarPDF($datos, $titulo)
    {
        // Verificar nuevamente que DomPDF esté disponible
        if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            throw new \Exception('DomPDF no está instalado. Ejecuta: composer require barryvdh/laravel-dompdf');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reportes.simple', [
            'datos' => $datos,
            'titulo' => $titulo,
            'fecha' => now()->format('d/m/Y H:i'),
            'total' => $datos->count()
        ]);

        return $pdf->download("reporte_{$titulo}.pdf");
    }

    private function descargarExcel($datos, $titulo)
    {
        // Exportación simple a CSV (más fácil que Excel)
        $fileName = "reporte_{$titulo}.csv";
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($datos) {
            $file = fopen('php://output', 'w');
            
            // Encabezados
            fputcsv($file, ['ID', 'Nombre', 'Email/Descripción', 'Fecha', 'Estado']);
            
            // Datos
            foreach ($datos as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name ?? $item->titulo ?? $item->nombre ?? 'N/A',
                    $item->email ?? $item->descripcion ?? ($item->contenido ? \Str::limit(strip_tags($item->contenido), 50) : 'N/A'),
                    ($item->created_at ?? now())->format('d/m/Y'),
                    $item->estado ?? ($item->activo ? 'Activo' : 'Inactivo') ?? 'Activo'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}