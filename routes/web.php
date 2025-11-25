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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ComunicadoController;

// ============================================
// RUTAS PÚBLICAS
// ============================================

// Chatbot
Route::get('/chatbot/data', [ChatbotController::class, 'getData'])->name('chatbot.data');

// Home y páginas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');
Route::get('/planes', [HomeController::class, 'planes'])->name('planes');
Route::get('/inscripcion', [HomeController::class, 'inscripcion'])->name('inscripcion');

// Noticias públicas
Route::get('/noticias', [HomeController::class, 'noticias'])->name('noticias.index');
Route::get('/noticias/{id}', [HomeController::class, 'noticiaShow'])->name('noticias.show');

// ============================================
// AUTENTICACIÓN (GUEST)
// ============================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [HomeController::class, 'login'])->name('login');
    Route::post('/login', [HomeController::class, 'doLogin'])->name('do.login');
    Route::get('/register', [HomeController::class, 'register'])->name('register');
    Route::post('/register', [HomeController::class, 'doRegister'])->name('do.register');
});

// ============================================
// SISTEMA DE REGISTRO PÚBLICO
// ============================================

Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');
Route::post('/registro/login', [RegistroController::class, 'login'])->name('registro.login');

// ============================================
// RUTAS PROTEGIDAS - SISTEMA DE REGISTRO
// ============================================

Route::middleware(['web'])->group(function () {
    Route::get('/platform', [RegistroController::class, 'platform'])->name('platform');
    Route::post('/registro/logout', [RegistroController::class, 'logout'])->name('registro.logout');
    Route::get('/mis-datos', [RegistroController::class, 'misDatos'])->name('registro.mis-datos');
    Route::get('/mis-planes', [RegistroController::class, 'misPlanes'])->name('registro.mis-planes');
    Route::get('/elegir-plan', [RegistroController::class, 'elegirPlan'])->name('registro.elegir-plan');
    Route::post('/procesar-inscripcion', [RegistroController::class, 'procesarInscripcionCompleta'])->name('inscripcion.completa');
    Route::post('/procesar-pago', [RegistroController::class, 'procesarPago'])->name('pago.procesar');
});

// ============================================
// RUTAS PROTEGIDAS - AUTENTICADOS
// ============================================

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
    
    // Eliminar cuenta
    Route::delete('/eliminar-cuenta', [RegistroController::class, 'eliminarCuenta'])->name('registro.eliminar-cuenta');
    
    // Dashboard principal - Redirige según rol
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');
    
    // Sistema de pagos
    Route::get('/pago/procesar/{plan}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/pago/create-intent', [PaymentController::class, 'createPaymentIntent'])->name('payment.create-intent');
    Route::post('/pago/confirmar', [PaymentController::class, 'confirmPayment'])->name('payment.confirm');
    Route::get('/mis-pagos', [PaymentController::class, 'paymentHistory'])->name('payment.history');
    Route::get('/mis-pagos/{id}', [PaymentController::class, 'paymentDetail'])->name('payment.detail');
    Route::post('/renovar-suscripcion', [PaymentController::class, 'renewSubscription'])->name('subscription.renew');
    
    // Stripe
    Route::post('/pago/procesar', [PagoStripeController::class, 'procesarPago'])->name('payment.process');
    Route::get('/pago/exitoso', [PagoStripeController::class, 'pagoExitoso'])->name('payment.success');
    Route::get('/pago/cancelado', [PagoStripeController::class, 'pagoCancelado'])->name('payment.cancel');
});

