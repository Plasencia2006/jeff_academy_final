<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\EntrenamientoController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\PagoStripeController;
use App\Http\Controllers\ReporteController;

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');

// Nosotros
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');

// Noticias públicas
Route::get('/noticias', [HomeController::class, 'noticias'])->name('noticias.index');
Route::get('/noticias/{id}', [HomeController::class, 'noticiaShow'])->name('noticias.show');

// Contacto público
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');

// Planes y Precios


// Inscripción pública (Vista)
Route::get('/inscripcion', [HomeController::class, 'inscripcion'])->name('inscripcion');

// Sistema de Registro de Usuarios (nuevo sistema separado)
Route::post('/registro', [\App\Http\Controllers\RegistroController::class, 'store'])->name('registro.store');
Route::post('/registro/login', [\App\Http\Controllers\RegistroController::class, 'login'])->name('registro.login');

// Rutas protegidas para usuarios registrados (requieren sesión de registro)
Route::middleware(['web'])->group(function () {
    Route::get('/platform', [\App\Http\Controllers\RegistroController::class, 'platform'])->name('platform');
    Route::post('/registro/logout', [\App\Http\Controllers\RegistroController::class, 'logout'])->name('registro.logout');
    Route::get('/mis-datos', [\App\Http\Controllers\RegistroController::class, 'misDatos'])->name('registro.mis-datos');
    Route::get('/elegir-plan', [\App\Http\Controllers\RegistroController::class, 'elegirPlan'])->name('registro.elegir-plan');

});


// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::post('/login', [HomeController::class, 'doLogin'])->name('do.login');
    
    Route::get('/register', [HomeController::class, 'register'])->name('register');
    Route::post('/register', [HomeController::class, 'doRegister'])->name('do.register');
});


// Ruta de logout es para cerrar sesión
Route::post('/logout', [HomeController::class, 'logout'])->name('logout')->middleware('auth');

// Eliminar cuenta
Route::delete('/eliminar-cuenta', [RegistroController::class, 'eliminarCuenta'])
    ->name('registro.eliminar-cuenta')
    ->middleware('auth');


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        // Redirigir según el rol
        $role = auth()->user()->role;
        return match($role) {
            'admin' => redirect('/admin/dashboard'),
            'coach' => redirect('/coach/dashboard'),
            'player' => redirect('/player/dashboard'),
            default => redirect('/')
        };
    })->name('dashboard');
});


// Rutas para Administrador
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Usuarios
    Route::post('/usuarios', [AdminController::class, 'storeUsuario'])->name('admin.usuarios.store');
    Route::put('/usuarios/{id}', [AdminController::class, 'updateUsuario'])->name('usuarios.update');
    Route::put('/usuarios/{id}/toggle', [AdminController::class, 'destroyUsuario'])->name('usuarios.toggle');

   
    // Actualizar datos básicos (nombre, email, telefono, rol)
    Route::put('/usuarios/{id}', [AdminController::class, 'updateUsuario'])->name('usuarios.update');
    
    // Cambiar contraseña (solo admin)
    Route::put('/usuarios/{id}/password', [AdminController::class, 'updatePassword'])->name('usuarios.password');
    Route::put('/usuarios/{id}/password', [AdminController::class, 'updatePassword'])
        ->name('usuarios.password');

    // Inscripciones
    Route::post('/inscripciones', [AdminController::class, 'storeInscripcion'])->name('admin.inscripciones.store');

    // Entrenamientos
    Route::post('/entrenamientos', [AdminController::class, 'storeEntrenamiento'])->name('admin.entrenamientos.store');

    // Noticias
    Route::post('/noticias', [AdminController::class, 'storeNoticia'])->name('admin.noticias.store');
    Route::delete('/noticias/{id}', [AdminController::class, 'destroyNoticia'])->name('admin.noticias.destroy');
    Route::put('/noticias/{id}', [AdminController::class, 'updateNoticia'])->name('admin.noticias.update');
    
    // Gestión de pagos
    Route::post('/confirmar-pago', [AdminController::class, 'confirmarPago'])->name('admin.confirmar-pago');
    Route::post('/registrar-pago-manual', [AdminController::class, 'registrarPagoManual'])->name('admin.registrar-pago-manual');

    // Rutas para Planes
    Route::post('/admin/planes', [AdminController::class, 'storePlan'])->name('admin.planes.store');
    Route::put('/admin/planes/{plan}', [AdminController::class, 'updatePlan'])->name('admin.planes.update');
    Route::delete('/admin/planes/{plan}', [AdminController::class, 'destroyPlan'])->name('admin.planes.destroy');
    // Asegúrate de tener una ruta para la página de planes
    Route::get('/planes', [App\Http\Controllers\AdminController::class, 'planes'])->name('planes');
    // Asegúrate de que esta ruta use el controlador correcto

    // Rutas para Disciplinas
    Route::post('/admin/disciplinas', [AdminController::class, 'storeDisciplina'])->name('admin.disciplinas.store');
    Route::put('/admin/disciplinas/{disciplina}', [AdminController::class, 'updateDisciplina'])->name('admin.disciplinas.update');
    Route::delete('/admin/disciplinas/{disciplina}', [AdminController::class, 'destroyDisciplina'])->name('admin.disciplinas.destroy');

    // Reportes
    Route::post('/reportes/generar', [AdminController::class, 'generarReporte'])->name('admin.reportes.generar');

    // Profile routes
    Route::put('/perfil/update', [AdminController::class, 'updateProfile'])->name('admin.perfil.update');
    
    // Messaging routes
    Route::get('/mensajes/{conversacion}', [AdminController::class, 'getMensajes']);
    Route::post('/mensajes/nuevo', [AdminController::class, 'nuevoMensaje']);
    Route::post('/mensajes/enviar', [AdminController::class, 'enviarMensaje']);
});


