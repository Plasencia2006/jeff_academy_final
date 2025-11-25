@php
    $categorias = [
        'sub8' => 'Sub-8',
        'sub12' => 'Sub-12',
        'sub14' => 'Sub-14',
        'sub16' => 'Sub-16',
        'avanzado' => 'Avanzado'
    ];

    $posiciones = [
        'portero' => 'Portero',
        'defensa' => 'Defensa',
        'mediocampista' => 'Mediocampista',
        'delantero' => 'Delantero'
    ];
@endphp

<!-- Gestión de Estadísticas - Estilo TailPanel -->
<div class="space-y-6" x-data="{ currentView: 'main', selectedPosition: '', showStats: false }">
    <!-- Encabezado -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-chart-line text-blue-600 mr-3"></i>
                Estadísticas Deportivas
            </h1>
            <p class="text-gray-600 mt-1">Registra y consulta el rendimiento de tus jugadores</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                <i class="fas fa-users mr-1"></i>
                {{ $inscripciones->count() }} jugadores
            </span>
        </div>
    </div>

    <!-- Vista Principal -->
    <div x-show="currentView === 'main'" class="space-y-6">
        <!-- Acciones principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Registrar Estadísticas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer" 
                 @click="currentView = 'registrar'">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Registrar Estadísticas</h3>
                    <p class="text-gray-600 mb-4">Registra el rendimiento del día de hoy</p>
                    <div class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Comenzar Registro
                    </div>
                </div>
            </div>

            <!-- Ver Historial -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer" 
                 @click="currentView = 'historial'">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-history text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ver Historial</h3>
                    <p class="text-gray-600 mb-4">Consulta las estadísticas registradas</p>
                    <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Ver Registros
                    </div>
                </div>
            </div>
        </div>

        <!-- Top jugadores -->
        @php
            $topJugadores = $jugadoresData->sortByDesc('total_goles')->take(5)->values();
        @endphp
        
        @if($topJugadores->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                    Top Jugadores
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4" id="listaTopJugadores">
                    @foreach($topJugadores as $index => $jugador)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg top-jugador-item"
                             data-categoria="{{ strtolower($jugador['inscripciones']->first()->categoria ?? '') }}"
                             data-nombre="{{ strtolower($jugador['jugador']->name ?? '') }}">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white
                                    @if($index === 0) bg-yellow-500
                                    @elseif($index === 1) bg-gray-400
                                    @elseif($index === 2) bg-orange-600
                                    @else bg-blue-500 @endif">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">
                                        {{ $jugador['jugador']->name ?? 'Jugador' }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $categorias[$jugador['inscripciones']->first()->categoria ?? ''] ?? ucfirst($jugador['inscripciones']->first()->categoria ?? '') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $jugador['total_goles'] ?? 0 }} goles
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $jugador['total_asistencias'] ?? 0 }} asistencias
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Lista de jugadores con estadísticas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users text-purple-600 mr-2"></i>
                    Rendimiento por Jugador
                </h3>
            </div>
            <div class="p-6">
                <!-- Filtros para la lista -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Categoría</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                id="filtroCategoriaMain" @change="filtrarMain()">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Jugador</label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               id="filtroJugadorMain" 
                               placeholder="Nombre..." 
                               @keyup="filtrarMain()">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="listaRendimiento">
                    @foreach($jugadoresData as $data)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow jugador-card"
                             data-categoria="{{ strtolower($data['inscripciones']->first()->categoria ?? '') }}"
                             data-nombre="{{ strtolower($data['jugador']->name ?? '') }}">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $data['jugador']->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $categorias[$data['inscripciones']->first()->categoria ?? ''] ?? ucfirst($data['inscripciones']->first()->categoria ?? '') }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Goles:</span>
                                    <span class="font-medium text-gray-900">{{ $data['total_goles'] ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Asistencias:</span>
                                    <span class="font-medium text-gray-900">{{ $data['total_asistencias'] ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Partidos:</span>
                                    <span class="font-medium text-gray-900">{{ $data['total_partidos'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Vista de Registro -->
    <div x-show="currentView === 'registrar'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="currentView = 'main'" 
                                class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                            Registrar Estadísticas
                        </h3>
                    </div>
                    <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
            
            <div class="p-6">
                <form action="{{ route('estadisticas.store') }}" method="POST" class="space-y-6" id="formEstadisticas">
                    @csrf
                    
                    <!-- Reemplaza la sección de Categoría y Posición con esto: -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jugador</label>
                            <select name="inscripcion_id" id="jugadorSelect" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione jugador...</option>
                                @foreach($inscripciones as $inscripcion)
                                <option value="{{ $inscripcion->id }}" 
                                        data-categoria="{{ strtolower($inscripcion->categoria) }}"
                                        data-posicion="{{ strtolower($inscripcion->jugador->posicion ?? '') }}">
                                    {{ $inscripcion->jugador->name }} - {{ $categorias[$inscripcion->categoria] ?? ucfirst($inscripcion->categoria) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <input type="text" id="categoriaDisplay" readonly
                                class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed"
                                placeholder="Se completará automáticamente">
                            <!-- Campo hidden para enviar el valor real -->
                            <input type="hidden" name="categoria" id="categoriaInput">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Posición</label>
                            <input type="text" id="posicionDisplay" readonly
                                class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed"
                                placeholder="Se completará automáticamente">
                            <!-- Campo hidden para enviar el valor real en minúsculas -->
                            <input type="hidden" name="posicion" id="posicionInput">
                        </div>
                    </div>


                    <!-- Fecha -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <input type="date" name="fecha" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Mensaje de selección -->
                    <div id="mensajeSeleccion" class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                        <i class="fas fa-info-circle text-blue-600 text-2xl mb-2 block"></i>
                        <p class="text-blue-800 font-medium">Seleccione un jugador para mostrar los campos de estadísticas</p>
                    </div>

                    <!-- Campos de estadísticas dinámicos -->
                    <div id="contenedorEstadisticas" style="display: none;" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Estadísticas Defensivas -->
                            <div id="estadisticasDefensivas" class="space-y-4">
                                <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                                    <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                                    Estadísticas Defensivas
                                </h4>
                                <div id="camposDefensivos"></div>
                            </div>

                            <!-- Estadísticas Ofensivas -->
                            <div id="estadisticasOfensivas" class="space-y-4">
                                <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">
                                    <i class="fas fa-bullseye text-green-600 mr-2"></i>
                                    Estadísticas Ofensivas
                                </h4>
                                <div id="camposOfensivos"></div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Observaciones Adicionales</h4>
                            <textarea name="observaciones" rows="4" 
                                      placeholder="Comentarios sobre el rendimiento del jugador..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" @click="currentView = 'main'" 
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>Guardar Estadísticas
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Vista de Historial -->
    <div x-show="currentView === 'historial'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="currentView = 'main'" 
                                class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-history text-blue-600 mr-2"></i>
                            Historial de Estadísticas
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Filtros -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                id="filtroHistorialCategoria" @change="filtrarHistorialEstadisticas()">
                            <option value="">Todas</option>
                            @foreach($categorias as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Posición</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                id="filtroHistorialPosicion" @change="filtrarHistorialEstadisticas()">
                            <option value="">Todas</option>
                            @foreach($posiciones as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                        <input type="date" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                               id="filtroHistorialDesde" @change="filtrarHistorialEstadisticas()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                        <input type="date" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                               id="filtroHistorialHasta" @change="filtrarHistorialEstadisticas()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Jugador</label>
                        <input type="text" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                               id="filtroHistorialJugador" 
                               placeholder="Nombre..." 
                               @keyup="filtrarHistorialEstadisticas()">
                    </div>
                </div>

                <!-- Botón para limpiar filtros -->
                <div class="flex justify-end mb-4">
                    <button type="button" @click="limpiarFiltrosHistorial()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                        <i class="fas fa-eraser mr-2"></i>Limpiar Filtros
                    </button>
                </div>

                <!-- Tabla de historial -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="tablaHistorialEstadisticas">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jugador</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posición</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atajadas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Despejes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recuperaciones</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intercepciones</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entradas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">P. Completos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asistencias</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goles</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiros Arco</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if(isset($estadisticas) && $estadisticas->count() > 0)
                                @foreach($estadisticas as $stat)
                                    <tr class="fila-estadistica-historial hover:bg-gray-50"
                                        data-categoria="{{ strtolower($stat->categoria ?? '') }}"
                                        data-posicion="{{ strtolower($stat->posicion ?? '') }}"
                                        data-fecha="{{ $stat->fecha ?? '' }}"
                                        data-jugador="{{ strtolower($stat->inscripcion->jugador->name ?? '') }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($stat->fecha)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $stat->inscripcion->jugador->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $categorias[$stat->categoria ?? ''] ?? ucfirst($stat->categoria ?? 'N/A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $posiciones[$stat->posicion ?? ''] ?? ucfirst($stat->posicion ?? 'N/A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->atajadas ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->despejes ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->recuperaciones ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->intercepciones ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->entradas ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->pases_completos ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->asistencias ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->goles ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->tiros_arco ?? 0 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $stat->observaciones ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="14" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay estadísticas registradas
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Configuración de campos por posición
const camposPorPosicion = {
    'portero': {
        defensivas: [
            { nombre: 'atajadas', label: 'Atajadas' },
            { nombre: 'despejes', label: 'Despejes' }
        ],
        ofensivas: [
            { nombre: 'pases_completos', label: 'Pases Completos' }
        ]
    },
    'defensa': {
        defensivas: [
            { nombre: 'entradas', label: 'Entradas' },
            { nombre: 'intercepciones', label: 'Intercepciones' },
            { nombre: 'recuperaciones', label: 'Recuperaciones' },
            { nombre: 'despejes', label: 'Despejes' }
        ],
        ofensivas: [
            { nombre: 'pases_completos', label: 'Pases Completos' },
            { nombre: 'asistencias', label: 'Asistencias' },
            { nombre: 'goles', label: 'Goles' }
        ]
    },
    'mediocampista': {
        defensivas: [
            { nombre: 'recuperaciones', label: 'Recuperaciones' },
            { nombre: 'intercepciones', label: 'Intercepciones' },
            { nombre: 'entradas', label: 'Entradas' }
        ],
        ofensivas: [
            { nombre: 'pases_completos', label: 'Pases Completos' },
            { nombre: 'asistencias', label: 'Asistencias' },
            { nombre: 'goles', label: 'Goles' },
            { nombre: 'tiros_arco', label: 'Tiros al Arco' }
        ]
    },
    'delantero': {
        defensivas: [
            { nombre: 'recuperaciones', label: 'Recuperaciones' },
            { nombre: 'entradas', label: 'Entradas' }
        ],
        ofensivas: [
            { nombre: 'goles', label: 'Goles' },
            { nombre: 'tiros_arco', label: 'Tiros al Arco' },
            { nombre: 'asistencias', label: 'Asistencias' },
            { nombre: 'pases_completos', label: 'Pases Completos' }
        ]
    }
};

// Event listener para el selector de jugador
document.getElementById('jugadorSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const categoria = selectedOption.getAttribute('data-categoria');
    const posicion = selectedOption.getAttribute('data-posicion');
    
    // Debug en consola
    console.log('=== SELECCIÓN DE JUGADOR ===');
    console.log('Inscripción ID:', this.value);
    console.log('Categoría:', categoria);
    console.log('Posición original:', posicion);
    
    if (!this.value) {
        resetFormulario();
        return;
    }
    
    // Completar campo de categoría
    if (categoria) {
        document.getElementById('categoriaDisplay').value = categoria.toUpperCase();
        document.getElementById('categoriaInput').value = categoria;
    }
    
    // Validar que la posición exista y no esté vacía
    if (!posicion || posicion.trim() === '') {
        alert('El jugador seleccionado no tiene una posición definida en su perfil. Por favor, actualiza su perfil primero.');
        resetFormulario();
        return;
    }
    
    // Normalizar posición a minúsculas
    const posicionNormalizada = posicion.toLowerCase().trim();
    console.log('Posición normalizada:', posicionNormalizada);
    
    // Validar que la posición sea válida
    if (!camposPorPosicion[posicionNormalizada]) {
        alert('La posición "' + posicion + '" no es válida. Debe ser: Portero, Defensa, Mediocampista o Delantero.');
        resetFormulario();
        return;
    }
    
    // Completar campos de posición
    const posicionCapitalizada = posicionNormalizada.charAt(0).toUpperCase() + posicionNormalizada.slice(1);
    document.getElementById('posicionDisplay').value = posicionCapitalizada;
    document.getElementById('posicionInput').value = posicionNormalizada;
    
    console.log('Posición Display:', posicionCapitalizada);
    console.log('Posición Input (hidden):', posicionNormalizada);
    console.log('Valor del campo hidden:', document.getElementById('posicionInput').value);
    
    // Generar campos dinámicos
    generarCamposPorPosicion(posicionNormalizada);
});

function generarCamposPorPosicion(posicion) {
    const campos = camposPorPosicion[posicion];
    
    if (!campos) {
        alert('Posición no válida: ' + posicion);
        resetFormulario();
        return;
    }
    
    // Generar campos defensivos
    const camposDefensivos = document.getElementById('camposDefensivos');
    camposDefensivos.innerHTML = '';
    
    if (campos.defensivas && campos.defensivas.length > 0) {
        campos.defensivas.forEach(campo => {
            camposDefensivos.innerHTML += `
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">${campo.label}</label>
                    <input type="number" name="${campo.nombre}" min="0" value="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            `;
        });
        document.getElementById('estadisticasDefensivas').style.display = 'block';
    } else {
        document.getElementById('estadisticasDefensivas').style.display = 'none';
    }
    
    // Generar campos ofensivos
    const camposOfensivos = document.getElementById('camposOfensivos');
    camposOfensivos.innerHTML = '';
    
    if (campos.ofensivas && campos.ofensivas.length > 0) {
        campos.ofensivas.forEach(campo => {
            camposOfensivos.innerHTML += `
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">${campo.label}</label>
                    <input type="number" name="${campo.nombre}" min="0" value="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            `;
        });
        document.getElementById('estadisticasOfensivas').style.display = 'block';
    } else {
        document.getElementById('estadisticasOfensivas').style.display = 'none';
    }
    
    // Mostrar contenedor de estadísticas
    document.getElementById('mensajeSeleccion').style.display = 'none';
    document.getElementById('contenedorEstadisticas').style.display = 'block';
}

function resetFormulario() {
    document.getElementById('categoriaDisplay').value = '';
    document.getElementById('categoriaInput').value = '';
    document.getElementById('posicionDisplay').value = '';
    document.getElementById('posicionInput').value = '';
    document.getElementById('mensajeSeleccion').style.display = 'block';
    document.getElementById('contenedorEstadisticas').style.display = 'none';
    document.getElementById('camposDefensivos').innerHTML = '';
    document.getElementById('camposOfensivos').innerHTML = '';
}

// Validación antes de enviar el formulario
document.getElementById('formEstadisticas').addEventListener('submit', function(e) {
    const posicionValue = document.getElementById('posicionInput').value;
    const categoriaValue = document.getElementById('categoriaInput').value;
    const inscripcionValue = document.getElementById('jugadorSelect').value;
    
    console.log('=== VALIDACIÓN ANTES DE ENVIAR ===');
    console.log('Inscripción ID:', inscripcionValue);
    console.log('Categoría:', categoriaValue);
    console.log('Posición:', posicionValue);
    
    if (!posicionValue || posicionValue.trim() === '') {
        e.preventDefault();
        alert('Error: La posición no está definida. Por favor, selecciona un jugador con posición válida.');
        return false;
    }
    
    if (!inscripcionValue || inscripcionValue === '') {
        e.preventDefault();
        alert('Error: Debe seleccionar un jugador.');
        return false;
    }
    
    // Validar que la posición sea una de las válidas
    const posicionesValidas = ['portero', 'defensa', 'mediocampista', 'delantero'];
    if (!posicionesValidas.includes(posicionValue)) {
        e.preventDefault();
        alert('Error: La posición "' + posicionValue + '" no es válida.');
        return false;
    }
    
    console.log('✓ Formulario válido, enviando...');
});

// Filtrar en vista principal
function filtrarMain() {
    const cat = document.getElementById('filtroCategoriaMain')?.value || '';
    const busqueda = document.getElementById('filtroJugadorMain')?.value.toLowerCase() || '';
    
    // Filtrar lista de rendimiento
    document.querySelectorAll('.jugador-card').forEach(card => {
        const cardCat = card.dataset.categoria || '';
        const cardNombre = card.dataset.nombre || '';
        
        const okCat = !cat || cardCat === cat;
        const okBusqueda = !busqueda || cardNombre.includes(busqueda);
        
        card.style.display = okCat && okBusqueda ? '' : 'none';
    });
    
    // Filtrar top jugadores
    document.querySelectorAll('.top-jugador-item').forEach(item => {
        const itemCat = item.dataset.categoria || '';
        const itemNombre = item.dataset.nombre || '';
        
        const okCat = !cat || itemCat === cat;
        const okBusqueda = !busqueda || itemNombre.includes(busqueda);
        
        item.style.display = okCat && okBusqueda ? '' : 'none';
    });
}

// Filtrar historial de estadísticas
function filtrarHistorialEstadisticas() {
    const cat = document.getElementById('filtroHistorialCategoria')?.value.toLowerCase() || '';
    const pos = document.getElementById('filtroHistorialPosicion')?.value.toLowerCase() || '';
    const desde = document.getElementById('filtroHistorialDesde')?.value || '';
    const hasta = document.getElementById('filtroHistorialHasta')?.value || '';
    const jugador = document.getElementById('filtroHistorialJugador')?.value.toLowerCase() || '';
    
    document.querySelectorAll('.fila-estadistica-historial').forEach(fila => {
        const filaCat = fila.dataset.categoria || '';
        const filaPos = fila.dataset.posicion || '';
        const filaFecha = fila.dataset.fecha || '';
        const filaJugador = fila.dataset.jugador || '';
        
        const okCat = !cat || filaCat === cat;
        const okPos = !pos || filaPos === pos;
        const okJugador = !jugador || filaJugador.includes(jugador);
        
        let okFecha = true;
        if (desde && filaFecha < desde) okFecha = false;
        if (hasta && filaFecha > hasta) okFecha = false;
        
        const mostrar = okCat && okPos && okFecha && okJugador;
        fila.style.display = mostrar ? '' : 'none';
    });
}

// Limpiar filtros de historial
function limpiarFiltrosHistorial() {
    document.getElementById('filtroHistorialCategoria').value = '';
    document.getElementById('filtroHistorialPosicion').value = '';
    document.getElementById('filtroHistorialDesde').value = '';
    document.getElementById('filtroHistorialHasta').value = '';
    document.getElementById('filtroHistorialJugador').value = '';
    filtrarHistorialEstadisticas();
}
</script>
@endpush

