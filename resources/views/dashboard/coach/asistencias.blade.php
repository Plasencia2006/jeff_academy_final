<!-- Gestión de Asistencias -->
@php
    $categorias = [
        'sub8' => 'Sub-8',
        'sub12' => 'Sub-12',
        'sub14' => 'Sub-14',
        'sub16' => 'Sub-16',
        'avanzado' => 'Avanzado'
    ];
@endphp

<div class="space-y-6" x-data="asistenciasManager()">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <i class="fas fa-clipboard-check text-blue-600 mr-2 sm:mr-3"></i>
                Gestión de Asistencias
            </h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Registra y consulta la asistencia de tus jugadores</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-users mr-2"></i>
                <span class="font-bold">{{ $inscripciones->count() }}</span>
                <span class="ml-1">Jugadores</span>
            </span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-green-100 text-green-800">
                <i class="fas fa-check mr-2"></i>
                <span class="font-bold">{{ $asistenciasHistorial->count() }}</span>
                <span class="ml-1">Registros</span>
            </span>
        </div>
    </div>

    <!-- Vista Principal -->
    <div x-show="currentView === 'main'" class="space-y-6">
        <!-- Acciones principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Registrar Asistencia -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer" 
                 @click="currentView = 'registro'">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-check text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Registrar Asistencia</h3>
                    <p class="text-gray-600 mb-4">Toma la asistencia del día de hoy</p>
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
                    <p class="text-gray-600 mb-4">Consulta las asistencias registradas</p>
                    <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Ver Registros
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista de Registro -->
    <div x-show="currentView === 'registro'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center">
                        <button @click="currentView = 'main'" 
                                class="mr-3 sm:mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-base sm:text-lg"></i>
                        </button>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                            <i class="fas fa-user-check text-green-600 mr-2"></i>
                            Registrar Asistencia
                        </h3>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
            
            <div class="p-4 sm:p-6">
                <form action="{{ route('coach.asistencias.store') }}" method="POST" class="space-y-6" id="formAsistencias">
                    @csrf
                    
                    <!-- Controles superiores -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Asistencia</label>
                            <input type="date" name="fecha" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Categoría</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    x-model="filtroCategoriaRegistro">
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
                                   x-model="filtroJugadorRegistro" 
                                   placeholder="Nombre...">
                        </div>
                    </div>

                    <!-- Lista de jugadores -->
                    <div class="space-y-3" id="listaJugadores">
                        @foreach($inscripciones as $inscripcion)
                            <div class="p-3 sm:p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors jugador-item" 
                                x-show="mostrarJugador('{{ strtolower($inscripcion->categoria) }}', '{{ strtolower($inscripcion->jugador->name ?? '') }}')"
                                data-categoria="{{ strtolower($inscripcion->categoria) }}"
                                data-inscripcion-id="{{ $inscripcion->id }}">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <!-- Info del jugador -->
                                    <div class="flex items-center space-x-3 min-w-0">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user text-gray-600 text-sm sm:text-base"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 truncate nombre-jugador">
                                                {{ $inscripcion->jugador->name ?? 'Sin nombre' }}
                                            </h4>
                                            <p class="text-xs text-gray-500 flex flex-wrap items-center gap-1">
                                                <span>ID: {{ $inscripcion->jugador_id }}</span>
                                                <span>•</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $categorias[$inscripcion->categoria] ?? ucfirst($inscripcion->categoria) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Estados de asistencia -->
                                    <div class="flex items-center justify-center sm:justify-end">
                                        <div class="flex bg-gray-100 rounded-lg p-1 gap-1">
                                            <input type="radio" 
                                                   name="asistencias[{{ $inscripcion->id }}][estado]" 
                                                   id="presente{{ $inscripcion->id }}" 
                                                   value="presente" 
                                                   class="estado-radio sr-only" 
                                                   checked>
                                            <label for="presente{{ $inscripcion->id }}" 
                                                class="estado-label px-2 py-1.5 text-xxs sm:text-xs font-medium rounded-md cursor-pointer transition-colors text-gray-700 hover:bg-green-100 whitespace-nowrap"
                                                @click="seleccionarEstado($event, 'presente')">
                                                <i class="fas fa-check mr-1"></i>Presente
                                            </label>
                                            
                                            <input type="radio" 
                                                   name="asistencias[{{ $inscripcion->id }}][estado]" 
                                                   id="tarde{{ $inscripcion->id }}" 
                                                   value="tarde" 
                                                   class="estado-radio sr-only">
                                            <label for="tarde{{ $inscripcion->id }}" 
                                                class="estado-label px-2 py-1.5 text-xxs sm:text-xs font-medium rounded-md cursor-pointer transition-colors text-gray-700 hover:bg-yellow-100 whitespace-nowrap"
                                                @click="seleccionarEstado($event, 'tarde')">
                                                <i class="fas fa-clock mr-1"></i>Tarde
                                            </label>
                                            
                                            <input type="radio" 
                                                   name="asistencias[{{ $inscripcion->id }}][estado]" 
                                                   id="ausente{{ $inscripcion->id }}" 
                                                   value="ausente" 
                                                   class="estado-radio sr-only">
                                            <label for="ausente{{ $inscripcion->id }}" 
                                                class="estado-label px-2 py-1.5 text-xxs sm:text-xs font-medium rounded-md cursor-pointer transition-colors text-gray-700 hover:bg-red-100 whitespace-nowrap"
                                                @click="seleccionarEstado($event, 'ausente')">
                                                <i class="fas fa-times mr-1"></i>Ausente
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Campo de observaciones -->
                                <div class="mt-3">
                                    <input type="text" 
                                           name="asistencias[{{ $inscripcion->id }}][observaciones]" 
                                           placeholder="Observaciones opcionales..."
                                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón guardar -->
                    <div class="flex justify-center gap-6 pt-4 border-t border-gray-200">
                        <button type="button" @click="currentView = 'main'" 
                                class="px-6 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                        <button type="submit" 
                                class="px-8 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            <span class="hidden sm:inline">Guardar Asistencias</span>
                            <span class="sm:hidden">Guardar</span>
                        </button>
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
                            Historial de Asistencias
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                @if($asistenciasHistorial->count() === 0)
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay registros de asistencia</h3>
                        <p class="text-gray-500 mb-4">Comienza registrando la primera asistencia</p>
                        <button @click="currentView = 'registro'" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-user-check mr-2"></i>Registrar Primera Asistencia
                        </button>
                    </div>
                @else
                    <!-- Filtros -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                    x-model="filtroCategoriaHistorial">
                                <option value="">Todas</option>
                                @foreach($categorias as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                    x-model="filtroEstadoHistorial">
                                <option value="">Todos</option>
                                <option value="presente">Presente</option>
                                <option value="ausente">Ausente</option>
                                <option value="tarde">Tarde</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                            <input type="date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                x-model="filtroDesdeHistorial">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                            <input type="date" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                x-model="filtroHastaHistorial">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Jugador</label>
                            <input type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                                x-model="filtroJugadorHistorial" 
                                placeholder="Nombre...">
                        </div>
                    </div>

                    <!-- Botón para limpiar filtros -->
                    <div class="flex justify-end mb-4">
                        <button type="button" 
                                @click="limpiarFiltrosHistorial()" 
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-eraser mr-2"></i> Limpiar Filtros
                        </button>
                    </div>

                    <!-- Tabla de historial -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jugador</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($asistenciasHistorial as $a)
                                <tr class="hover:bg-gray-50 transition-colors" 
                                    x-show="mostrarFilaHistorial('{{ $a['categoria'] ?? '' }}', '{{ $a['estado'] ?? '' }}', '{{ $a['fecha'] }}', '{{ $a['jugador_nombre'] ?? '' }}')"
                                    data-categoria="{{ $a['categoria'] ?? '' }}" 
                                    data-estado="{{ $a['estado'] ?? '' }}"
                                    data-fecha="{{ $a['fecha'] }}"
                                    data-jugador="{{ $a['jugador_nombre'] ?? '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($a['fecha'])->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $a['jugador_nombre'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $categorias[$a['categoria']] ?? ucfirst($a['categoria']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php $estado = strtolower(trim($a['estado'] ?? '')); @endphp
                                        @if($estado === 'presente')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>Presente
                                            </span>
                                        @elseif($estado === 'ausente')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>Ausente
                                            </span>
                                        @elseif($estado === 'tarde')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Tarde
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                N/A
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $a['observaciones'] ?? 'Sin observaciones' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Resumen -->
                    <div class="mt-4 text-sm text-gray-600">
                        Mostrando <span class="font-semibold text-gray-900" x-text="contadorHistorial"></span> de {{ $asistenciasHistorial->count() }} registros
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.text-xxs {
    font-size: 0.65rem;
    line-height: 1rem;
}

@media (min-width: 640px) {
    .text-xxs {
        font-size: 0.75rem;
    }
}

/* Estilos para los estados activos */
.estado-label.active.presente {
    background-color: #10B981 !important;
    color: white !important;
}

.estado-label.active.tarde {
    background-color: #F59E0B !important;
    color: white !important;
}

.estado-label.active.ausente {
    background-color: #EF4444 !important;
    color: white !important;
}
</style>
@endpush

@push('scripts')
<script>
function asistenciasManager() {
    return {
        currentView: 'main',
        
        // Filtros para registro
        filtroCategoriaRegistro: '',
        filtroJugadorRegistro: '',
        
        // Filtros para historial
        filtroCategoriaHistorial: '',
        filtroEstadoHistorial: '',
        filtroDesdeHistorial: '',
        filtroHastaHistorial: '',
        filtroJugadorHistorial: '',
        contadorHistorial: {{ $asistenciasHistorial->count() }},
        
        init() {
            // Inicializar contador de historial
            this.actualizarContadorHistorial();
            
            // Observar cambios en los filtros de historial
            this.$watch('filtroCategoriaHistorial', () => this.filtrarHistorial());
            this.$watch('filtroEstadoHistorial', () => this.filtrarHistorial());
            this.$watch('filtroDesdeHistorial', () => this.filtrarHistorial());
            this.$watch('filtroHastaHistorial', () => this.filtrarHistorial());
            this.$watch('filtroJugadorHistorial', () => this.filtrarHistorial());
        },
        
        // Función para mostrar/ocultar jugadores en registro
        mostrarJugador(categoria, nombreJugador) {
            const pasaCategoria = !this.filtroCategoriaRegistro || categoria === this.filtroCategoriaRegistro;
            const pasaJugador = !this.filtroJugadorRegistro || 
                               nombreJugador.toLowerCase().includes(this.filtroJugadorRegistro.toLowerCase());
            
            return pasaCategoria && pasaJugador;
        },
        
        // Función para seleccionar estado de asistencia
        seleccionarEstado(event, estado) {
            const label = event.target;
            const container = label.closest('.flex.bg-gray-100');
            
            // Remover clases activas de todos los labels del mismo grupo
            container.querySelectorAll('.estado-label').forEach(lbl => {
                lbl.classList.remove('active', 'presente', 'tarde', 'ausente');
            });
            
            // Agregar clase activa al label clickeado
            label.classList.add('active', estado);
            
            // Marcar el radio button correspondiente
            const radioId = label.getAttribute('for');
            const radio = document.getElementById(radioId);
            if (radio) {
                radio.checked = true;
            }
        },
        
        // Función para filtrar historial
        filtrarHistorial() {
            let contador = 0;
            const filas = document.querySelectorAll('tr[data-categoria]');
            
            filas.forEach(fila => {
                if (this.mostrarFilaHistorial(
                    fila.dataset.categoria,
                    fila.dataset.estado,
                    fila.dataset.fecha,
                    fila.dataset.jugador
                )) {
                    fila.style.display = '';
                    contador++;
                } else {
                    fila.style.display = 'none';
                }
            });
            
            this.contadorHistorial = contador;
        },
        
        // Función para determinar si mostrar fila en historial
        mostrarFilaHistorial(categoria, estado, fecha, jugador) {
            const pasaCategoria = !this.filtroCategoriaHistorial || categoria === this.filtroCategoriaHistorial;
            const pasaEstado = !this.filtroEstadoHistorial || estado === this.filtroEstadoHistorial;
            const pasaJugador = !this.filtroJugadorHistorial || 
                               jugador.toLowerCase().includes(this.filtroJugadorHistorial.toLowerCase());
            
            let pasaFecha = true;
            if (this.filtroDesdeHistorial && fecha < this.filtroDesdeHistorial) pasaFecha = false;
            if (this.filtroHastaHistorial && fecha > this.filtroHastaHistorial) pasaFecha = false;
            
            return pasaCategoria && pasaEstado && pasaFecha && pasaJugador;
        },
        
        // Función para limpiar filtros de historial
        limpiarFiltrosHistorial() {
            this.filtroCategoriaHistorial = '';
            this.filtroEstadoHistorial = '';
            this.filtroDesdeHistorial = '';
            this.filtroHastaHistorial = '';
            this.filtroJugadorHistorial = '';
            this.filtrarHistorial();
        },
        
        // Actualizar contador de historial
        actualizarContadorHistorial() {
            this.contadorHistorial = document.querySelectorAll('tr[data-categoria]:not([style*="display: none"])').length;
        }
    }
}

// Inicializar estados visuales al cargar
document.addEventListener('DOMContentLoaded', function() {
    // Activar el estado inicial (presente) visualmente
    document.querySelectorAll('.estado-radio:checked').forEach(radio => {
        const label = document.querySelector(`label[for="${radio.id}"]`);
        if (label) {
            label.classList.add('active', radio.value);
        }
    });
});
</script>
@endpush