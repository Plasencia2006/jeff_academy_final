<!-- Mi Entrenador - Vista Profesional Mejorada -->
<div class="space-y-6">
    <!-- Encabezado -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-chalkboard-teacher text-blue-600 mr-3"></i>
                Mi Entrenador
            </h1>
            <p class="text-gray-600 mt-2">Conoce a tu entrenador y su trayectoria profesional</p>
        </div>
        <div class="flex items-center space-x-3">
            @php
                $inscripcion = Auth::user()->inscripciones()->first();
                $entrenador = $inscripcion && $inscripcion->entrenador_id ? \App\Models\User::find($inscripcion->entrenador_id) : null;
            @endphp
            @if($entrenador)
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 shadow-sm">
                    <i class="fas fa-check-circle mr-2"></i>Entrenador Asignado
                </span>
            @else
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 shadow-sm">
                    <i class="fas fa-clock mr-2"></i>Pendiente de Asignación
                </span>
            @endif
        </div>
    </div>

    @if($entrenador)
        <!-- Perfil del Entrenador -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- COLUMNA IZQUIERDA: Foto y Card Principal -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Card Principal del Entrenador -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-xl p-8 text-white hover:shadow-2xl transition-shadow duration-300">
                    <div class="text-center">
                        <div class="mb-6">
                            <img src="{{ $entrenador->foto_url }}" 
                                 alt="{{ $entrenador->name }}" 
                                 class="w-36 h-36 rounded-full mx-auto object-cover border-4 border-white shadow-lg ring-4 ring-blue-300">
                        </div>
                        <h2 class="text-2xl font-bold mb-2">{{ $entrenador->name }}</h2>
                        <p class="text-blue-100 mb-1">
                            <i class="fas fa-certificate mr-2"></i>{{ ucfirst($entrenador->especialidad ?? 'Entrenador Profesional') }}
                        </p>
                        <p class="text-blue-200 text-sm mb-6">
                            <i class="fas fa-users mr-1"></i>
                            Categoría: <strong>{{ $inscripcion->categoria ?? 'N/A' }}</strong>
                        </p>
                        
                        <!-- Estadísticas -->
                        <div class="grid grid-cols-2 gap-4 pt-6 border-t border-blue-400">
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $entrenador->anos_experiencia ?? '0' }}</div>
                                <div class="text-blue-200 text-sm">Años</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ $entrenador->inscripcionesComoEntrenador->count() }}</div>
                                <div class="text-blue-200 text-sm">Jugadores</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Enlaces Sociales (SI EXISTEN) -->
                @if($entrenador->enlaces && count($entrenador->enlaces) > 0)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-share-alt text-blue-600 mr-2"></i>
                        Redes Sociales
                    </h3>
                    <div class="space-y-3">
                        @foreach($entrenador->enlaces as $enlace)
                            @if(!empty($enlace['nombre']) && !empty($enlace['url']))
                            <a href="{{ $enlace['url'] }}" 
                               target="_blank" 
                               class="flex items-center p-3 bg-gray-50 hover:bg-blue-50 rounded-lg transition-colors group">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                                        @php
                                            $iconClass = 'fas fa-link text-blue-600 group-hover:text-white';
                                            $nombre = strtolower($enlace['nombre']);
                                            if (str_contains($nombre, 'linkedin')) $iconClass = 'fab fa-linkedin text-blue-600 group-hover:text-white';
                                            elseif (str_contains($nombre, 'instagram')) $iconClass = 'fab fa-instagram text-blue-600 group-hover:text-white';
                                            elseif (str_contains($nombre, 'facebook')) $iconClass = 'fab fa-facebook text-blue-600 group-hover:text-white';
                                            elseif (str_contains($nombre, 'twitter') || str_contains($nombre, 'x')) $iconClass = 'fab fa-twitter text-blue-600 group-hover:text-white';
                                            elseif (str_contains($nombre, 'youtube')) $iconClass = 'fab fa-youtube text-blue-600 group-hover:text-white';
                                            elseif (str_contains($nombre, 'tiktok')) $iconClass = 'fab fa-tiktok text-blue-600 group-hover:text-white';
                                        @endphp
                                        <i class="{{ $iconClass }}"></i>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="font-medium text-gray-900 group-hover:text-blue-600">{{ $enlace['nombre'] }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $enlace['url'] }}</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 group-hover:text-blue-600 text-sm"></i>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- COLUMNA DERECHA: Información Detallada -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Información de Contacto -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="border-b border-gray-100 pb-4 mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-user-tie text-blue-600 mr-2"></i>
                            Información de Contacto
                        </h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors group">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-600 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fas fa-envelope text-blue-600 group-hover:text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-1">Correo Electrónico</p>
                                <a href="mailto:{{ $entrenador->email }}" class="font-medium text-gray-900 hover:text-blue-600 break-all">
                                    {{ $entrenador->email }}
                                </a>
                            </div>
                        </div>

                        <!-- Teléfono -->
                        @if($entrenador->telefono)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-green-50 transition-colors group">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 group-hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors">
                                    <i class="fas fa-phone text-green-600 group-hover:text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-1">Teléfono</p>
                                <a href="tel:{{ $entrenador->telefono }}" class="font-medium text-gray-900 hover:text-green-600">
                                    {{ $entrenador->telefono }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Especialidad -->
                        @if($entrenador->especialidad)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-certificate text-purple-600 text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-1">Especialidad</p>
                                <p class="font-medium text-gray-900">{{ ucfirst($entrenador->especialidad) }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Experiencia -->
                        @if($entrenador->anos_experiencia)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-award text-yellow-600 text-lg"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-1">Años de Experiencia</p>
                                <p class="font-medium text-gray-900">{{ $entrenador->anos_experiencia }} años</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Biografía -->
                @if($entrenador->biografia)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="border-b border-gray-100 pb-4 mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                            Acerca del Entrenador
                        </h3>
                    </div>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed text-justify">{{ $entrenador->biografia }}</p>
                    </div>
                </div>
                @endif

                <!-- Datos Adicionales -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-6 border border-blue-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Información Adicional
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-sm text-gray-500 mb-1">Tu Categoría</p>
                            <p class="text-lg font-bold text-gray-900">{{ $inscripcion->categoria ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-sm text-gray-500 mb-1">Temporada Actual</p>
                            <p class="text-lg font-bold text-gray-900">{{ date('Y') }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-sm text-gray-500 mb-1">Estado</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Activo
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Sin entrenador asignado -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="p-16 text-center">
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full">
                        <i class="fas fa-user-times text-gray-400 text-5xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">No tienes un entrenador asignado</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto text-lg">
                    Aún no has sido asignado a un entrenador. Por favor, contacta con el administrador de la academia para más información.
                </p>
                <div class="inline-flex items-center px-6 py-3 bg-blue-100 text-blue-700 rounded-lg font-medium shadow-sm hover:shadow-md transition-shadow">
                    <i class="fas fa-info-circle mr-2"></i>
                    Pendiente de asignación
                </div>
            </div>
        </div>
    @endif
</div>
