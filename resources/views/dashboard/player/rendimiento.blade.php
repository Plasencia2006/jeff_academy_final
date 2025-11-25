@php
    $posiciones = [
        'portero' => 'Portero',
        'defensa' => 'Defensa',
        'mediocampista' => 'Mediocampista',
        'delantero' => 'Delantero'
    ];
    
    // Obtener la posición del perfil del jugador
    $posicionJugador = $perfil->posicion ?? null;
    
    // Normalizar la posición
    $posicion = isset($posicionJugador) && !empty($posicionJugador) ? strtolower(trim($posicionJugador)) : '';
    $posicionNombre = isset($posiciones[$posicion]) ? $posiciones[$posicion] : 'Jugador';
    
    // Verificar si tiene posición definida
    $tienePosicion = !empty($posicion) && isset($posiciones[$posicion]);
    
    // Inicializar variables para evitar errores
    $totalAtajadas = $totalAtajadas ?? 0;
    $totalDespejes = $totalDespejes ?? 0;
    $totalPasesCompletos = $totalPasesCompletos ?? 0;
    $totalEntradas = $totalEntradas ?? 0;
    $totalIntercepciones = $totalIntercepciones ?? 0;
    $totalRecuperaciones = $totalRecuperaciones ?? 0;
    $totalGoles = $totalGoles ?? 0;
    $totalAsistencias = $totalAsistencias ?? 0;
    $totalTiros = $totalTiros ?? 0;
@endphp

