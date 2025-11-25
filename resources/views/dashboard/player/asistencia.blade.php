<!-- Asistencia del Jugador -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            Mi Asistencia
        </h1>
        <div class="flex items-center space-x-3">
            @php
                $totalAsistencias = isset($asistencias) ? $asistencias->count() : 0;
                $asistenciasPresente = isset($asistencias) ? $asistencias->where('estado', 'presente')->count() : 0;
                $porcentajeAsistencia = $totalAsistencias > 0 ? round(($asistenciasPresente / $totalAsistencias) * 100) : 0;
            @endphp
            <div class="text-sm text-gray-500">
                Porcentaje general: <span class="font-semibold text-green-600">{{ $porcentajeAsistencia }}%</span>
            </div>
        </div>
    </div>

    <!--filtros -->

    <!-- Estadísticas de asistencia -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Presente</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $asistenciasPresente }}</p>
                    <p class="text-xs text-gray-500">Entrenamientos</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Tarde</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($asistencias) ? $asistencias->where('estado', 'tarde')->count() : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Llegadas tarde</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Ausente</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($asistencias) ? $asistencias->where('estado', 'ausente')->count() : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Inasistencias</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-percentage text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Porcentaje</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $porcentajeAsistencia }}%</p>
                    <p class="text-xs text-gray-500">De asistencia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico circular de asistencia -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-chart-pie text-blue-600 mr-2"></i>
                Resumen Visual de Asistencia
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Gráfico circular -->
                <div class="flex justify-center">
                    <div class="relative w-48 h-48">
                        @php
                            $ausencias = isset($asistencias) ? $asistencias->where('estado', 'ausente')->count() : 0;
                            $tardes = isset($asistencias) ? $asistencias->where('estado', 'tarde')->count() : 0;
                            
                            // Calcular porcentajes
                            $porcentajeAusente = $totalAsistencias > 0 ? round(($ausencias / $totalAsistencias) * 100) : 0;
                            $porcentajeTarde = $totalAsistencias > 0 ? round(($tardes / $totalAsistencias) * 100) : 0;
                            
                            // Para stroke-dasharray necesitamos la circunferencia (2πr = 100 para r=15.9155)
                            $circunferencia = 100;
                            
                            // Calcular los valores acumulados para offset
                            $offsetPresente = 0;
                            $offsetTarde = $porcentajeAsistencia;
                            $offsetAusente = $porcentajeAsistencia + $porcentajeTarde;
                        @endphp
                        
                        <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 36 36">
                            <!-- Fondo del círculo -->
                            <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" 
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            
                            <!-- Segmento verde (Presente) -->
                            @if($porcentajeAsistencia > 0)
                            <path class="text-green-500" stroke="currentColor" stroke-width="3" fill="none" 
                                stroke-dasharray="{{ $porcentajeAsistencia }}, {{ $circunferencia }}" 
                                stroke-dashoffset="0"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            @endif
                            
                            <!-- Segmento amarillo (Tarde) -->
                            @if($porcentajeTarde > 0)
                            <path class="text-yellow-500" stroke="currentColor" stroke-width="3" fill="none" 
                                stroke-dasharray="{{ $porcentajeTarde }}, {{ $circunferencia }}" 
                                stroke-dashoffset="-{{ $offsetTarde }}"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            @endif
                            
                            <!-- Segmento rojo (Ausente) -->
                            @if($porcentajeAusente > 0)
                            <path class="text-red-500" stroke="currentColor" stroke-width="3" fill="none" 
                                stroke-dasharray="{{ $porcentajeAusente }}, {{ $circunferencia }}" 
                                stroke-dashoffset="-{{ $offsetAusente }}"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            @endif
                        </svg>
                        
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <span class="text-3xl font-bold text-gray-900">{{ $porcentajeAsistencia }}%</span>
                                <p class="text-sm text-gray-600">Asistencia</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Leyenda -->
                <div class="flex flex-col justify-center space-y-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Presente: {{ $asistenciasPresente }} ({{ $porcentajeAsistencia }}%)</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">
                            Tarde: {{ isset($asistencias) ? $asistencias->where('estado', 'tarde')->count() : 0 }}
                            ({{ $totalAsistencias > 0 ? round(($asistencias->where('estado', 'tarde')->count() / $totalAsistencias) * 100) : 0 }}%)
                        </span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">
                            Ausente: {{ isset($asistencias) ? $asistencias->where('estado', 'ausente')->count() : 0 }}
                            ({{ $totalAsistencias > 0 ? round(($asistencias->where('estado', 'ausente')->count() / $totalAsistencias) * 100) : 0 }}%)
                        </span>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">Total de registros: <span class="font-semibold">{{ $totalAsistencias }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de asistencia -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-history text-purple-600 mr-2"></i>
                Historial de Asistencia
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registro</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(isset($asistencias) && $asistencias->count() > 0)
                        @foreach($asistencias->sortByDesc('fecha') as $asistencia)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($asistencia->fecha)->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php $estado = strtolower(trim($asistencia->estado)); @endphp
                                    @if($estado === 'presente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Presente
                                        </span>
                                    @elseif($estado === 'tarde')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Tarde
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Ausente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $asistencia->observaciones ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $asistencia->created_at ? $asistencia->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-calendar-times text-4xl mb-4 text-gray-300"></i>
                                <p>No hay registros de asistencia</p>
                                <p class="text-sm mt-2">Los registros aparecerán cuando tu entrenador tome asistencia.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tendencia de asistencia -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-chart-line text-indigo-600 mr-2"></i>
                Tendencia de Asistencia
            </h3>
        </div>
        <div class="p-6">
            @if(isset($asistencias) && $asistencias->count() >= 4)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Últimas 4 semanas -->
                    <div class="text-center">
                        @php
                            $ultimasSemanas = $asistencias->where('fecha', '>=', now()->subWeeks(4));
                            $porcentajeUltimasSemanas = $ultimasSemanas->count() > 0 ? round(($ultimasSemanas->where('estado', 'presente')->count() / $ultimasSemanas->count()) * 100) : 0;
                        @endphp
                        <div class="text-2xl font-bold text-blue-600">{{ $porcentajeUltimasSemanas }}%</div>
                        <p class="text-sm text-gray-600">Últimas 4 semanas</p>
                        <p class="text-xs text-gray-500">{{ $ultimasSemanas->where('estado', 'presente')->count() }}/{{ $ultimasSemanas->count() }} entrenamientos</p>
                    </div>
                    
                    <!-- Este mes -->
                    <div class="text-center">
                        @php
                            $esteMes = $asistencias->where('fecha', '>=', now()->startOfMonth());
                            $porcentajeEsteMes = $esteMes->count() > 0 ? round(($esteMes->where('estado', 'presente')->count() / $esteMes->count()) * 100) : 0;
                        @endphp
                        <div class="text-2xl font-bold text-green-600">{{ $porcentajeEsteMes }}%</div>
                        <p class="text-sm text-gray-600">Este mes</p>
                        <p class="text-xs text-gray-500">{{ $esteMes->where('estado', 'presente')->count() }}/{{ $esteMes->count() }} entrenamientos</p>
                    </div>
                    
                    <!-- Racha actual -->
                    <div class="text-center">
                        @php
                            $rachaActual = 0;
                            $asistenciasOrdenadas = $asistencias->sortByDesc('fecha');
                            foreach($asistenciasOrdenadas as $asistencia) {
                                if(strtolower(trim($asistencia->estado)) === 'presente') {
                                    $rachaActual++;
                                } else {
                                    break;
                                }
                            }
                        @endphp
                        <div class="text-2xl font-bold text-purple-600">{{ $rachaActual }}</div>
                        <p class="text-sm text-gray-600">Racha actual</p>
                        <p class="text-xs text-gray-500">Entrenamientos consecutivos</p>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-chart-line text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">Necesitas al menos 4 registros para ver la tendencia</p>
                </div>
            @endif
        </div>
    </div>
</div>