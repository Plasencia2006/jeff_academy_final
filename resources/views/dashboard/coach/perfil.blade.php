<!-- Perfil del Coach - Completo y Funcional -->
<div class="space-y-6" x-data="perfilData()">
    <!-- Encabezado -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-user-circle mr-2 text-blue-600"></i>Mi Perfil
            </h1>
            <p class="text-gray-600 mt-1">Gestiona tu información personal y profesional</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-fade-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md animate-fade-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <div>
                    <p class="font-semibold">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('coach.perfil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- COLUMNA IZQUIERDA: FOTO, RESUMEN Y SEGURIDAD -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Card Foto de Perfil -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-camera mr-2 text-blue-600"></i>
                        Foto de Perfil
                    </h3>
                    
                    <div class="flex flex-col items-center relative">
                        <div class="relative group">
                            <img 
                                :src="currentImage"
                                alt="Foto de perfil" 
                                class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 transition-all duration-300 group-hover:border-blue-600 group-hover:scale-105"
                            >
                            <button 
                                type="button"
                                @click.stop="showModal = true; tempImage = currentImage"
                                class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 cursor-pointer shadow-lg transition-all hover:scale-110"
                            >
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>

                        <!-- Modal flotante para modificar foto -->
                        <div 
                            x-show="showModal"
                            x-cloak
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                            @click.self="showModal = false; tempImage = currentImage; $refs.fileInput.value = ''"
                            @keydown.escape.window="showModal = false; tempImage = currentImage; $refs.fileInput.value = ''"
                        >
                            <div class="bg-white rounded-lg shadow-2xl max-w-md w-full relative" @click.stop>
                                <!-- Botón cerrar CIRCULAR -->
                                <button 
                                    type="button"
                                    @click="showModal = false; tempImage = currentImage; $refs.fileInput.value = ''"
                                    class="absolute -top-3 -right-3 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg hover:bg-gray-100 transition z-10 border-2 border-gray-200"
                                >
                                    <i class="fas fa-times text-gray-600 text-lg"></i>
                                </button>

                                <!-- Encabezado -->
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-lg">
                                    <h3 class="text-xl font-bold flex items-center">
                                        <i class="fas fa-camera mr-2"></i>
                                        Modificar foto
                                    </h3>
                                </div>

                                <!-- Contenido -->
                                <div class="p-6">
                                    <!-- Foto circular centrada -->
                                    <div class="flex justify-center mb-6">
                                        <div class="relative">
                                            <img 
                                                :src="tempImage"
                                                alt="Foto de perfil" 
                                                class="w-40 h-40 rounded-full object-cover border-4 border-gray-200 shadow-md"
                                            >
                                        </div>
                                    </div>

                                    <!-- Instrucciones -->
                                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded">
                                        <ul class="text-sm text-gray-700 space-y-2">
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                                                <span>Recuerda subir una foto con tu <strong>rostro</strong>.</span>
                                            </li>
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                                                <span>El tamaño de la foto no debe superar los <strong>2 MB</strong> y debe tener formato <strong>JPG o PNG</strong>.</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Input de archivo -->
                                    <div class="mb-4">
                                        <label class="flex items-center justify-center w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg cursor-pointer transition font-medium">
                                            <i class="fas fa-plus mr-2"></i>
                                            Seleccionar foto
                                            <input 
                                                type="file" 
                                                name="foto_perfil" 
                                                accept="image/*" 
                                                class="hidden"
                                                x-ref="fileInput"
                                                @change="
                                                    const file = $event.target.files[0];
                                                    if (file) {
                                                        if (file.size > 2 * 1024 * 1024) {
                                                            alert('La imagen no debe superar los 2MB');
                                                            $refs.fileInput.value = '';
                                                            return;
                                                        }
                                                        if (!file.type.match('image.*')) {
                                                            alert('Solo se permiten archivos de imagen (JPG, PNG, GIF)');
                                                            $refs.fileInput.value = '';
                                                            return;
                                                        }
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            tempImage = e.target.result;
                                                        };
                                                        reader.readAsDataURL(file);
                                                    }
                                                "
                                            >
                                        </label>
                                        <p class="text-xs text-gray-500 text-center mt-2">
                                            JPG, PNG o GIF (máx. 2MB)
                                        </p>
                                    </div>

                                    <!-- Botón Actualizar -->
                                    <button 
                                        type="button"
                                        @click="currentImage = tempImage; showModal = false"
                                        class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition shadow-md hover:shadow-lg"
                                    >
                                        <i class="fas fa-save mr-2"></i>Actualizar Vista Previa
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-500 mt-3 text-center">
                            JPG, PNG o GIF (máx. 2MB)
                        </p>
                    </div>
                </div>

                <!-- Card Resumen (AZUL) -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-chart-line mr-2"></i>
                        Resumen
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-blue-500">
                            <span class="text-blue-100 flex items-center">
                                <i class="fas fa-user-tag mr-2"></i>Rol
                            </span>
                            <span class="font-bold text-lg">{{ ucfirst(auth()->user()->role) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-blue-500">
                            <span class="text-blue-100 flex items-center">
                                <i class="fas fa-calendar mr-2"></i>Miembro desde
                            </span>
                            <span class="font-bold text-lg">{{ auth()->user()->created_at->format('Y') }}</span>
                        </div>
                        @if(auth()->user()->edad)
                        <div class="flex justify-between items-center py-2 border-b border-blue-500">
                            <span class="text-blue-100 flex items-center">
                                <i class="fas fa-birthday-cake mr-2"></i>Edad
                            </span>
                            <span class="font-bold text-lg">{{ auth()->user()->edad }} años</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2">
                            <span class="text-blue-100 flex items-center">
                                <i class="fas fa-users mr-2"></i>Jugadores
                            </span>
                            <span class="font-bold text-2xl">{{ auth()->user()->inscripcionesComoEntrenador->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Seguridad (DEBAJO DEL RESUMEN) -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-lg p-6 border-2 border-gray-300 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b border-gray-300 pb-3">
                        <i class="fas fa-shield-alt mr-2 text-gray-600"></i>
                        Seguridad de la Cuenta
                    </h3>
                    
                    <div class="bg-white border-2 border-gray-300 rounded-lg p-5">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-800 mb-2">
                                    <i class="fas fa-lock mr-1"></i>Contraseña Protegida
                                </p>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    Por razones de seguridad, la <strong>contraseña</strong> y el <strong>email</strong> no pueden ser modificados desde esta sección.
                                </p>
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                    Si necesitas cambiar estos datos, contacta al <strong>administrador del sistema</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: FORMULARIO -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información Personal -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-3">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Información Personal
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nombre Completo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-id-card mr-1 text-gray-500"></i>
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                x-model="formData.name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                required
                            >
                        </div>

                        <!-- Email - BLOQUEADO -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-envelope mr-1 text-gray-500"></i>
                                Email
                                <span class="ml-2 text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded">No editable</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    :value="formData.email"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                                    readonly
                                    disabled
                                >
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone mr-1 text-gray-500"></i>
                                Teléfono
                            </label>
                            <input 
                                type="tel" 
                                name="telefono" 
                                x-model="formData.telefono"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="+57 300 123 4567"
                            >
                        </div>

                        <!-- Fecha de Nacimiento (Solo lectura) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-birthday-cake mr-1 text-gray-500"></i>
                                Fecha de Nacimiento
                                <span class="text-xs text-gray-500">(Asignada por el administrador)</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    x-model="formData.fecha_nacimiento"
                                    disabled
                                    readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed"
                                >
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1 text-gray-500"></i>
                                Dirección
                            </label>
                            <input 
                                type="text" 
                                name="direccion" 
                                x-model="formData.direccion"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Calle, ciudad, país"
                            >
                        </div>
                    </div>
                </div>

                <!-- Información Profesional -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center border-b pb-3">
                        <i class="fas fa-briefcase mr-2 text-blue-600"></i>
                        Información Profesional
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Especialidad -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-certificate mr-1 text-gray-500"></i>
                                Especialidad
                            </label>
                            <select 
                                name="especialidad" 
                                x-model="formData.especialidad"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            >
                                <option value="">Seleccionar...</option>
                                <option value="futbol">Fútbol</option>
                                <option value="baloncesto">Baloncesto</option>
                                <option value="voleibol">Voleibol</option>
                                <option value="natacion">Natación</option>
                                <option value="atletismo">Atletismo</option>
                                <option value="gimnasia">Gimnasia</option>
                            </select>
                        </div>

                        <!-- Años de Experiencia -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-award mr-1 text-gray-500"></i>
                                Años de Experiencia
                            </label>
                            <input 
                                type="number" 
                                name="anos_experiencia" 
                                x-model="formData.anos_experiencia"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                min="0"
                                max="50"
                                placeholder="Ej: 5"
                            >
                        </div>

                        <!-- Biografía Profesional -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-alt mr-1 text-gray-500"></i>
                                Biografía
                            </label>
                            <textarea 
                                name="biografia" 
                                x-model="formData.biografia"
                                rows="4"
                                maxlength="1000"
                                @input="biografiaLength = $event.target.value.length"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                placeholder="Cuéntanos sobre tu experiencia, logros profesionales, metodología de entrenamiento, certificaciones..."
                            ></textarea>
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Máximo 1000 caracteres
                                </p>
                                <p class="text-xs text-gray-500">
                                    <span x-text="biografiaLength"></span>/1000
                                </p>
                            </div>
                        </div>

                        <!-- Enlaces Profesionales -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-link mr-1 text-gray-500"></i>
                                Enlaces 
                                <span class="text-xs text-gray-500 font-normal">(Opcional)</span>
                            </label>
                            <div class="space-y-3">
                                <template x-for="(enlace, index) in formData.enlaces" :key="index">
                                    <div class="flex gap-2 items-start">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-2">
                                            <input 
                                                type="text" 
                                                :name="'enlaces[' + index + '][nombre]'"
                                                x-model="formData.enlaces[index].nombre"
                                                placeholder="Nombre (ej: LinkedIn, Instagram, YouTube)"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                            >
                                            <input 
                                                type="url" 
                                                :name="'enlaces[' + index + '][url]'"
                                                x-model="formData.enlaces[index].url"
                                                placeholder="https://ejemplo.com"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-sm"
                                            >
                                        </div>
                                        <button 
                                            type="button"
                                            @click="formData.enlaces.splice(index, 1)"
                                            class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </template>

                                <button 
                                    type="button"
                                    @click="formData.enlaces.push({ nombre: '', url: '' })"
                                    class="w-full px-4 py-2 border-2 border-dashed border-gray-300 hover:border-blue-500 text-gray-600 hover:text-blue-600 rounded-lg transition flex items-center justify-center"
                                >
                                    <i class="fas fa-plus mr-2"></i>
                                    Agregar enlace
                                </button>

                                <p class="text-xs text-gray-500 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Agrega enlaces a tus redes sociales profesionales, canal de YouTube, sitio web, etc.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-between gap-3">
                    <!-- Botón Restablecer Cambios -->
                    <button 
                        type="button"
                        @click="resetForm()"
                        class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition shadow-lg hover:shadow-xl transform hover:scale-105 duration-200"
                    >
                        <i class="fas fa-undo mr-2"></i>Restablecer Cambios
                    </button>

                    <!-- Botón Guardar Cambios -->
                    <button 
                        type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-semibold transition shadow-lg hover:shadow-xl transform hover:scale-105 duration-200"
                    >
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function perfilData() {
    // Datos originales de la base de datos
    const originalData = {
        name: '{{ old("name", auth()->user()->name) }}',
        email: '{{ auth()->user()->email }}',
        telefono: '{{ old("telefono", auth()->user()->telefono) }}',
        fecha_nacimiento: '{{ old("fecha_nacimiento", auth()->user()->fecha_nacimiento?->format("Y-m-d")) }}',
        direccion: '{{ old("direccion", auth()->user()->direccion) }}',
        especialidad: '{{ old("especialidad", auth()->user()->especialidad) }}',
        anos_experiencia: '{{ old("anos_experiencia", auth()->user()->anos_experiencia) }}',
        biografia: `{{ old("biografia", auth()->user()->biografia) }}`,
        enlaces: @json(old('enlaces', auth()->user()->enlaces ?? []))
    };

    return {
        // Modal de foto
        showModal: false,
        tempImage: '{{ auth()->user()->foto_url }}',
        currentImage: '{{ auth()->user()->foto_url }}',
        
        // Datos del formulario
        formData: JSON.parse(JSON.stringify(originalData)), // Copia profunda
        biografiaLength: {{ strlen(old('biografia', auth()->user()->biografia ?? '')) }},
        
        // Función para restablecer el formulario
        resetForm() {
            if (confirm('¿Estás seguro de que deseas restablecer todos los cambios?')) {
                this.formData = JSON.parse(JSON.stringify(originalData));
                this.biografiaLength = originalData.biografia.length;
                alert('✅ Cambios restablecidos correctamente');
            }
        }
    }
}
</script>

<style>
    [x-cloak] { display: none !important; }
    
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
