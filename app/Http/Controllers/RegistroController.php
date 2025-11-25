<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Registro;
use App\Models\Inscripcion;   
use App\Models\Plan;          

class RegistroController extends Controller
{
    /**
     * ADMIN – Mostrar todas las inscripciones
     */
    public function index()
    {
        // Obtener inscripciones con usuario y plan
        $inscripciones = Inscripcion::with(['usuario', 'plan'])->get();

        // Obtener todos los planes
        $planes = Plan::all();

        return view('admin.index', compact('inscripciones', 'planes'));
    }

    /**
     * Mostrar plataforma del usuario
     */
    public function platform()
    {
        $registro = Registro::find(session('registro_id'));

        if (!$registro) {
            return redirect()->route('inscripcion')->with('error', 'Debes iniciar sesión primero.');
        }

        return view('dashboard.platform', compact('registro'));
    }

    /**
     * Guardar el registro (con HASH manual)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_documento' => 'required|string|in:DNI,CE,PASAPORTE',
            'nro_documento' => 'required|string|max:20|unique:registros,nro_documento',
            'genero' => 'required|string|in:Masculino,Femenino,Otro',
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'nro_celular' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:registros,email',
            'password' => 'required|string|min:8|confirmed',
            'terminos' => 'required|accepted',
        ], [
            'nro_documento.unique' => 'Este número de documento ya está registrado.',
            'email.unique' => 'Este correo ya está registrado.',
            'terminos.accepted' => 'Debes aceptar los términos.',
        ]);

        // Crear registro con HASH manual
        $registro = Registro::create([
            'tipo_documento' => $validated['tipo_documento'],
            'nro_documento' => $validated['nro_documento'],
            'genero' => $validated['genero'],
            'nombres' => $validated['nombres'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'nro_celular' => $validated['nro_celular'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Guardar sesión
        session(['registro_id' => $registro->id]);

        return redirect()->route('platform')->with('success', '¡Registro exitoso! Bienvenido a Jeff Academy.');
    }

    /**
     * Login de usuario
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $registro = Registro::where('email', $validated['email'])->first();

        if ($registro && Hash::check($validated['password'], $registro->password)) {
            session(['registro_id' => $registro->id]);
            return redirect()->route('platform')->with('success', '¡Bienvenido de vuelta!');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->onlyInput('email');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->forget('registro_id');
        return redirect()->route('inscripcion')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Mostrar datos del usuario
     */
    public function misDatos()
    {
        $registro = Registro::find(session('registro_id'));

        if (!$registro) {
            return redirect()->route('inscripcion')->with('error', 'Debes iniciar sesión primero.');
        }

        // Obtener planes adquiridos por este registro
        $planesAdquiridos = collect(); // Colección vacía por defecto
        
        try {
            // Verificar si existe el modelo PlanSubscription
            if (class_exists('\App\Models\PlanSubscription')) {
                $planesAdquiridos = \App\Models\PlanSubscription::where('user_id', $registro->id)
                    ->with(['plan' => function($query) {
                        $query->select('id', 'nombre', 'precio', 'duracion', 'descripcion');
                    }])
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } catch (\Exception $e) {
            \Log::error('Error al obtener planes adquiridos: ' . $e->getMessage());
            // En caso de error, mantener la colección vacía
        }

        // También obtener planes activos para mostrar como disponibles
        $planes = Plan::where('estado', 'activo')->get();

        return view('dashboard.mis-datos', compact('registro', 'planesAdquiridos', 'planes'));
    }

    /**
     * Mostrar planes disponibles (sin navbar/footer)
     */
    public function elegirPlan()
    {
        $planes = Plan::where('estado', 'activo')->get();
        return view('dashboard.elegir-plan', compact('planes'));
    }

    /**
     * Procesar pago
     */
    public function procesarPago(Request $request)
    {
        try {
            $planId = $request->plan_id;

            return response()->json([
                'success' => true,
                'message' => 'Redirigiendo a pasarela de pago...',
                'redirect_url' => url('/pago/procesar/' . $planId)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizar(Request $request)
    {
        $registro = Registro::find(session('registro_id'));
        
        if (!$registro) {
            return redirect()->route('inscripcion')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $validated = $request->validate([
            'tipo_documento' => 'required|string|in:DNI,CE,PASAPORTE',
            'genero' => 'required|string|in:Masculino,Femenino,Otro',
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date|before:today',
            'nro_celular' => 'required|string|max:15',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('registros')->ignore($registro->id)
            ],
        ]);
        
        try {
            $registro->update($validated);
            return redirect()->route('registro.mis-datos')
                        ->with('success', 'Tus datos han sido actualizados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar los datos: ' . $e->getMessage());
        }
    }

    public function cambiarPassword(Request $request)
    {
        $registro = Registro::find(session('registro_id'));
        
        if (!$registro) {
            return redirect()->route('inscripcion')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es requerida.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);
        
        if (!Hash::check($validated['current_password'], $registro->password)) {
            return back()->with('error', 'La contraseña actual es incorrecta.');
        }
        
        try {
            $registro->update(['password' => Hash::make($validated['password'])]);
            return redirect()->route('registro.mis-datos')
                        ->with('success', 'Tu contraseña ha sido actualizada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cambiar la contraseña: ' . $e->getMessage());
        }
    }

}