// Rutas para Entrenador
Route::middleware(['auth', 'role:coach'])->prefix('coach')->group(function () {

    // DASHBOARD 
    Route::get('/dashboard', [AsistenciaController::class, 'index'])->name('coach.dashboard');

    // ASISTENCIAS 
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('coach.asistencias.store');

    // ESTADÍSTICAS
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
    Route::post('/estadisticas/store', [EstadisticaController::class, 'store'])->name('estadisticas.store');
    Route::get('/estadisticas/jugador/{inscripcionId}', [EstadisticaController::class, 'getJugadorData'])
        ->name('estadisticas.getJugadorData');
    Route::put('/estadisticas/{id}', [EstadisticaController::class, 'update'])->name('estadisticas.update');
    Route::delete('/estadisticas/{id}', [EstadisticaController::class, 'destroy'])->name('estadisticas.destroy');



    // ENTRENAMIENTOS 
    // Crear (POST)
    Route::post('/horarios', [EntrenamientoController::class, 'storeFromCoach'])
        ->name('coach.horarios.store');

    // Actualizar (PUT)
    Route::put('/horarios/{entrenamiento}', [EntrenamientoController::class, 'updateFromCoach'])
        ->name('coach.horarios.update');

    // Eliminar (DELETE)
    Route::delete('/horarios/{id}', [EntrenamientoController::class, 'destroyFromCoach'])
        ->name('coach.horarios.destroy');

    // Mostrar detalles en modal con fetch()
    Route::get('/entrenamientos/{entrenamiento}', [EntrenamientoController::class, 'showFromCoach'])
        ->name('coach.entrenamientos.show');

    // PERFIL
    Route::get('/perfil', [CoachController::class, 'perfil'])->name('coach.perfil');
    Route::put('/perfil/update', [CoachController::class, 'update'])->name('coach.perfil.update');
    Route::put('/perfil/update-image', [CoachController::class, 'updateImage'])->name('coach.perfil.update-image');

    // NOTIFICACIONES 
    // Route::get('/notificaciones', [CoachNotificationController::class, 'index'])->name('coach.notificaciones'); // TODO: Create CoachNotificationController

    // OBSERVACIONES TÉCNICAS 
    Route::get('/observaciones', [ObservacionController::class, 'index'])->name('coach.observaciones.index');
    Route::post('/observaciones', [ObservacionController::class, 'store'])->name('coach.observaciones.store');
    Route::put('/observaciones/{id}', [ObservacionController::class, 'update'])->name('coach.observaciones.update');
    Route::delete('/observaciones/{id}', [ObservacionController::class, 'destroy'])->name('coach.observaciones.destroy');

    // AVISOS
    Route::get('/avisos', [App\Http\Controllers\AnuncioController::class, 'index'])->name('coach.avisos');
    Route::post('/anuncios', [App\Http\Controllers\AnuncioController::class, 'store'])->name('anuncios.store');
    Route::put('/anuncios/{id}', [App\Http\Controllers\AnuncioController::class, 'update'])->name('anuncios.update');
    Route::delete('/anuncios/{id}', [App\Http\Controllers\AnuncioController::class, 'destroy'])->name('anuncios.destroy');
    Route::post('/anuncios/{id}/toggle', [App\Http\Controllers\AnuncioController::class, 'toggleActivo'])->name('anuncios.toggle');

});


// Rutas para Jugador
Route::middleware(['auth', 'role:player'])->prefix('player')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');

    // PERFIL
    Route::put('/perfil/update-image', [PlayerController::class, 'updateImage'])->name('player.update-image');
    Route::put('/perfil/update', [PlayerController::class, 'updateProfile'])->name('player.update-profile');
    Route::put('/coach/perfil/update-image', [CoachController::class, 'updateImage'])->name('player.perfil.update-image');

    
    // ASISTENCIA Y RENDIMIENTO
    Route::get('/asistencia', [PlayerController::class, 'asistencia'])->name('player.asistencia');
    Route::get('/rendimiento', [PlayerController::class, 'rendimiento'])->name('player.rendimiento');
    
    // AVISOS
    Route::get('/anuncios', [PlayerController::class, 'anuncios'])->name('player.anuncios');
    
    // PAGOS
    Route::get('/pagos', [PlayerController::class, 'pagos'])->name('player.pagos');

    // ENTRENADOR
    Route::get('/entrenador', [PlayerController::class, 'entrenador'])->name('player.entrenador');

    // AYUDA
    Route::get('/ayuda', [PlayerController::class, 'ayuda'])->name('player.ayuda');

});

