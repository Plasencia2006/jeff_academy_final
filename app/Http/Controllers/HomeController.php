<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Noticia;
use Illuminate\Support\Facades\Hash;
use App\Models\Disciplina;
use App\Models\Plan;

class HomeController extends Controller
{
    /**
     * Mostrar la página principal
     */
    public function index()
    {
        // Obtener TODAS las noticias ordenadas por fecha descendente (más recientes primero)
        $noticias = Noticia::latest()->get();
        $disciplinas = Disciplina::where('estado', 'activa')->get();

        return view('pages.index', compact('noticias', 'disciplinas'));
    }

    /**
     * Listado público de noticias (paginado)
     */
    public function noticias(Request $request)
    {
        $query = Noticia::query()->latest();

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('titulo', 'like', "%{$q}%")
                    ->orWhere('descripcion', 'like', "%{$q}%")
                    ->orWhere('categoria', 'like', "%{$q}%");
            });
        }

        $noticias = $query->paginate(9)->withQueryString();

        return view('pages.noticias.index', compact('noticias'));
    }

    /**
     * Detalle de noticia pública
     */
    public function noticiaShow($id)
    {
        $noticia = Noticia::findOrFail($id);
        $relacionadas = Noticia::where('id', '!=', $id)->latest()->limit(4)->get();
        return view('pages.noticias.show', compact('noticia', 'relacionadas'));
    }

    /**
     * Página pública de Contacto
     */
    public function contacto()
    {
        $config = \App\Models\ConfiguracionContacto::obtener();
        return view('pages.contacto', compact('config'));
    }

    /**
     * Página de Nosotros
     */
    public function nosotros()
    {
        return view('pages.nosotros');
    }

    /**
     * Página de Planes y Precios
     */
    public function planes()
    {
        // Obtener planes REALES de la base de datos
        $planes = Plan::where('estado', 'activo')->get();

        return view('pages.planes', compact('planes'));
    }

    /**
     * Mostrar formulario de inscripción público
     */
    public function inscripcion()
    {
        return view('pages.inscripcion');
    }

    /**
     * Procesar formulario de inscripción público
     */
    public function storeInscripcion(Request $request)
    {
        $validated = $request->validate([
            'tipo_documento' => ['required', 'string', 'in:DNI,CE,Pasaporte'],
            'nro_documento' => ['required', 'string', 'max:20'],
            'genero' => ['required', 'string', 'in:Masculino,Femenino'],
            'nombres' => ['required', 'string', 'max:100'],
            'apellido_paterno' => ['required', 'string', 'max:100'],
            'apellido_materno' => ['required', 'string', 'max:100'],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'nro_celular' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'max:255'],
            'terminos' => ['accepted']
        ], [
            'tipo_documento.required' => 'El tipo de documento es obligatorio.',
            'tipo_documento.in' => 'El tipo de documento no es válido.',
            'nro_documento.required' => 'El número de documento es obligatorio.',
            'genero.required' => 'El género es obligatorio.',
            'genero.in' => 'El género seleccionado no es válido.',
            'nombres.required' => 'Los nombres son obligatorios.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'nro_celular.required' => 'El número de celular es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'terminos.accepted' => 'Debes aceptar los términos y condiciones.'
        ]);

        // Aquí puedes guardar los datos en la base de datos si tienes un modelo de Inscripcion
        // Por ahora, simplemente redirigimos con un mensaje de éxito
        
        return redirect()->route('inscripcion')
            ->with('success', '¡Inscripción enviada exitosamente! Nos pondremos en contacto contigo pronto.');
    }

    /**
     * Mostrar formulario de login
     */
    public function login()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }
        return view('pages.login');
    }

    /**
     * Procesar login
     */
    public function doLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'regex:/@gmail\.com$/'],
            'password' => ['required', 'min:4'],
            'role' => ['required', 'in:admin,coach,player']
        ], [
            'email.regex' => 'El email debe ser de Gmail (@gmail.com)',
            'role.required' => 'Debes seleccionar un rol',
        ]);

        // Buscar usuario por email
        $user = User::where('email', $validated['email'])->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if ($user && Hash::check($validated['password'], $user->password)) {
            // Verificar si la cuenta está activa
            if ($user->estado === 'inactivo') {
                return back()->withErrors([
                    'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
                ])->onlyInput('email');
            }

            // Verificar si el rol coincide
            if ($user->role === $validated['role']) {
                Auth::login($user);
                
                // Redirigir según el rol
                return $this->redirectByRole($user->role);
            } else {
                return back()->withErrors(['role' => 'El rol no coincide con la cuenta.']);
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.',
        ])->onlyInput('email');
    }

    /**
     * Mostrar formulario de registro
     */
    public function register()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }
        return view('pages.register');
    }

    /**
     * Procesar registro
     */
    public function doRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'regex:/@gmail\.com$/'],
            'password' => ['required', 'min:4', 'confirmed'],
            'role' => ['required', 'in:player']
        ], [
            'email.regex' => 'El email debe ser de Gmail (@gmail.com)',
            'email.unique' => 'Este email ya está registrado.',
            'role.required' => 'Debes seleccionar un rol',
        ]);

        try {
            // Crear nuevo usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role']
            ]);

            // Autenticar el usuario
            Auth::login($user);

            return redirect('/dashboard')
                ->with('success', '¡Bienvenido a Jeff Academy! Tu cuenta ha sido creada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la cuenta. Intenta nuevamente.']);
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Redirigir según el rol del usuario
     */
    private function redirectByRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect('/admin/dashboard')
                    ->with('success', '¡Bienvenido Administrador!');
            case 'coach':
                return redirect('/coach/dashboard')
                    ->with('success', '¡Bienvenido Entrenador!');
            case 'player':
                return redirect('/player/dashboard')
                    ->with('success', '¡Bienvenido Jugador!');
            default:
                return redirect('/dashboard');
        }
    }


    /** Pasarela de pagos  */

    public function elegirPlan()
    {
        // Verificar si ya tiene suscripción activa
        if (Auth::check() && Auth::user()->hasActiveSubscription()) {
            return redirect()->route('platform')->with('info', 'Ya tienes una suscripción activa.');
        }
    
        $planes = Plan::where('estado', 'activo')->get();
        return view('dashboard.elegir-plan', compact('planes'));
    }
    
    public function procesarInscripcionCompleta(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id'
        ]);
    
        // Redirigir al formulario de pago
        return redirect()->route('payment.form', ['plan' => $request->plan_id]);
    }

    
    //CUENTA PARA CREAR EL ADMINISTRADOR
    public function crearAdmin()
    {
        // Verifica si ya existe el admin
        if (User::where('email', 'JeffAdministrador@gmail.com')->exists()) {
            return "El administrador ya existe.";
        }

        User::create([
            'name' => 'Administrador',
            'email' => 'JeffAdministrador@gmail.com',
            'password' => Hash::make('87654321'),
            'role' => 'admin',
            'estado' => 'activo'
        ]);

        return "Administrador creado correctamente.";
    }

}