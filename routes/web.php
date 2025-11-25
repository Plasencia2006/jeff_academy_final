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
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ComunicadoController;
use App\Http\Controllers\PaymentController;

// Ruta para obtener datos del chatbot
Route::get('/chatbot/data', [ChatbotController::class, 'getData'])->name('chatbot.data');

// Rutas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');
Route::get('/planes', [HomeController::class, 'planes'])->name('planes');
Route::get('/inscripcion', [HomeController::class, 'inscripcion'])->name('inscripcion');

// Noticias públicas
Route::get('/noticias', [HomeController::class, 'noticias'])->name('noticias.index');
Route::get('/noticias/{id}', [HomeController::class, 'noticiaShow'])->name('noticias.show');

// Sistema de Registro de Usuarios (nuevo sistema separado)
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');
Route::post('/registro/login', [RegistroController::class, 'login'])->name('registro.login');

// Rutas protegidas para usuarios registrados (requieren sesión de registro)
Route::middleware(['web'])->group(function () {
    Route::get('/platform', [RegistroController::class, 'platform'])->name('platform');
    Route::post('/registro/logout', [RegistroController::class, 'logout'])->name('registro.logout');
    Route::get('/mis-datos', [RegistroController::class, 'misDatos'])->name('registro.mis-datos');
    Route::get('/elegir-plan', [RegistroController::class, 'elegirPlan'])->name('registro.elegir-plan');
    Route::get('/mis-planes', [RegistroController::class, 'misPlanes'])->name('registro.mis-planes');
    Route::post('/procesar-pago', [RegistroController::class, 'procesarPago'])->name('pago.procesar');
});

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::post('/login', [HomeController::class, 'doLogin'])->name('do.login');
    
    Route::get('/register', [HomeController::class, 'register'])->name('register');
    Route::post('/register', [HomeController::class, 'doRegister'])->name('do.register');
});

// Ruta de logout
Route::post('/logout', [HomeController::class, 'logout'])->name('logout')->middleware('auth');

// Eliminar cuenta
Route::delete('/eliminar-cuenta', [RegistroController::class, 'eliminarCuenta'])
    ->name('registro.eliminar-cuenta')
    ->middleware('auth');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match($role) {
            'admin' => redirect('/admin/dashboard'),
            'coach' => redirect('/coach/dashboard'),
            'player' => redirect('/player/dashboard'),
            default => redirect('/')
        };
    })->name('dashboard');
});

