@extends('layouts.app')

@section('title', 'Formulario de Inscripción - Jeff Academy')

@section('content')
<div class="bg-gradient-to-br from-slate-50 via-blue-50 to-slate-50 min-h-screen pt-24 pb-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden mb-8">
        <!-- Header -->
        <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 via-emerald-800 to-blue-950 py-12 px-8 text-center">
            <div class="relative z-10">
                <div class="inline-block p-3 bg-white/10 rounded-full mb-3 backdrop-blur-sm">
                    <i class="fas fa-graduation-cap text-4xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Formulario de Inscripción</h1>
                <p class="text-slate-200 text-base">Completa tus datos para unirte a Jeff Academy</p>
            </div>
        </div>
        
        <!-- Form Content -->
        <div class="px-8 py-10" x-data="{ showModal: false, showTerminos: false }">
            <form action="{{ route('registro.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Datos Personales -->
                <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-2xl p-8 border border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-800 mb-8 flex items-center">
                        <div class="p-2 bg-gradient-to-br from-slate-900 via-blue-900 to-emerald-800 rounded-lg mr-3 shadow-md">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <span class="text-slate-800">Datos Personales</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Tipo Documento -->
                        <div class="space-y-2">
                            <label for="tipo_documento" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-id-card text-blue-700 mr-2"></i>Tipo de Documento <span class="text-red-600">*</span>
                            </label>
                            <select name="tipo_documento" id="tipo_documento" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 @error('tipo_documento') border-red-500 @enderror" required>
                                <option value="">Seleccionar</option>
                                <option value="DNI" {{ old('tipo_documento') == 'DNI' ? 'selected' : '' }}>DNI</option>
                            </select>
                            @error('tipo_documento')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- DNI -->
                        <div class="space-y-2">
                            <label for="nro_documento" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-fingerprint text-blue-700 mr-2"></i>Número de Documento <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="nro_documento" id="nro_documento" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('nro_documento') border-red-500 @enderror" value="{{ old('nro_documento') }}" placeholder="DNI" required maxlength="8">
                            <div id="dni-loader" class="hidden text-xs mt-1 p-2 rounded-lg bg-blue-50 text-blue-800">
                                <i class="fas fa-spinner fa-spin"></i> Buscando...
                            </div>
                            @error('nro_documento')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Género -->
                        <div class="space-y-2">
                            <label for="genero" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-venus-mars text-blue-700 mr-2"></i>Género <span class="text-red-600">*</span>
                            </label>
                            <select name="genero" id="genero" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-700 @error('genero') border-red-500 @enderror" required>
                                <option value="">Seleccionar</option>
                                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('genero')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Nombres -->
                        <div class="space-y-2">
                            <label for="nombres" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-signature text-blue-700 mr-2"></i>Nombres <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="nombres" id="nombres" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('nombres') border-red-500 @enderror" value="{{ old('nombres') }}" placeholder="Nombres completos" required>
                            @error('nombres')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Apellido Paterno -->
                        <div class="space-y-2">
                            <label for="apellido_paterno" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-signature text-blue-700 mr-2"></i>Apellido Paterno <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="apellido_paterno" id="apellido_paterno" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('apellido_paterno') border-red-500 @enderror" value="{{ old('apellido_paterno') }}" placeholder="Apellido paterno" required>
                            @error('apellido_paterno')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Apellido Materno -->
                        <div class="space-y-2">
                            <label for="apellido_materno" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-signature text-blue-700 mr-2"></i>Apellido Materno <span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="apellido_materno" id="apellido_materno" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('apellido_materno') border-red-500 @enderror" value="{{ old('apellido_materno') }}" placeholder="Apellido materno" required>
                            @error('apellido_materno')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Fecha Nacimiento -->
                        <div class="space-y-2">
                            <label for="fecha_nacimiento" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-calendar-alt text-blue-700 mr-2"></i>Fecha de Nacimiento <span class="text-red-600">*</span>
                            </label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('fecha_nacimiento') border-red-500 @enderror" value="{{ old('fecha_nacimiento') }}" required>
                            @error('fecha_nacimiento')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Celular -->
                        <div class="space-y-2">
                            <label for="nro_celular" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-mobile-alt text-blue-700 mr-2"></i>Celular <span class="text-red-600">*</span>
                            </label>
                            <input type="tel" name="nro_celular" id="nro_celular" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('nro_celular') border-red-500 @enderror" value="{{ old('nro_celular') }}" placeholder="999999999" required maxlength="9">
                            @error('nro_celular')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-envelope text-blue-700 mr-2"></i>Email <span class="text-red-600">*</span>
                            </label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('email') border-red-500 @enderror" value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                            @error('email')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Contraseña -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-lock text-blue-700 mr-2"></i>Contraseña <span class="text-red-600">*</span>
                            </label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('password') border-red-500 @enderror" placeholder="Mínimo 8 caracteres" required>
                            @error('password')
                                <p class="text-red-600 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Confirmar Contraseña -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                                <i class="fas fa-lock text-blue-700 mr-2"></i>Confirmar <span class="text-red-600">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Repetir contraseña" required>
                        </div>
                    </div>
                </div>
                
                <!-- Términos -->
                <div class="bg-gradient-to-br from-blue-50 to-slate-50 border-2 border-slate-200 rounded-2xl p-8">
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" name="terminos" id="terminos" class="h-5 w-5 mt-0.5 text-blue-700 border-2 border-slate-300 rounded focus:ring-2 focus:ring-blue-500 @error('terminos') border-red-500 @enderror" required>
                            <label for="terminos" class="text-sm text-slate-700">
                                <i class="fas fa-shield-alt text-blue-700 mr-2"></i>
                                He leído y acepto los <a href="#" @click.prevent="showTerminos = true" class="text-blue-700 hover:text-blue-900 underline font-semibold">términos y condiciones</a>. <span class="text-red-600">*</span>
                            </label>
                        </div>
                        @error('terminos')
                            <p class="text-red-600 text-xs ml-8"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>  
                
                <!-- Botones de Acción -->
                <div class="flex flex-col items-center space-y-4 pt-2">
                    <button type="submit" class="w-full px-8 py-3.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 rounded-xl font-bold text-base hover:shadow-lg hover:from-yellow-300 hover:to-yellow-400 transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>Completar Inscripción</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <p class="text-sm text-slate-700">
                        ¿Ya tienes cuenta? <a href="#" @click.prevent="showModal = true" class="text-blue-700 hover:text-blue-900 font-semibold">Inicia sesión</a>
                    </p>
                </div>
            </form>
            
            <!-- Modal Login -->
            <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" @click.away="showModal = false">
                <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden" @click.stop>
                    <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 via-emerald-800 to-blue-950 p-8 text-center">
                        <button @click="showModal = false" class="absolute top-4 right-4 text-white hover:bg-white/20 rounded-full w-9 h-9 flex items-center justify-center transition-all hover:scale-110 text-xl">
                            <i class="fas fa-times"></i>
                        </button>
                        <h2 class="text-3xl font-bold text-white mt-2">Iniciar Sesión</h2>
                        <p class="text-slate-200 text-base mt-2 font-light">Ingresa tus credenciales de acceso</p>
                    </div>
                    
                    <div class="p-8">
                        <form action="{{ route('registro.login') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="space-y-3">
                                <label for="login_email" class="block text-sm font-bold text-slate-800 flex items-center">
                                    <i class="fas fa-envelope text-blue-700 mr-2.5 text-lg"></i>Email
                                </label>
                                <input type="email" name="email" id="login_email" class="w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-slate-400 text-slate-700" placeholder="correo@ejemplo.com" required>
                            </div>
                            
                            <div class="space-y-3">
                                <label for="login_password" class="block text-sm font-bold text-slate-800 flex items-center">
                                    <i class="fas fa-lock text-blue-700 mr-2.5 text-lg"></i>Contraseña
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="login_password" class="w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all pr-12 placeholder-slate-400 text-slate-700" placeholder="Tu contraseña" required>
                                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-700 transition-colors text-lg">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full px-6 py-3.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 rounded-xl font-bold text-base hover:shadow-xl hover:from-yellow-300 hover:to-yellow-400 transition-all duration-300 flex items-center justify-center gap-2 mt-8">
                                <i class="fas fa-sign-in-alt text-lg"></i>
                                <span>Ingresar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Modal Términos y Condiciones -->
            <div x-show="showTerminos" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 pt-20" @click.away="showTerminos = false">
                <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[70vh] overflow-hidden my-auto" @click.stop>
                    <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 via-emerald-800 to-blue-950 p-8 text-center">
                        <button @click="showTerminos = false" class="absolute top-4 right-4 text-white hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center transition-all">
                            <i class="fas fa-times"></i>
                        </button>
                        <h2 class="text-3xl font-bold text-white">Términos y Condiciones</h2>
                        <p class="text-slate-300 text-base mt-2">Jeff Academy - Plataforma Educativa</p>
                    </div>
                    
                    <div class="overflow-y-auto max-h-[calc(70vh-140px)] p-8 space-y-8 pt-6 bg-gradient-to-b from-white to-slate-50">
                        <section class="pb-6 border-b border-slate-300 last:border-b-0">
                            <h3 class="font-bold text-slate-800 mb-3 text-base flex items-center">
                                <span class="flex items-center justify-center w-7 h-7 bg-gradient-to-br from-slate-900 via-blue-900 to-emerald-800 text-white rounded-full text-sm font-bold mr-3">1</span>
                                Aceptación de los Términos
                            </h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Al acceder y utilizar Jeff Academy, usted acepta estar sujeto a estos términos y condiciones de uso. Si no está de acuerdo, no debe utilizar nuestra plataforma. Nos reservamos el derecho de actualizar estos términos en cualquier momento.
                            </p>
                        </section>
                        
                        <section class="pb-6 border-b border-slate-300">
                            <h3 class="font-bold text-slate-800 mb-3 text-base flex items-center">
                                <span class="flex items-center justify-center w-7 h-7 bg-gradient-to-br from-slate-900 via-blue-900 to-emerald-800 text-white rounded-full text-sm font-bold mr-3">2</span>
                                Registro de Cuenta
                            </h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Usted es responsable de mantener la confidencialidad de su contraseña, todas las actividades bajo su cuenta, notificar uso no autorizado, mantener información actualizada y no compartir su cuenta con terceros. Jeff Academy se reserva el derecho de suspender cuentas que violen estos términos.
                            </p>
                        </section>
                        
                        <section class="pb-6 border-b border-slate-300">
                            <h3 class="font-bold text-slate-800 mb-3 text-base flex items-center">
                                <span class="flex items-center justify-center w-7 h-7 bg-gradient-to-br from-slate-900 via-blue-900 to-emerald-800 text-white rounded-full text-sm font-bold mr-3">3</span>
                                Uso de la Plataforma
                            </h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Compromete usar la plataforma solo con fines educativos, no compartir contenido inapropiado, respetar derechos de propiedad intelectual y no intentar acceder a áreas restringidas del sistema.
                            </p>
                        </section>
                        
                        <section class="pb-6 border-b border-slate-300">
                            <h3 class="font-bold text-slate-800 mb-3 text-base flex items-center">
                                <span class="flex items-center justify-center w-7 h-7 bg-gradient-to-br from-slate-900 via-blue-900 to-emerald-800 text-white rounded-full text-sm font-bold mr-3">4</span>
                                Protección de Datos
                            </h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Sus datos se utilizan para gestión de cuenta, personalización educativa, comunicaciones de cursos y análisis de servicios. No serán compartidos sin consentimiento expreso. Tiene derecho a acceder, rectificar o cancelar sus datos en cualquier momento.
                            </p>
                        </section>
                        
                        <section class="pb-6 border-b border-slate-300">
                            <h3 class="font-bold text-slate-800 mb-3 text-base flex items-center">
                                <span class="flex items-center justify-center w-7 h-7 bg-gradient-to-br from-slate-900 via-blue-900 to-emerald-800 text-white rounded-full text-sm font-bold mr-3">5</span>
                                Propiedad Intelectual
                            </h3>
                            <p class="text-slate-700 text-sm leading-relaxed">
                                Todo el contenido (textos, gráficos, videos, software) es propiedad de Jeff Academy y está protegido por leyes de propiedad intelectual.
                            </p>
                        </section>
                    </div>
                    
                    <div class="p-6 bg-white border-t border-slate-200 flex justify-end gap-3">
                        <button @click="showTerminos = false" class="px-6 py-2.5 text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg font-semibold text-sm transition-all">
                            <i class="fas fa-times mr-2"></i>Cerrar
                        </button>
                        <button @click="showTerminos = false" class="px-8 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 rounded-lg font-bold text-sm transition-all hover:shadow-lg hover:from-yellow-300 hover:to-yellow-400 flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