/**Pasarela de pagos  */

// Rutas de Pagos
Route::middleware(['auth'])->group(function () {
    // Selección de planes
    //Route::get('/elegir-plan', [App\Http\Controllers\RegistroController::class, 'elegirPlan'])->name('elegir.plan');
    Route::post('/procesar-inscripcion', [App\Http\Controllers\RegistroController::class, 'procesarInscripcionCompleta'])->name('inscripcion.completa');
    
    // Proceso de pago
    Route::get('/pago/procesar/{plan}', [App\Http\Controllers\PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/pago/create-intent', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent'])->name('payment.create-intent');
    Route::post('/pago/confirmar', [App\Http\Controllers\PaymentController::class, 'confirmPayment'])->name('payment.confirm');
    
    // Historial de pagos
    Route::get('/mis-pagos', [App\Http\Controllers\PaymentController::class, 'paymentHistory'])->name('payment.history');
    Route::get('/mis-pagos/{id}', [App\Http\Controllers\PaymentController::class, 'paymentDetail'])->name('payment.detail');
    
    // Renovación
    Route::post('/renovar-suscripcion', [App\Http\Controllers\PaymentController::class, 'renewSubscription'])->name('subscription.renew');
});


// Rutas de Administración para Pagos
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/pagos', [AdminController::class, 'gestionPagos'])->name('admin.pagos');
    Route::get('/pagos/{id}', [AdminController::class, 'detallePago'])->name('admin.pagos.detalle');
    Route::put('/suscripciones/{id}/suspender', [AdminController::class, 'suspenderSuscripcion'])->name('admin.suscripciones.suspender');
    Route::put('/suscripciones/{id}/activar', [AdminController::class, 'activarSuscripcion'])->name('admin.suscripciones.activar');
    Route::post('/suscripciones/{id}/extender', [AdminController::class, 'extenderSuscripcion'])->name('admin.suscripciones.extender');
});


// Rutas del dashboard de registro (ESTA ES LA ÚNICA RUTA DE elegir-plan)
Route::middleware(['web'])->group(function () {
    Route::get('/platform', [RegistroController::class, 'platform'])->name('platform');
    Route::post('/registro/logout', [RegistroController::class, 'logout'])->name('registro.logout');
    Route::get('/mis-datos', [RegistroController::class, 'misDatos'])->name('registro.mis-datos');
    Route::get('/elegir-plan', [RegistroController::class, 'elegirPlan'])->name('registro.elegir-plan');
    Route::post('/procesar-pago', [RegistroController::class, 'procesarPago'])->name('pago.procesar');
});

// routes/web.php
Route::post('/pago/procesar', [PagoStripeController::class, 'procesarPago'])->name('payment.process');
Route::get('/pago/exitoso', [PagoStripeController::class, 'pagoExitoso'])->name('payment.success');
Route::get('/pago/cancelado', [PagoStripeController::class, 'pagoCancelado'])->name('payment.cancel');

Route::get('/admin/gestion-registros', [RegistroController::class, 'gestionRegistros'])->name('admin.gestion-registros');
Route::get('/admin/registros/{id}/detalles', [RegistroController::class, 'obtenerDetallesRegistro']);

// Enviar credenciales por correo
 // ✅ RUTA CORRECTA para enviar credenciales
Route::post('/enviar-credenciales',[AdminController::class, 'enviarCredenciales'])
    ->name('enviar.credenciales');

// routes/web.php

Route::prefix('admin')->group(function () {
    Route::get('/reportes', [ReporteController::class, 'mostrarReportes'])->name('admin.reportes');
    Route::post('/reportes/generar', [ReporteController::class, 'generarReporte'])->name('admin.reportes.generar');
});

//graficas del administrador
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/dashboard/stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');

Route::get('/check-assets', function() {
    $assets = [
        'css/styles.css' => file_exists(public_path('css/styles.css')) ? 'EXISTE' : 'NO EXISTE',
        'css/footer-style.css' => file_exists(public_path('css/footer-style.css')) ? 'EXISTE' : 'NO EXISTE',
        'css/navbar-style.css' => file_exists(public_path('css/navbar-style.css')) ? 'EXISTE' : 'NO EXISTE',
        'css/components/hero-style.css' => file_exists(public_path('css/components/hero-style.css')) ? 'EXISTE' : 'NO EXISTE',
    ];
    
    return response()->json($assets);
});

Route::get('/crear-admin', [HomeController::class, 'crearAdmin']);