// Rutas para Administrador - CON NOMBRES COMPATIBLES CON VISTAS EXISTENTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Usuarios - MANTENIENDO NOMBRES ORIGINALES PARA COMPATIBILIDAD
    Route::post('/usuarios', [AdminController::class, 'storeUsuario'])->name('admin.usuarios.store');
    Route::put('/usuarios/{id}', [AdminController::class, 'updateUsuario'])->name('usuarios.update');
    Route::put('/usuarios/{id}/toggle', [AdminController::class, 'destroyUsuario'])->name('usuarios.toggle');
    Route::delete('/usuarios/{id}', [AdminController::class, 'deleteUsuario'])->name('usuarios.destroy');
    Route::put('/usuarios/{id}/password', [AdminController::class, 'updatePassword'])->name('usuarios.password');

    // Inscripciones
    Route::post('/inscripciones', [AdminController::class, 'storeInscripcion'])->name('admin.inscripciones.store');
    Route::put('/inscripciones/{id}', [AdminController::class, 'updateInscripcion'])->name('admin.inscripciones.update');
    Route::delete('/inscripciones/{id}', [AdminController::class, 'destroyInscripcion'])->name('admin.inscripciones.destroy');
    Route::put('/inscripciones/{id}/aprobar', [AdminController::class, 'aprobarInscripcion'])->name('admin.inscripciones.aprobar');
    Route::put('/inscripciones/{id}/rechazar', [AdminController::class, 'rechazarInscripcion'])->name('admin.inscripciones.rechazar');

    // Entrenamientos
    Route::post('/entrenamientos', [AdminController::class, 'storeEntrenamiento'])->name('admin.entrenamientos.store');

    // Noticias
    Route::post('/noticias', [AdminController::class, 'storeNoticia'])->name('admin.noticias.store');
    Route::delete('/noticias/{id}', [AdminController::class, 'destroyNoticia'])->name('admin.noticias.destroy');
    Route::put('/noticias/{id}', [AdminController::class, 'updateNoticia'])->name('admin.noticias.update');
    
    // Gestión de pagos
    Route::post('/confirmar-pago', [AdminController::class, 'confirmarPago'])->name('admin.confirmar-pago');
    Route::post('/registrar-pago-manual', [AdminController::class, 'registrarPagoManual'])->name('admin.registrar-pago-manual');
    
    // Gestión de registros
    Route::delete('/registros/{id}', [AdminController::class, 'destroyRegistro'])->name('admin.registros.destroy');

    // Planes
    Route::get('/planes', [AdminController::class, 'planes'])->name('admin.planes');
    Route::post('/planes', [AdminController::class, 'storePlan'])->name('admin.planes.store');
    Route::get('/planes/{id}', [AdminController::class, 'showPlan'])->name('admin.planes.show');
    Route::put('/planes/{id}', [AdminController::class, 'updatePlan'])->name('admin.planes.update');
    Route::delete('/planes/{id}', [AdminController::class, 'destroyPlan'])->name('admin.planes.destroy');

    // Disciplinas
    Route::post('/disciplinas', [AdminController::class, 'storeDisciplina'])->name('admin.disciplinas.store');
    Route::put('/disciplinas/{disciplina}', [AdminController::class, 'updateDisciplina'])->name('admin.disciplinas.update');
    Route::delete('/disciplinas/{disciplina}', [AdminController::class, 'destroyDisciplina'])->name('admin.disciplinas.destroy');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'mostrarReportes'])->name('admin.reportes');
    Route::post('/reportes/generar', [ReporteController::class, 'generarReporte'])->name('admin.reportes.generar');

    // Perfil
    Route::put('/perfil/update', [AdminController::class, 'updateProfile'])->name('admin.perfil.update');
    
    // Mensajes
    Route::get('/mensajes/{conversacion}', [AdminController::class, 'getMensajes'])->name('admin.mensajes.get');
    Route::post('/mensajes/nuevo', [AdminController::class, 'nuevoMensaje'])->name('admin.mensajes.nuevo');
    Route::post('/mensajes/enviar', [AdminController::class, 'enviarMensaje'])->name('admin.mensajes.enviar');

    // Comunicados
    Route::post('/comunicados', [ComunicadoController::class, 'store'])->name('admin.comunicados.store');
    Route::put('/comunicados/{id}', [ComunicadoController::class, 'update'])->name('admin.comunicados.update');
    Route::delete('/comunicados/{id}', [ComunicadoController::class, 'destroy'])->name('admin.comunicados.destroy');

    // Configuración
    Route::get('/ubicacion', [AdminController::class, 'editarUbicacion'])->name('admin.ubicacion');
    Route::put('/configuracion/contacto', [AdminController::class, 'actualizarContacto'])->name('admin.configuracion.contacto.update');

    // Gestión de registros
    Route::get('/gestion-registros', [RegistroController::class, 'gestionRegistros'])->name('admin.gestion-registros');
    Route::get('/registros/{id}/detalles', [RegistroController::class, 'obtenerDetallesRegistro'])->name('admin.registros.detalles');

    // Pagos
    Route::get('/pagos', [AdminController::class, 'gestionPagos'])->name('admin.pagos');
    Route::get('/pagos/{id}', [AdminController::class, 'detallePago'])->name('admin.pagos.detalle');
    Route::put('/suscripciones/{id}/suspender', [AdminController::class, 'suspenderSuscripcion'])->name('admin.suscripciones.suspender');
    Route::put('/suscripciones/{id}/activar', [AdminController::class, 'activarSuscripcion'])->name('admin.suscripciones.activar');
    Route::post('/suscripciones/{id}/extender', [AdminController::class, 'extenderSuscripcion'])->name('admin.suscripciones.extender');

    // Enviar credenciales
    Route::post('/enviar-credenciales', [AdminController::class, 'enviarCredenciales'])->name('admin.enviar-credenciales');
});

