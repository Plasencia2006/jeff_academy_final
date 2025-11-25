<!-- Entrenamientos del Jugador -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
            Mis Entrenamientos
        </h1>
        <div class="flex items-center space-x-3">
            <div class="text-sm text-gray-500">
                Total: {{ isset($entrenamientos) ? $entrenamientos->count() : 0 }} entrenamientos
            </div>
        </div>
    </div>

    <!-- Filtros y estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-calendar-check text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Próximos</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ isset($entrenamientos) ? $entrenamientos->where('fecha', '>=', now())->count() : 0 }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Completados</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ isset($entrenamientos) ? $entrenamientos->where('fecha', '<', now())->count() : 0 }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Este mes</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ isset($entrenamientos) ? $entrenamientos->where('fecha', '>=', now()->startOfMonth())->count() : 0 }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-stopwatch text-purple-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Horas totales</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ isset($entrenamientos) ? round($entrenamientos->sum('duracion') / 60, 1) : 0 }}h
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Próximos entrenamientos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-calendar-plus text-blue-600 mr-2"></i>
                Próximos Entrenamientos
            </h3>
        </div>
        <div class="p-6">
            @if(isset($entrenamientos) && $entrenamientos->where('fecha', '>=', now())->count() > 0)
                <div class="space-y-4">
                    @foreach($entrenamientos->where('fecha', '>=', now())->sortBy('fecha')->take(5) as $entrenamiento)
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 hover:bg-gray-100 transition">

                            <!-- CABECERA: Ícono + Tipo + Categoría + Fecha -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                                <!-- Ícono y texto -->
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-dumbbell text-blue-600 text-xl"></i>
                                    </div>

                                    <div>
                                        <h4 class="text-base font-semibold text-gray-900 capitalize">
                                            {{ $entrenamiento->tipo ?? 'Entrenamiento' }}
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $entrenamiento->categoria ?? 'General' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Fecha -->
                                <div class="sm:text-center">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $entrenamiento->hora }}
                                    </p>
                                </div>

                                <!-- Estado -->
                                <div class="sm:text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        <i class="fas fa-clock mr-1"></i> Programado
                                    </span>
                                </div>
                            </div>

                            <!-- INFO EXTRA (duración, ubicación, entrenador) -->
                            <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                <span><i class="fas fa-clock mr-1"></i>{{ $entrenamiento->duracion }} min</span>
                                <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $entrenamiento->ubicacion ?? 'Por definir' }}</span>

                                @if($entrenamiento->entrenador)
                                    <span><i class="fas fa-user mr-1"></i>{{ $entrenamiento->entrenador->name }}</span>
                                @endif
                            </div>

                            <!-- OBJETIVOS -->
                            <div class="mt-3">
                                <p class="text-xs text-gray-600">
                                    <strong>Objetivos:</strong> {{ $entrenamiento->objetivos ?? 'N/A' }}
                                </p>
                            </div>

                        </div>

                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay entrenamientos programados</h3>
                    <p class="text-gray-500">Los próximos entrenamientos aparecerán aquí cuando sean programados por tu entrenador.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Historial de entrenamientos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-history text-green-600 mr-2"></i>
                Historial de Entrenamientos
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrenador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(isset($entrenamientos) && $entrenamientos->count() > 0)
                        @foreach($entrenamientos->sortByDesc('fecha') as $entrenamiento)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d/m/Y') }}
                                    <div class="text-xs text-gray-500">{{ $entrenamiento->hora }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $entrenamiento->tipo ?? 'Entrenamiento' }}</div>
                                    <div class="text-xs text-gray-500">{{ $entrenamiento->categoria ?? 'General' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $entrenamiento->duracion }} min
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $entrenamiento->ubicacion ?? 'No especificado' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $entrenamiento->entrenador ? $entrenamiento->entrenador->name : 'Sin asignar' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(\Carbon\Carbon::parse($entrenamiento->fecha)->isFuture())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-clock mr-1"></i>Programado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Completado
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-calendar-times text-4xl mb-4 text-gray-300"></i>
                                <p>No hay entrenamientos registrados</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>