<div class="space-y-6">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <!-- Título -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-chart-line text-blue-600 mr-2 sm:mr-3"></i>
                Mi Rendimiento
            </h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">
                Estadísticas y desempeño deportivo
            </p>
        </div>

        <!-- Etiqueta de posición -->
        @if($posicion)
        <div class="inline-flex items-center px-3 sm:px-4 py-2 bg-blue-100 
                    text-blue-800 rounded-lg font-semibold text-sm sm:text-base self-start sm:self-auto">
            <i class="fas fa-user-tag mr-2"></i>
            {{ $posicionNombre }}
        </div>
        @endif
    </div>

    @if(!$tienePosicion)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Posición no definida
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Por favor, actualiza tu perfil y define tu posición para ver estadísticas personalizadas.</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('player.dashboard') }}" 
                        class="inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-md transition-colors">
                            <i class="fas fa-pen mr-2"></i>
                            Ir al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(isset($estadisticas) && $estadisticas->count() > 0)
        <!-- Tarjetas de Resumen Dinámicas según Posición -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if($posicion === 'portero')
                <!-- Estadísticas para Portero -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Atajadas</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalAtajadas }}</p>
                        </div>
                        <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hands text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Total en todos los partidos</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Despejes</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalDespejes }}</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Intervenciones defensivas</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pases Completos</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalPasesCompletos }}</p>
                        </div>
                        <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-dot-circle text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Precisión en salida</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Partidos</p>
                            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $estadisticas->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Registros totales</p>
                </div>

            @elseif($posicion === 'defensa')
                <!-- Estadísticas para Defensa -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Entradas</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalEntradas }}</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-shield text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Duelos ganados</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Intercepciones</p>
                            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalIntercepciones }}</p>
                        </div>
                        <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exchange-alt text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Balones interceptados</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Recuperaciones</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalRecuperaciones }}</p>
                        </div>
                        <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-redo text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Balones recuperados</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Goles</p>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $totalGoles }}</p>
                        </div>
                        <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-futbol text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Contribución ofensiva</p>
                </div>

            @elseif($posicion === 'mediocampista')
                <!-- Estadísticas para Mediocampista -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pases Completos</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalPasesCompletos }}</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-dot-circle text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Control del juego</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Asistencias</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalAsistencias }}</p>
                        </div>
                        <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hands-helping text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Jugadas creadas</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Goles</p>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $totalGoles }}</p>
                        </div>
                        <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-futbol text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Anotaciones</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Recuperaciones</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalRecuperaciones }}</p>
                        </div>
                        <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-redo text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Balance defensivo</p>
                </div>

            @elseif($posicion === 'delantero')
                <!-- Estadísticas para Delantero -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Goles</p>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $totalGoles }}</p>
                        </div>
                        <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-futbol text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Total anotado</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Tiros al Arco</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $totalTiros }}</p>
                        </div>
                        <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-bullseye text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Intentos de gol</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Asistencias</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalAsistencias }}</p>
                        </div>
                        <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hands-helping text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Pases de gol</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Eficiencia</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">
                                @if($totalTiros > 0)
                                    {{ number_format(($totalGoles / $totalTiros) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Goles/Tiros</p>
                </div>

            @else
                <!-- Estadísticas Generales -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Goles</p>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $totalGoles }}</p>
                        </div>
                        <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-futbol text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Asistencias</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalAsistencias }}</p>
                        </div>
                        <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-hands-helping text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Recuperaciones</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalRecuperaciones }}</p>
                        </div>
                        <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-redo text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transform hover:scale-105 transition-transform">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Partidos</p>
                            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $estadisticas->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-indigo-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Gráficas de Rendimiento -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Gráfica de Evolución Temporal -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-area text-blue-600 mr-2"></i>
                    Evolución del Rendimiento
                </h3>
                <div style="position: relative; height: 250px;">
                    <canvas id="evolucionChart"></canvas>
                </div>
            </div>

            <!-- Gráfica por Posición -->
            @if($posicion === 'portero')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                        Distribución Defensiva
                    </h3>
                    <div style="position: relative; height: 250px;">
                        <canvas id="posicionChart"></canvas>
                    </div>
                </div>

            @elseif($posicion === 'defensa')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                        Desempeño Defensivo
                    </h3>
                    <div style="position: relative; height: 250px;">
                        <canvas id="posicionChart"></canvas>
                    </div>
                </div>

            @elseif($posicion === 'mediocampista')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-radar text-purple-600 mr-2"></i>
                        Balance de Juego
                    </h3>
                    <div style="position: relative; height: 250px;">
                        <canvas id="posicionChart"></canvas>
                    </div>
                </div>

            @elseif($posicion === 'delantero')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-orange-600 mr-2"></i>
                        Efectividad Ofensiva
                    </h3>
                    <div style="position: relative; height: 250px;">
                        <canvas id="posicionChart"></canvas>
                    </div>
                </div>

            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-pie text-indigo-600 mr-2"></i>
                        Distribución General
                    </h3>
                    <div style="position: relative; height: 250px;">
                        <canvas id="posicionChart"></canvas>
                    </div>
                </div>
            @endif
        </div>

        <!-- Tabla de Estadísticas Detalladas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-table text-blue-600 mr-2"></i>
                    Historial Detallado
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            @if($posicion === 'portero')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atajadas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Despejes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pases Completos</th>
                            @elseif($posicion === 'defensa')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entradas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intercepciones</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recuperaciones</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goles</th>
                            @elseif($posicion === 'mediocampista')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pases Completos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencias</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recuperaciones</th>
                            @elseif($posicion === 'delantero')
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiros al Arco</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencias</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eficiencia</th>
                            @else
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencias</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recuperaciones</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($estadisticas as $estadistica)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($estadistica->fecha)->format('d/m/Y') }}
                                </td>
                                @if($posicion === 'portero')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->atajadas ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->despejes ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->pases_completos ?? 0 }}</td>
                                @elseif($posicion === 'defensa')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->entradas ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->intercepciones ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->recuperaciones ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->goles ?? 0 }}</td>
                                @elseif($posicion === 'mediocampista')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->pases_completos ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->asistencias ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->goles ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->recuperaciones ?? 0 }}</td>
                                @elseif($posicion === 'delantero')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->goles ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->tiros_arco ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->asistencias ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if(isset($estadistica->tiros_arco) && $estadistica->tiros_arco > 0)
                                            {{ number_format(($estadistica->goles / $estadistica->tiros_arco) * 100, 1) }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                @else
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->goles ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->asistencias ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $estadistica->recuperaciones ?? 0 }}</td>
                                @endif
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $estadistica->observaciones ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Sin estadísticas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-chart-line text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay estadísticas registradas</h3>
            <p class="text-gray-600">Las estadísticas aparecerán cuando tu entrenador las registre.</p>
        </div>
    @endif