// Rutas para Entrenador
Route::middleware(['auth', 'role:coach'])->prefix('coach')->group(function () {
    Route::get('/dashboard', [AsistenciaController::class, 'index'])->name('coach.dashboard');

    // Asistencias
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('coach.asistencias.store');

    // Estadísticas
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
    Route::post('/estadisticas/store', [EstadisticaController::class, 'store'])->name('estadisticas.store');
    Route::get('/estadisticas/jugador/{inscripcionId}', [EstadisticaController::class, 'getJugadorData'])->name('estadisticas.getJugadorData');
    Route::put('/estadisticas/{id}', [EstadisticaController::class, 'update'])->name('estadisticas.update');
    Route::delete('/estadisticas/{id}', [EstadisticaController::class, 'destroy'])->name('estadisticas.destroy');

    // Entrenamientos
    Route::post('/horarios', [EntrenamientoController::class, 'storeFromCoach'])->name('coach.horarios.store');
    Route::put('/horarios/{entrenamiento}', [EntrenamientoController::class, 'updateFromCoach'])->name('coach.horarios.update');
    Route::delete('/horarios/{id}', [EntrenamientoController::class, 'destroyFromCoach'])->name('coach.horarios.destroy');
    Route::get('/entrenamientos/{entrenamiento}', [EntrenamientoController::class, 'showFromCoach'])->name('coach.entrenamientos.show');

    // Perfil
    Route::get('/perfil', [CoachController::class, 'perfil'])->name('coach.perfil');
    Route::put('/perfil/update', [CoachController::class, 'update'])->name('coach.perfil.update');
    Route::put('/perfil/update-image', [CoachController::class, 'updateImage'])->name('coach.perfil.update-image');

    // Observaciones
    Route::get('/observaciones', [ObservacionController::class, 'index'])->name('coach.observaciones.index');
    Route::post('/observaciones', [ObservacionController::class, 'store'])->name('coach.observaciones.store');
    Route::put('/observaciones/{id}', [ObservacionController::class, 'update'])->name('coach.observaciones.update');
    Route::delete('/observaciones/{id}', [ObservacionController::class, 'destroy'])->name('coach.observaciones.destroy');

    // Avisos
    Route::get('/avisos', [AnuncioController::class, 'index'])->name('coach.avisos');
    Route::post('/anuncios', [AnuncioController::class, 'store'])->name('anuncios.store');
    Route::put('/anuncios/{id}', [AnuncioController::class, 'update'])->name('anuncios.update');
    Route::delete('/anuncios/{id}', [AnuncioController::class, 'destroy'])->name('anuncios.destroy');
    Route::post('/anuncios/{id}/toggle', [AnuncioController::class, 'toggleActivo'])->name('anuncios.toggle');

    // Comunicados
    Route::post('/comunicados', [ComunicadoController::class, 'store'])->name('coach.comunicados.store');
    Route::put('/comunicados/{id}', [ComunicadoController::class, 'update'])->name('coach.comunicados.update');
    Route::delete('/comunicados/{id}', [ComunicadoController::class, 'destroy'])->name('coach.comunicados.destroy');
});

// Rutas para Jugador
Route::middleware(['auth', 'role:player'])->prefix('player')->group(function () {
    Route::get('/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');

    // Perfil
    Route::put('/perfil/update-image', [PlayerController::class, 'updateImage'])->name('player.update-image');
    Route::put('/perfil/update', [PlayerController::class, 'updateProfile'])->name('player.update-profile');
    
    // Funcionalidades
    Route::get('/asistencia', [PlayerController::class, 'asistencia'])->name('player.asistencia');
    Route::get('/rendimiento', [PlayerController::class, 'rendimiento'])->name('player.rendimiento');
    Route::get('/anuncios', [PlayerController::class, 'anuncios'])->name('player.anuncios');
    Route::get('/pagos', [PlayerController::class, 'pagos'])->name('player.pagos');
    Route::get('/entrenador', [PlayerController::class, 'entrenador'])->name('player.entrenador');
    Route::get('/ayuda', [PlayerController::class, 'ayuda'])->name('player.ayuda');
});

// Rutas de Pagos
Route::middleware(['auth'])->group(function () {
    Route::post('/procesar-inscripcion', [RegistroController::class, 'procesarInscripcionCompleta'])->name('inscripcion.completa');
    
    // Proceso de pago
    Route::get('/pago/procesar/{plan}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/pago/create-intent', [PaymentController::class, 'createPaymentIntent'])->name('payment.create-intent');
    Route::post('/pago/confirmar', [PaymentController::class, 'confirmPayment'])->name('payment.confirm');
    
    // Historial de pagos
    Route::get('/mis-pagos', [PaymentController::class, 'paymentHistory'])->name('payment.history');
    Route::get('/mis-pagos/{id}', [PaymentController::class, 'paymentDetail'])->name('payment.detail');
    
    // Renovación
    Route::post('/renovar-suscripcion', [PaymentController::class, 'renewSubscription'])->name('subscription.renew');
});

// Rutas de Stripe
Route::post('/pago/procesar', [PagoStripeController::class, 'procesarPago'])->name('payment.process');
Route::get('/pago/exitoso', [PagoStripeController::class, 'pagoExitoso'])->name('payment.success');
Route::get('/pago/cancelado', [PagoStripeController::class, 'pagoCancelado'])->name('payment.cancel');

// Gráficas del dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/dashboard/stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');

// Ruta para crear admin (solo desarrollo)
Route::get('/crear-admin', [HomeController::class, 'crearAdmin']);