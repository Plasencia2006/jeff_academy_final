<!-- pagina principal o dashboard del jugador -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-tachometer-alt text-blue-600 mr-3"></i>
            Dashboard
        </h1>
        <div class="text-sm text-gray-500">
            {{ now()->format('l, d \\d\\e F \\d\\e Y') }}
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Entrenamientos este mes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Entrenamientos</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($entrenamientos) ? $entrenamientos->where('fecha', '>=', now()->startOfMonth())->count() : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Este mes</p>
                </div>
            </div>
        </div>

        <!-- Asistencias -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Asistencias</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($asistencias) ? $asistencias->where('estado', 'presente')->count() : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
            </div>
        </div>

        <!-- Goles -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-futbol text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Goles</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($totalGoles) ? $totalGoles : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Esta temporada</p>
                </div>
            </div>
        </div>

        <!-- Evaluaciones -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Evaluaciones</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($observaciones) ? $observaciones->count() : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Recibidas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y contenido principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Próximos entrenamientos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                    Próximos Entrenamientos
                </h3>
            </div>
            <div class="p-6">
                @if(isset($entrenamientos) && $entrenamientos->where('fecha', '>=', now())->count() > 0)
                    <div class="space-y-4">
                        @foreach($entrenamientos->where('fecha', '>=', now())->sortBy('fecha')->take(3) as $entrenamiento)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-dumbbell text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $entrenamiento->tipo }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }} - {{ $entrenamiento->hora }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $entrenamiento->duracion }} min</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">No hay entrenamientos programados</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Rendimiento reciente -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-chart-line text-green-600 mr-2"></i>
                    Rendimiento Reciente
                </h3>
            </div>
            <div class="p-6">
                @if(isset($estadisticas) && $estadisticas->count() > 0)
                    <div class="space-y-4">
                        @foreach($estadisticas->sortByDesc('fecha')->take(3) as $estadistica)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($estadistica->fecha)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">Entrenamiento</p>
                                </div>
                                <div class="flex space-x-4 text-sm">
                                    <div class="text-center">
                                        <p class="font-bold text-blue-600">{{ $estadistica->goles ?? 0 }}</p>
                                        <p class="text-xs text-gray-500">Goles</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="font-bold text-green-600">{{ $estadistica->asistencias ?? 0 }}</p>
                                        <p class="text-xs text-gray-500">Asist.</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-chart-line text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">No hay estadísticas registradas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Progreso general -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-trophy text-yellow-600 mr-2"></i>
                Mi Progreso General
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Asistencia -->
                <div class="text-center">
                    <div class="relative w-20 h-20 mx-auto mb-4">
                        @php
                            $totalAsistencias = isset($asistencias) ? $asistencias->count() : 0;
                            $asistenciasPresente = isset($asistencias) ? $asistencias->where('estado', 'presente')->count() : 0;
                            $porcentajeAsistencia = $totalAsistencias > 0 ? round(($asistenciasPresente / $totalAsistencias) * 100) : 0;
                        @endphp
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-green-500" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="{{ $porcentajeAsistencia }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-sm font-bold text-gray-900">{{ $porcentajeAsistencia }}%</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Asistencia</p>
                    <p class="text-xs text-gray-500">{{ $asistenciasPresente }}/{{ $totalAsistencias }} entrenamientos</p>
                </div>

                <!-- Rendimiento -->
                <div class="text-center">
                    <div class="relative w-20 h-20 mx-auto mb-4">
                        @php
                            // Calcular rendimiento basado en estadísticas reales
                            $rendimiento = 0;
                            if (isset($estadisticas) && $estadisticas->count() > 0) {
                                // Calcular rendimiento basado en múltiples factores
                                $totalPartidos = $estadisticas->count();
                                $promedioGoles = $estadisticas->avg('goles') ?? 0;
                                $promedioAsistencias = $estadisticas->avg('asistencias') ?? 0;
                                $promedioPases = $estadisticas->avg('pases_completos') ?? 0;
                                $promedioRecuperaciones = $estadisticas->avg('recuperaciones') ?? 0;
                                
                                // Fórmula de rendimiento (ajustable según necesidades)
                                $factorOfensivo = ($promedioGoles * 20) + ($promedioAsistencias * 15);
                                $factorPases = min(($promedioPases / 10) * 15, 25); // Max 25 puntos por pases
                                $factorDefensivo = min($promedioRecuperaciones * 5, 15); // Max 15 puntos por recuperaciones
                                $factorAsistencia = $porcentajeAsistencia * 0.35; // 35% del peso por asistencia
                                
                                $rendimiento = min(round($factorOfensivo + $factorPases + $factorDefensivo + $factorAsistencia), 100);
                            } else {
                                // Si no hay estadísticas, usar solo asistencia
                                $rendimiento = round($porcentajeAsistencia * 0.8); // 80% del porcentaje de asistencia
                            }
                        @endphp
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-blue-500" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="{{ $rendimiento }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-sm font-bold text-gray-900">{{ $rendimiento }}%</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Rendimiento</p>
                    <p class="text-xs text-gray-500">Promedio general</p>
                </div>

                <!-- Mejora -->
                <div class="text-center">
                    <div class="relative w-20 h-20 mx-auto mb-4">
                        @php
                            // Calcular mejora comparando mes actual vs anterior
                            $mejora = 0;
                            if (isset($estadisticas) && $estadisticas->count() > 0) {
                                $mesActual = now()->startOfMonth();
                                $mesAnterior = now()->subMonth()->startOfMonth();
                                
                                // Estadísticas del mes actual
                                $statsActual = $estadisticas->where('fecha', '>=', $mesActual);
                                $statsAnterior = $estadisticas->where('fecha', '>=', $mesAnterior)
                                                              ->where('fecha', '<', $mesActual);
                                
                                if ($statsActual->count() > 0 && $statsAnterior->count() > 0) {
                                    // Calcular promedios de ambos meses
                                    $promedioActualGoles = $statsActual->avg('goles') ?? 0;
                                    $promedioActualAsistencias = $statsActual->avg('asistencias') ?? 0;
                                    $promedioActualPases = $statsActual->avg('pases_completos') ?? 0;
                                    
                                    $promedioAnteriorGoles = $statsAnterior->avg('goles') ?? 0;
                                    $promedioAnteriorAsistencias = $statsAnterior->avg('asistencias') ?? 0;
                                    $promedioAnteriorPases = $statsAnterior->avg('pases_completos') ?? 0;
                                    
                                    // Calcular porcentaje de mejora
                                    $totalActual = $promedioActualGoles + $promedioActualAsistencias + ($promedioActualPases / 10);
                                    $totalAnterior = $promedioAnteriorGoles + $promedioAnteriorAsistencias + ($promedioAnteriorPases / 10);
                                    
                                    if ($totalAnterior > 0) {
                                        $mejora = min(round((($totalActual - $totalAnterior) / $totalAnterior) * 100 + 50), 100);
                                        $mejora = max($mejora, 0); // No permitir valores negativos
                                    } else {
                                        $mejora = $totalActual > 0 ? 75 : 50; // Si no hay datos anteriores pero sí actuales
                                    }
                                } else if ($statsActual->count() > 0) {
                                    $mejora = 65; // Hay actividad este mes pero no el anterior
                                } else {
                                    $mejora = 30; // No hay actividad reciente
                                }
                            } else {
                                // Si no hay estadísticas, basar en asistencia
                                $mejora = $porcentajeAsistencia > 80 ? 70 : ($porcentajeAsistencia > 60 ? 50 : 30);
                            }
                        @endphp
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-purple-500" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="{{ $mejora }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-sm font-bold text-gray-900">{{ $mejora }}%</span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-900">Mejora</p>
                    <p class="text-xs text-gray-500">Vs mes anterior</p>
                </div>
            </div>
        </div>
    </div>
</div>