function togglePassword() {
    const input = document.getElementById('login_password');
    const icon = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const dniInput = document.getElementById('nro_documento');
    const loader = document.getElementById('dni-loader');

    dniInput.addEventListener('input', e => {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });

    dniInput.addEventListener('keyup', async function() {
        if (this.value.length === 8) {
            loader.classList.remove('hidden');
            try {
                const res = await fetch(`/buscar-dni/${this.value}`);
                const data = await res.json();
                if (!data.error) {
                    document.getElementById('nombres').value = data.nombres || '';
                    document.getElementById('apellido_paterno').value = data.apellido_paterno || '';
                    document.getElementById('apellido_materno').value = data.apellido_materno || '';
                    if (data.fecha_nacimiento) {
                        const p = data.fecha_nacimiento.split('/');
                        document.getElementById('fecha_nacimiento').value = `${p[2]}-${p[1]}-${p[0]}`;
                    }
                    loader.textContent = '✓ Datos encontrados correctamente';
                } else {
                    loader.textContent = '✗ DNI no encontrado en RENIEC';
                }
                setTimeout(() => loader.classList.add('hidden'), 2500);
            } catch (e) {
                loader.textContent = '✗ Error de conexión con el servidor';
                setTimeout(() => loader.classList.add('hidden'), 2500);
            }
        }
    });

    document.getElementById('nro_celular').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });
});
</script>