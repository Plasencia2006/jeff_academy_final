<!-- Dashboard Principal del Coach - Estilo TailPanel Profesional -->
<div class="space-y-6">
    <!-- Encabezado del Dashboard -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <i class="fas fa-tachometer-alt text-blue-600 mr-2 sm:mr-3"></i>
                Dashboard del Coach
            </h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">
                Bienvenido de vuelta, <span class="font-semibold">{{ Auth::user()->name }}</span>
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-green-100 text-green-800">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                En línea
            </span>
            <span class="text-xs sm:text-sm text-gray-500">
                <i class="far fa-clock mr-1"></i>
                <span class="hidden sm:inline">{{ now()->locale('es')->isoFormat('D MMM YYYY, HH:mm') }}</span>
                <span class="sm:hidden">{{ now()->locale('es')->isoFormat('D MMM, HH:mm') }}</span>
            </span>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Jugadores -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm border border-blue-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-blue-700 mb-1">Jugadores Activos</p>
                    <p class="text-4xl font-bold text-blue-900">{{ $inscripciones->count() }}</p>
                    <p class="text-xs text-blue-600 mt-2 flex items-center">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $inscripciones->count() }} activos
                    </p>
                </div>
                <div class="p-4 bg-blue-200 rounded-2xl">
                    <i class="fas fa-users text-blue-700 text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Entrenamientos -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-sm border border-green-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-green-700 mb-1">Entrenamientos</p>
                    <p class="text-4xl font-bold text-green-900">{{ $entrenamientos->count() }}</p>
                    <p class="text-xs text-green-600 mt-2 flex items-center">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $entrenamientos->where('fecha', '>=', now()->startOfWeek())->where('fecha', '<=', now()->endOfWeek())->count() }} esta semana
                    </p>
                </div>
                <div class="p-4 bg-green-200 rounded-2xl">
                    <i class="fas fa-dumbbell text-green-700 text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Asistencias -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-sm border border-purple-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-purple-700 mb-1">Asistencias</p>
                    <p class="text-4xl font-bold text-purple-900">{{ $asistenciasHistorial->count() }}</p>
                    <p class="text-xs text-purple-600 mt-2 flex items-center">
                        <i class="fas fa-check mr-1"></i>
                        Registros totales
                    </p>
                </div>
                <div class="p-4 bg-purple-200 rounded-2xl">
                    <i class="fas fa-clipboard-check text-purple-700 text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Anuncios -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow-sm border border-orange-200 p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-orange-700 mb-1">Anuncios</p>
                    <p class="text-4xl font-bold text-orange-900">{{ $anuncios->where('activo', true)->count() }}</p>
                    <p class="text-xs text-orange-600 mt-2 flex items-center">
                        <i class="fas fa-eye mr-1"></i>
                        {{ $anuncios->where('activo', true)->where('vigente_hasta', '>=', now())->count() }} vigentes
                    </p>
                </div>
                <div class="p-4 bg-orange-200 rounded-2xl">
                    <i class="fas fa-bullhorn text-orange-700 text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Principal: Próximos Entrenamientos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Próximos Entrenamientos -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="p-4 sm:p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-transparent">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
                            Próximos Entrenamientos
                        </h3>
                        <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'gestion-entrenamientos' }))" 
                                class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm font-medium hover:underline transition-all">
                            Ver todos <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    @php
                        $proximosEntrenamientos = $entrenamientos->where('fecha', '>=', now()->toDateString())->sortBy('fecha')->sortBy('hora');
                    @endphp
                    
                    @if($proximosEntrenamientos->count() > 0)
                        <div class="space-y-3">
                            @foreach($proximosEntrenamientos->take(5) as $entrenamiento)
                                @php
                                    $fecha = \Carbon\Carbon::parse($entrenamiento->fecha);
                                    $horaInicio = $entrenamiento->hora;
                                    $horaFin = \Carbon\Carbon::parse($entrenamiento->hora)->addMinutes($entrenamiento->duracion ?? 90)->format('H:i');
                                    $esHoy = $fecha->isToday();
                                    $esMañana = $fecha->isTomorrow();
                                @endphp
                                <div class="flex items-start sm:items-center p-3 sm:p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors cursor-pointer border border-gray-100 hover:border-blue-200">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex flex-col items-center justify-center text-white shadow-md">
                                            <span class="text-xs font-medium">{{ $fecha->format('M') }}</span>
                                            <span class="text-lg sm:text-xl font-bold">{{ $fecha->format('d') }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-900 flex items-center flex-wrap gap-1">
                                                    <span class="truncate">{{ ucfirst($entrenamiento->tipo) }} - {{ ucfirst($entrenamiento->categoria) }}</span>
                                                    @if($esHoy)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 flex-shrink-0">
                                                            <i class="fas fa-circle text-orange-500 mr-1 text-xxs animate-pulse"></i>
                                                            Hoy
                                                        </span>
                                                    @elseif($esMañana)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 flex-shrink-0">
                                                            Mañana
                                                        </span>
                                                    @endif
                                                </h4>
                                                <p class="text-xs sm:text-sm text-gray-600 mt-0.5">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $horaInicio }} - {{ $horaFin }} 
                                                    <span class="hidden sm:inline">({{ $entrenamiento->duracion ?? 90 }} min)</span>
                                                </p>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    {{ ucfirst($entrenamiento->ubicacion) }}
                                                </p>
                                            </div>
                                            <div class="text-left sm:text-right flex-shrink-0">
                                                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $fecha->locale('es')->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 sm:py-16">
                            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full mb-4">
                                <i class="fas fa-calendar-times text-gray-400 text-2xl sm:text-3xl"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">No hay entrenamientos programados</h3>
                            <p class="text-sm sm:text-base text-gray-500 mb-4 sm:mb-6">Programa tu primer entrenamiento para comenzar.</p>
                            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'horarios' }))" 
                                    class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                Programar Entrenamiento
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-transparent">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt text-yellow-600 mr-2"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'asistencia' }))" 
                                class="w-full group flex items-center justify-between px-4 py-3 border-2 border-blue-200 rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-300 transition-all shadow-sm hover:shadow">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-clipboard-check text-blue-700"></i>
                                </div>
                                <span class="font-medium">Registrar Asistencia</span>
                            </div>
                            <i class="fas fa-chevron-right text-blue-400 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                        
                        <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'estadisticas' }))" 
                                class="w-full group flex items-center justify-between px-4 py-3 border-2 border-green-200 rounded-lg text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-300 transition-all shadow-sm hover:shadow">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-chart-line text-green-700"></i>
                                </div>
                                <span class="font-medium">Cargar Estadísticas</span>
                            </div>
                            <i class="fas fa-chevron-right text-green-400 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                        
                        <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'horarios' }))" 
                                class="w-full group flex items-center justify-between px-4 py-3 border-2 border-purple-200 rounded-lg text-purple-700 bg-purple-50 hover:bg-purple-100 hover:border-purple-300 transition-all shadow-sm hover:shadow">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-calendar-plus text-purple-700"></i>
                                </div>
                                <span class="font-medium">Programar Entrenamiento</span>
                            </div>
                            <i class="fas fa-chevron-right text-purple-400 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                        
                        <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'observaciones' }))" 
                                class="w-full group flex items-center justify-between px-4 py-3 border-2 border-orange-200 rounded-lg text-orange-700 bg-orange-50 hover:bg-orange-100 hover:border-orange-300 transition-all shadow-sm hover:shadow">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-orange-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-clipboard-list text-orange-700"></i>
                                </div>
                                <span class="font-medium">Añadir Observaciones</span>
                            </div>
                            <i class="fas fa-chevron-right text-orange-400 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                        
                        <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'anuncios' }))" 
                                class="w-full group flex items-center justify-between px-4 py-3 border-2 border-red-200 rounded-lg text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-300 transition-all shadow-sm hover:shadow">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-200 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-bullhorn text-red-700"></i>
                                </div>
                                <span class="font-medium">Crear Anuncio</span>
                            </div>
                            <i class="fas fa-chevron-right text-red-400 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Inferior: Top Jugadores-->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Jugadores -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-4 sm:p-6 border-b border-gray-100 bg-gradient-to-r from-yellow-50 to-transparent">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-trophy text-yellow-600 mr-2"></i>
                    Top Jugadores
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                @if($jugadoresData->count() > 0)
                    <div class="space-y-3">
                        @foreach($jugadoresData->sortByDesc('total_goles')->take(5) as $index => $data)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center font-bold text-base sm:text-lg
                                        @if($index === 0) bg-gradient-to-br from-yellow-400 to-yellow-600 text-white shadow-md
                                        @elseif($index === 1) bg-gradient-to-br from-gray-300 to-gray-500 text-white shadow-md
                                        @elseif($index === 2) bg-gradient-to-br from-orange-400 to-orange-600 text-white shadow-md
                                        @else bg-blue-100 text-blue-600 @endif">
                                        @if($index < 3)
                                            <i class="fas fa-medal text-sm sm:text-base"></i>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 truncate">
                                        {{ $data['jugador']->name }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-0.5 flex flex-wrap gap-2">
                                        <span>
                                            <i class="fas fa-futbol text-green-500 mr-1"></i>{{ $data['total_goles'] }} goles
                                        </span>
                                        <span>
                                            <i class="fas fa-hands-helping text-blue-500 mr-1"></i>{{ $data['total_asistencias'] }} asist.
                                        </span>
                                    </p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $data['total_goles'] + $data['total_asistencias'] }} pts
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 sm:py-12">
                        <div class="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 bg-gray-100 rounded-full mb-3">
                            <i class="fas fa-users text-gray-400 text-xl sm:text-2xl"></i>
                        </div>
                        <p class="text-sm sm:text-base text-gray-500">No hay datos de rendimiento aún</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actividad Reciente -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-green-50 to-transparent">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-clock text-green-600 mr-2"></i>
                    Actividad Reciente
                </h3>
            </div>
            <div class="p-6">
                @if($asistenciasHistorial->count() > 0)
                    <div class="space-y-3">
                        @foreach($asistenciasHistorial->take(6) as $asistencia)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full overflow-hidden shadow-sm
                                        @if($asistencia['estado'] === 'presente') bg-green-100
                                        @elseif($asistencia['estado'] === 'tarde') bg-yellow-100
                                        @else bg-red-100 @endif">

                                        <!--foto-->
                                        @if(!empty($asistencia['jugador_foto']))
                                            <img src="{{ $asistencia['jugador_foto'] }}"
                                                alt="{{ $asistencia['jugador_nombre'] }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center w-full h-full text-gray-600">
                                                <i class="fas fa-user text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $asistencia['jugador_nombre'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full font-medium
                                            @if($asistencia['estado'] === 'presente') bg-green-100 text-green-700
                                            @elseif($asistencia['estado'] === 'tarde') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700 @endif">
                                            {{ ucfirst($asistencia['estado']) }}
                                        </span>
                                        <span class="mx-1">- </span>
                                        {{ \Carbon\Carbon::parse($asistencia['fecha'])->locale('es')->format('d M') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                            <i class="fas fa-clipboard text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500">No hay actividad reciente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>