<!-- Evaluaciones del Jugador -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-clipboard-check text-purple-600 mr-3"></i>
            Mis Evaluaciones
        </h1>
        <div class="flex items-center space-x-3">
            <div class="text-sm text-gray-500">
                Total: {{ isset($observaciones) ? $observaciones->count() : 0 }} evaluaciones
            </div>
        </div>
    </div>

    <!-- Resumen de evaluaciones -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-thumbs-up text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Positivas</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ isset($observaciones) ? $observaciones->where('aspecto', 'like', '%positiv%')->count() : 0 }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">A mejorar</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ isset($observaciones) ? $observaciones->where('aspecto', 'like', '%mejorar%')->count() : 0 }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-calendar-alt text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Este mes</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ isset($observaciones) ? $observaciones->where('fecha', '>=', now()->startOfMonth())->count() : 0 }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-star text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Promedio</p>
                    <p class="text-xl font-bold text-gray-900">8.5</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas evaluaciones -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-clock text-blue-600 mr-2"></i>
                Últimas Evaluaciones
            </h3>
        </div>
        <div class="p-6">
            @if(isset($observaciones) && $observaciones->count() > 0)
                <div class="space-y-4">
                    @foreach($observaciones->sortByDesc('fecha')->take(5) as $observacion)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if(str_contains(strtolower($observacion->aspecto), 'positiv') || str_contains(strtolower($observacion->aspecto), 'excelen'))
                                                bg-green-100 text-green-800
                                            @elseif(str_contains(strtolower($observacion->aspecto), 'mejorar') || str_contains(strtolower($observacion->aspecto), 'deficien'))
                                                bg-yellow-100 text-yellow-800
                                            @else
                                                bg-blue-100 text-blue-800
                                            @endif">
                                            {{ $observacion->aspecto }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($observacion->fecha)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2">Observación Técnica</h4>
                                    <p class="text-gray-700 text-sm mb-3">{{ $observacion->detalle }}</p>
                                    @if($observacion->recomendaciones)
                                        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                                            <h5 class="text-sm font-medium text-blue-800 mb-1">
                                                <i class="fas fa-lightbulb mr-1"></i>Recomendaciones:
                                            </h5>
                                            <p class="text-sm text-blue-700">{{ $observacion->recomendaciones }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-tie text-purple-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay evaluaciones registradas</h3>
                    <p class="text-gray-500">Las evaluaciones de tu entrenador aparecerán aquí cuando las registre.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Historial completo de evaluaciones -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-history text-green-600 mr-2"></i>
                Historial de Evaluaciones
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aspecto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recomendaciones</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(isset($observaciones) && $observaciones->count() > 0)
                        @foreach($observaciones->sortByDesc('fecha') as $observacion)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($observacion->fecha)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if(str_contains(strtolower($observacion->aspecto), 'positiv') || str_contains(strtolower($observacion->aspecto), 'excelen'))
                                            bg-green-100 text-green-800
                                        @elseif(str_contains(strtolower($observacion->aspecto), 'mejorar') || str_contains(strtolower($observacion->aspecto), 'deficien'))
                                            bg-yellow-100 text-yellow-800
                                        @else
                                            bg-blue-100 text-blue-800
                                        @endif">
                                        {{ $observacion->aspecto }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                    <div class="truncate" title="{{ $observacion->detalle }}">
                                        {{ $observacion->detalle }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                    @if($observacion->recomendaciones)
                                        <div class="truncate" title="{{ $observacion->recomendaciones }}">
                                            {{ $observacion->recomendaciones }}
                                        </div>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(\Carbon\Carbon::parse($observacion->fecha)->isAfter(now()->subWeek()))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-clock mr-1"></i>Reciente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-check mr-1"></i>Revisado
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-clipboard-list text-4xl mb-4 text-gray-300"></i>
                                <p>No hay evaluaciones registradas</p>
                                <p class="text-sm mt-2">Tu entrenador aún no ha registrado evaluaciones.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Progreso y metas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-target text-yellow-600 mr-2"></i>
                Progreso y Metas
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Aspectos a mejorar -->
                <div>
                    <h4 class="font-medium text-gray-900 mb-4">Aspectos a Mejorar</h4>
                    @if(isset($observaciones) && $observaciones->where('recomendaciones', '!=', null)->count() > 0)
                        <div class="space-y-3">
                            @foreach($observaciones->where('recomendaciones', '!=', null)->take(3) as $observacion)
                                <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-yellow-600 mt-1"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $observacion->aspecto }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $observacion->recomendaciones }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-green-400 text-4xl mb-2"></i>
                            <p class="text-gray-500">No hay aspectos pendientes por mejorar</p>
                        </div>
                    @endif
                </div>

                <!-- Fortalezas identificadas -->
                <div>
                    <h4 class="font-medium text-gray-900 mb-4">Fortalezas Identificadas</h4>
                    @if(isset($observaciones) && $observaciones->count() > 0)
                        <div class="space-y-3">
                            @foreach($observaciones->where('aspecto', 'like', '%positiv%')->take(3) as $observacion)
                                <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $observacion->aspecto }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $observacion->detalle }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-star text-yellow-400 text-4xl mb-2"></i>
                            <p class="text-gray-500">Las fortalezas aparecerán con las evaluaciones</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>