// ============================================
// RUTAS DE ADMINISTRADOR
// ============================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de usuarios
    Route::post('/usuarios', [AdminController::class, 'storeUsuario'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [AdminController::class, 'updateUsuario'])->name('usuarios.update');
    Route::put('/usuarios/{id}/password', [AdminController::class, 'updatePassword'])->name('usuarios.password');
    Route::put('/usuarios/{id}/toggle', [AdminController::class, 'destroyUsuario'])->name('usuarios.toggle');
    Route::delete('/usuarios/{id}', [AdminController::class, 'deleteUsuario'])->name('usuarios.destroy');
    
    // Gestión de inscripciones
    Route::post('/inscripciones', [AdminController::class, 'storeInscripcion'])->name('inscripciones.store');
    Route::put('/inscripciones/{id}', [AdminController::class, 'updateInscripcion'])->name('inscripciones.update');
    Route::delete('/inscripciones/{id}', [AdminController::class, 'destroyInscripcion'])->name('inscripciones.destroy');
    Route::put('/inscripciones/{id}/aprobar', [AdminController::class, 'aprobarInscripcion'])->name('inscripciones.aprobar');
    Route::put('/inscripciones/{id}/rechazar', [AdminController::class, 'rechazarInscripcion'])->name('inscripciones.rechazar');
    
    // Gestión de entrenamientos
    Route::post('/entrenamientos', [AdminController::class, 'storeEntrenamiento'])->name('entrenamientos.store');
    
    // Gestión de noticias
    Route::post('/noticias', [AdminController::class, 'storeNoticia'])->name('noticias.store');
    Route::put('/noticias/{id}', [AdminController::class, 'updateNoticia'])->name('noticias.update');
    Route::delete('/noticias/{id}', [AdminController::class, 'destroyNoticia'])->name('noticias.destroy');
    
    // Gestión de planes
    Route::post('/planes', [AdminController::class, 'storePlan'])->name('planes.store');
    Route::get('/planes/{id}', [AdminController::class, 'showPlan'])->name('planes.show');
    Route::put('/planes/{id}', [AdminController::class, 'updatePlan'])->name('planes.update');
    Route::delete('/planes/{id}', [AdminController::class, 'destroyPlan'])->name('planes.destroy');
    
    // Gestión de disciplinas
    Route::post('/disciplinas', [AdminController::class, 'storeDisciplina'])->name('disciplinas.store');
    Route::put('/disciplinas/{disciplina}', [AdminController::class, 'updateDisciplina'])->name('disciplinas.update');
    Route::delete('/disciplinas/{disciplina}', [AdminController::class, 'destroyDisciplina'])->name('disciplinas.destroy');
    
    // Gestión de pagos
    Route::get('/pagos', [AdminController::class, 'gestionPagos'])->name('pagos');
    Route::get('/pagos/{id}', [AdminController::class, 'detallePago'])->name('pagos.detalle');
    Route::post('/confirmar-pago', [AdminController::class, 'confirmarPago'])->name('confirmar-pago');
    Route::post('/registrar-pago-manual', [AdminController::class, 'registrarPagoManual'])->name('registrar-pago-manual');
    
    // Gestión de suscripciones
    Route::put('/suscripciones/{id}/suspender', [AdminController::class, 'suspenderSuscripcion'])->name('suscripciones.suspender');
    Route::put('/suscripciones/{id}/activar', [AdminController::class, 'activarSuscripcion'])->name('suscripciones.activar');
    Route::post('/suscripciones/{id}/extender', [AdminController::class, 'extenderSuscripcion'])->name('suscripciones.extender');
    
    // Gestión de registros
    Route::get('/gestion-registros', [RegistroController::class, 'gestionRegistros'])->name('gestion-registros');
    Route::get('/registros/{id}/detalles', [RegistroController::class, 'obtenerDetallesRegistro'])->name('registros.detalles');
    Route::delete('/registros/{id}', [AdminController::class, 'destroyRegistro'])->name('registros.destroy');
    
    // Reportes
    Route::get('/reportes', [ReporteController::class, 'mostrarReportes'])->name('reportes');
    Route::post('/reportes/generar', [ReporteController::class, 'generarReporte'])->name('reportes.generar');
    
    // Perfil de administrador
    Route::put('/perfil/update', [AdminController::class, 'updateProfile'])->name('perfil.update');
    
    // Mensajería
    Route::get('/mensajes/{conversacion}', [AdminController::class, 'getMensajes'])->name('mensajes.get');
    Route::post('/mensajes/nuevo', [AdminController::class, 'nuevoMensaje'])->name('mensajes.nuevo');
    Route::post('/mensajes/enviar', [AdminController::class, 'enviarMensaje'])->name('mensajes.enviar');
    
    // Comunicados
    Route::post('/comunicados', [ComunicadoController::class, 'store'])->name('comunicados.store');
    Route::put('/comunicados/{id}', [ComunicadoController::class, 'update'])->name('comunicados.update');
    Route::delete('/comunicados/{id}', [ComunicadoController::class, 'destroy'])->name('comunicados.destroy');
    
    // Configuración de contacto
    Route::get('/ubicacion', [AdminController::class, 'editarUbicacion'])->name('ubicacion');
    Route::put('/configuracion/contacto', [AdminController::class, 'actualizarContacto'])->name('configuracion.contacto.update');
    
    // Enviar credenciales
    Route::post('/enviar-credenciales', [AdminController::class, 'enviarCredenciales'])->name('enviar.credenciales');
});