</div>

<script>
(function() {
    'use strict';
    
    // Esperar a que Chart.js esté disponible
    function initCharts() {
        if (typeof Chart === 'undefined') {
            setTimeout(initCharts, 100);
            return;
        }

        @if(isset($estadisticas) && $estadisticas->count() > 0)
            try {
                // Datos para las gráficas
                const fechasData = {!! json_encode($estadisticas->pluck('fecha')->map(function($fecha) {
                    return \Carbon\Carbon::parse($fecha)->format('d/m');
                })->values()->toArray()) !!};

                const posicion = '{{ $posicion }}';

                // Gráfica de Evolución Temporal
                const canvasEvolucion = document.getElementById('evolucionChart');
                if (canvasEvolucion) {
                    const ctxEvolucion = canvasEvolucion.getContext('2d');
                    
                    let datasetsEvolucion = [];
                    
                    @if($posicion === 'portero')
                        datasetsEvolucion = [
                            {
                                label: 'Atajadas',
                                data: {!! json_encode($estadisticas->pluck('atajadas')->values()->toArray()) !!},
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Despejes',
                                data: {!! json_encode($estadisticas->pluck('despejes')->values()->toArray()) !!},
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ];
                    @elseif($posicion === 'defensa')
                        datasetsEvolucion = [
                            {
                                label: 'Entradas',
                                data: {!! json_encode($estadisticas->pluck('entradas')->values()->toArray()) !!},
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Intercepciones',
                                data: {!! json_encode($estadisticas->pluck('intercepciones')->values()->toArray()) !!},
                                borderColor: '#6366f1',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Recuperaciones',
                                data: {!! json_encode($estadisticas->pluck('recuperaciones')->values()->toArray()) !!},
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ];
                    @elseif($posicion === 'mediocampista')
                        datasetsEvolucion = [
                            {
                                label: 'Pases Completos',
                                data: {!! json_encode($estadisticas->pluck('pases_completos')->values()->toArray()) !!},
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Asistencias',
                                data: {!! json_encode($estadisticas->pluck('asistencias')->values()->toArray()) !!},
                                borderColor: '#8b5cf6',
                                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Goles',
                                data: {!! json_encode($estadisticas->pluck('goles')->values()->toArray()) !!},
                                borderColor: '#f97316',
                                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ];
                    @elseif($posicion === 'delantero')
                        datasetsEvolucion = [
                            {
                                label: 'Goles',
                                data: {!! json_encode($estadisticas->pluck('goles')->values()->toArray()) !!},
                                borderColor: '#f97316',
                                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Tiros al Arco',
                                data: {!! json_encode($estadisticas->pluck('tiros_arco')->values()->toArray()) !!},
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Asistencias',
                                data: {!! json_encode($estadisticas->pluck('asistencias')->values()->toArray()) !!},
                                borderColor: '#8b5cf6',
                                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ];
                    @else
                        datasetsEvolucion = [
                            {
                                label: 'Goles',
                                data: {!! json_encode($estadisticas->pluck('goles')->values()->toArray()) !!},
                                borderColor: '#f97316',
                                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Asistencias',
                                data: {!! json_encode($estadisticas->pluck('asistencias')->values()->toArray()) !!},
                                borderColor: '#8b5cf6',
                                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ];
                    @endif

                    new Chart(ctxEvolucion, {
                        type: 'line',
                        data: {
                            labels: fechasData.slice().reverse(),
                            datasets: datasetsEvolucion.map(function(ds) {
                                return {
                                    label: ds.label,
                                    data: ds.data.slice().reverse(),
                                    borderColor: ds.borderColor,
                                    backgroundColor: ds.backgroundColor,
                                    tension: ds.tension,
                                    fill: ds.fill
                                };
                            })
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }

                // Gráfica específica por posición
                const canvasPosicion = document.getElementById('posicionChart');
                if (canvasPosicion) {
                    const ctxPosicion = canvasPosicion.getContext('2d');
                    
                    let chartConfig = {};
                    
                    @if($posicion === 'portero')
                        chartConfig = {
                            type: 'pie',
                            data: {
                                labels: ['Atajadas', 'Despejes', 'Pases Completos'],
                                datasets: [{
                                    data: [{{ $totalAtajadas }}, {{ $totalDespejes }}, {{ $totalPasesCompletos }}],
                                    backgroundColor: ['#10b981', '#3b82f6', '#8b5cf6'],
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    }
                                }
                            }
                        };
                    @elseif($posicion === 'defensa')
                        chartConfig = {
                            type: 'bar',
                            data: {
                                labels: ['Entradas', 'Intercepciones', 'Recuperaciones', 'Despejes'],
                                datasets: [{
                                    label: 'Total',
                                    data: [{{ $totalEntradas }}, {{ $totalIntercepciones }}, {{ $totalRecuperaciones }}, {{ $totalDespejes }}],
                                    backgroundColor: ['#3b82f6', '#6366f1', '#10b981', '#8b5cf6'],
                                    borderWidth: 1,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        };
                    @elseif($posicion === 'mediocampista')
                        chartConfig = {
                            type: 'radar',
                            data: {
                                labels: ['Pases', 'Asistencias', 'Goles', 'Recuperaciones', 'Intercepciones'],
                                datasets: [{
                                    label: 'Rendimiento',
                                    data: [
                                        {{ $totalPasesCompletos }}, 
                                        {{ $totalAsistencias }}, 
                                        {{ $totalGoles }}, 
                                        {{ $totalRecuperaciones }}, 
                                        {{ $totalIntercepciones }}
                                    ],
                                    backgroundColor: 'rgba(139, 92, 246, 0.2)',
                                    borderColor: '#8b5cf6',
                                    borderWidth: 2,
                                    pointBackgroundColor: '#8b5cf6',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: '#8b5cf6'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    r: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        };
                    @elseif($posicion === 'delantero')
                        chartConfig = {
                            type: 'line',
                            data: {
                                labels: ['Goles', 'Tiros al Arco', 'Asistencias', 'Eficiencia %'],
                                datasets: [{
                                    label: 'Estadísticas Ofensivas',
                                    data: [
                                        {{ $totalGoles }}, 
                                        {{ $totalTiros }}, 
                                        {{ $totalAsistencias }}, 
                                        {{ $totalTiros > 0 ? number_format(($totalGoles / $totalTiros) * 100, 1) : 0 }}
                                    ],
                                    backgroundColor: 'rgba(249, 115, 22, 0.2)',
                                    borderColor: '#f97316',
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        };
                    @else
                        chartConfig = {
                            type: 'doughnut',
                            data: {
                                labels: ['Goles', 'Asistencias', 'Recuperaciones'],
                                datasets: [{
                                    data: [{{ $totalGoles }}, {{ $totalAsistencias }}, {{ $totalRecuperaciones }}],
                                    backgroundColor: ['#f97316', '#8b5cf6', '#10b981'],
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    }
                                }
                            }
                        };
                    @endif

                    new Chart(ctxPosicion, chartConfig);
                }
            } catch (error) {
                console.error('Error al crear gráficas:', error);
            }
        @endif
    }

    // Iniciar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCharts);
    } else {
        initCharts();
    }
})();
</script>