// ============================================
// RUTAS DE ENTRENADOR (COACH)
// ============================================

Route::middleware(['auth', 'role:coach'])->prefix('coach')->name('coach.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AsistenciaController::class, 'index'])->name('dashboard');
    
    // Asistencias
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    
    // Estadísticas
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
    Route::post('/estadisticas/store', [EstadisticaController::class, 'store'])->name('estadisticas.store');
    Route::get('/estadisticas/jugador/{inscripcionId}', [EstadisticaController::class, 'getJugadorData'])->name('estadisticas.getJugadorData');
    Route::put('/estadisticas/{id}', [EstadisticaController::class, 'update'])->name('estadisticas.update');
    Route::delete('/estadisticas/{id}', [EstadisticaController::class, 'destroy'])->name('estadisticas.destroy');
    
    // Entrenamientos/Horarios
    Route::get('/entrenamientos/{entrenamiento}', [EntrenamientoController::class, 'showFromCoach'])->name('entrenamientos.show');
    Route::post('/horarios', [EntrenamientoController::class, 'storeFromCoach'])->name('horarios.store');
    Route::put('/horarios/{entrenamiento}', [EntrenamientoController::class, 'updateFromCoach'])->name('horarios.update');
    Route::delete('/horarios/{id}', [EntrenamientoController::class, 'destroyFromCoach'])->name('horarios.destroy');
    
    // Perfil
    Route::get('/perfil', [CoachController::class, 'perfil'])->name('perfil');
    Route::put('/perfil/update', [CoachController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/update-image', [CoachController::class, 'updateImage'])->name('perfil.update-image');
    
    // Observaciones técnicas
    Route::get('/observaciones', [ObservacionController::class, 'index'])->name('observaciones.index');
    Route::post('/observaciones', [ObservacionController::class, 'store'])->name('observaciones.store');
    Route::put('/observaciones/{id}', [ObservacionController::class, 'update'])->name('observaciones.update');
    Route::delete('/observaciones/{id}', [ObservacionController::class, 'destroy'])->name('observaciones.destroy');
    
    // Avisos/Anuncios
    Route::get('/avisos', [AnuncioController::class, 'index'])->name('avisos');
    Route::post('/anuncios', [AnuncioController::class, 'store'])->name('anuncios.store');
    Route::put('/anuncios/{id}', [AnuncioController::class, 'update'])->name('anuncios.update');
    Route::delete('/anuncios/{id}', [AnuncioController::class, 'destroy'])->name('anuncios.destroy');
    Route::post('/anuncios/{id}/toggle', [AnuncioController::class, 'toggleActivo'])->name('anuncios.toggle');
    
    // Comunicados
    Route::post('/comunicados', [ComunicadoController::class, 'store'])->name('comunicados.store');
    Route::put('/comunicados/{id}', [ComunicadoController::class, 'update'])->name('comunicados.update');
    Route::delete('/comunicados/{id}', [ComunicadoController::class, 'destroy'])->name('comunicados.destroy');
});

// ============================================
// RUTAS DE JUGADOR (PLAYER)
// ============================================

Route::middleware(['auth', 'role:player'])->prefix('player')->name('player.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PlayerController::class, 'dashboard'])->name('dashboard');
    
    // Perfil
    Route::put('/perfil/update', [PlayerController::class, 'updateProfile'])->name('update-profile');
    Route::put('/perfil/update-image', [PlayerController::class, 'updateImage'])->name('update-image');
    
    // Secciones
    Route::get('/asistencia', [PlayerController::class, 'asistencia'])->name('asistencia');
    Route::get('/rendimiento', [PlayerController::class, 'rendimiento'])->name('rendimiento');
    Route::get('/anuncios', [PlayerController::class, 'anuncios'])->name('anuncios');
    Route::get('/pagos', [PlayerController::class, 'pagos'])->name('pagos');
    Route::get('/entrenador', [PlayerController::class, 'entrenador'])->name('entrenador');
    Route::get('/ayuda', [PlayerController::class, 'ayuda'])->name('ayuda');
});

// ============================================
// RUTA PARA CREAR ADMIN (DESARROLLO)
// ============================================

Route::get('/crear-admin', [AdminController::class, 'crearAdmin']);
