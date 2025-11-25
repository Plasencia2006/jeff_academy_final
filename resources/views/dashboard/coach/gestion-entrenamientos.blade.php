@php
    $categorias = [
        'sub8' => 'Sub-8',
        'sub12' => 'Sub-12',
        'sub14' => 'Sub-14',
        'sub16' => 'Sub-16',
        'avanzado' => 'Avanzado'
    ];

    $tipos = [
        'tecnica' => 'Técnica',
        'tactica' => 'Táctica',
        'fisico' => 'Físico',
        'partido' => 'Partido Práctica'
    ];

    $ubicaciones = [
        'principal' => 'Cancha Principal',
        'auxiliar' => 'Cancha Auxiliar',
        'gimnasio' => 'Gimnasio'
    ];
@endphp

<!-- Gestión de Entrenamientos-->
<div class="space-y-6" x-data="{ 
        filtroCategoria: '', 
        filtroFechaDesde: '', 
        filtroFechaHasta: '',
        showEditModal: false,
        editingTraining: {
            id: null,
            categoria: '',
            tipo: '',
            fecha: '',
            hora_inicio: '',
            hora_fin: '',
            ubicacion: '',
            objetivos: ''
        },
        
        filtrarEntrenamientos() {
            const items = document.querySelectorAll('.entrenamiento-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const itemCategoria = item.dataset.categoria || '';
                const itemFecha = item.dataset.fecha || '';
                
                const matchCategoria = !this.filtroCategoria || itemCategoria === this.filtroCategoria.toLowerCase();
                const matchFechaDesde = !this.filtroFechaDesde || itemFecha >= this.filtroFechaDesde;
                const matchFechaHasta = !this.filtroFechaHasta || itemFecha <= this.filtroFechaHasta;
                
                if (matchCategoria && matchFechaDesde && matchFechaHasta) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            const mensaje = document.getElementById('mensajeSinCoincidencias');
            if (mensaje) {
                mensaje.classList.toggle('hidden', visibleCount > 0 || items.length === 0);
            }
        },

        limpiarFiltros() {
            this.filtroCategoria = '';
            this.filtroFechaDesde = '';
            this.filtroFechaHasta = '';
            this.filtrarEntrenamientos();
        }

    }" 
    x-init="$watch('filtroCategoria', () => filtrarEntrenamientos()); 
        $watch('filtroFechaDesde', () => filtrarEntrenamientos()); 
        $watch('filtroFechaHasta', () => filtrarEntrenamientos())">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <i class="fas fa-edit text-blue-600 mr-2 sm:mr-3"></i>
                Gestión de Entrenamientos
            </h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Administra y modifica tus entrenamientos programados</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'horarios' }))"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm sm:text-base">
                <i class="fas fa-calendar-plus mr-2"></i>
                <span class="hidden sm:inline">Programar Entrenamiento</span>
                <span class="sm:hidden">Programar</span>
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-filter text-blue-600 mr-2"></i>
                    Filtros
                </h3>
                <button @click="limpiarFiltros()" 
                        class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors text-sm">
                    <i class="fas fa-redo mr-2"></i>
                    Limpiar Filtros
                </button>
            </div>
        </div>
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select x-model="filtroCategoria"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                    <input type="date" 
                        x-model="filtroFechaDesde"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                    <input type="date" 
                        x-model="filtroFechaHasta"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>
    </div>


    <!-- Lista de entrenamientos -->
    @if(($entrenamientos ?? collect())->count() === 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-12 text-center">
                <i class="fas fa-calendar-times text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes entrenamientos programados</h3>
                <p class="text-gray-500 mb-6">Comienza programando tu primer entrenamiento para gestionar tu equipo.</p>
                <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'horarios' }))"
                        class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Programar Primer Entrenamiento
                </button>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-4 sm:p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-list text-green-600 mr-2"></i>
                        <span class="truncate">Entrenamientos Programados</span>
                    </h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-green-100 text-green-800 shrink-0">
                        <i class="fas fa-calendar-check mr-1"></i>
                        <span class="whitespace-nowrap">{{ ($entrenamientos ?? collect())->count() }} entrenamientos</span>
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div id="listaEntrenamientos" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($entrenamientos as $e)
                        @php
                            $fechaEntrenamiento = \Carbon\Carbon::parse($e->fecha);
                            $horaFin = \Carbon\Carbon::parse($e->hora)->addMinutes($e->duracion ?? 90)->format('H:i');
                        @endphp
                        <div class="entrenamiento-item bg-gray-100 rounded-xl p-6 shadow-md border border-gray-200 hover:bg-gray-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                             data-categoria="{{ strtolower($e->categoria) }}"
                             data-fecha="{{ $e->fecha }}">
                            
                            <!-- Header del entrenamiento -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($e->categoria === 'sub8') bg-blue-100 text-blue-800
                                        @elseif($e->categoria === 'sub12') bg-green-100 text-green-800
                                        @elseif($e->categoria === 'sub14') bg-yellow-100 text-yellow-800
                                        @elseif($e->categoria === 'sub16') bg-purple-100 text-purple-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($e->categoria) }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $tipos[$e->tipo] ?? ucfirst($e->tipo ?? 'Entrenamiento') }}
                                    </span>
                                </div>
                                @if($fechaEntrenamiento->isToday())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-clock mr-1"></i>Hoy
                                    </span>
                                @elseif($fechaEntrenamiento->isPast())
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <i class="fas fa-check mr-1"></i>Realizado
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Información principal -->
                            <div class="space-y-3 mb-4">
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-calendar-alt w-5 text-blue-600 mr-3"></i>
                                    <span class="font-medium">{{ $fechaEntrenamiento->format('d/m/Y') }}</span>
                                    <span class="text-gray-500 ml-2 text-sm">({{ ucfirst($fechaEntrenamiento->locale('es')->isoFormat('dddd')) }})</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-clock w-5 text-green-600 mr-3"></i>
                                    <span>{{ $e->hora }} - {{ $horaFin }}</span>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-map-marker-alt w-5 text-red-600 mr-3"></i>
                                    <span>{{ $ubicaciones[$e->ubicacion] ?? ucfirst($e->ubicacion ?? 'Cancha Principal') }}</span>
                                </div>
                                @if($e->objetivos)
                                    <div class="flex items-start text-gray-700">
                                        <i class="fas fa-bullseye w-5 text-purple-600 mr-3 mt-0.5"></i>
                                        <span class="text-sm">{{ Str::limit($e->objetivos, 80) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Acciones -->
                            <div class="flex gap-2 pt-4 border-t border-gray-200">
                                <button type="button" 
                                        @click="editingTraining = {
                                            id: {{ $e->id }},
                                            categoria: '{{ $e->categoria }}',
                                            tipo: '{{ $e->tipo ?? 'tecnica' }}',
                                            fecha: '{{ \Carbon\Carbon::parse($e->fecha)->format('Y-m-d') }}',
                                            hora_inicio: '{{ substr($e->hora, 0, 5) }}',
                                            hora_fin: '{{ \Carbon\Carbon::parse($e->hora)->addMinutes($e->duracion ?? 90)->format('H:i') }}',
                                            ubicacion: '{{ $e->ubicacion ?? 'principal' }}',
                                            objetivos: {{ json_encode($e->objetivos ?? '') }}
                                        }; showEditModal = true"
                                        class="flex-1 inline-flex items-center justify-center px-3 py-2 border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-50 transition-colors text-sm">
                                    <i class="fas fa-edit mr-2"></i>
                                    Editar
                                </button>

                                <form action="{{ route('coach.horarios.destroy', $e->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('¿Estás seguro de eliminar este entrenamiento?');"
                                    class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-3 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition-colors text-sm">
                                        <i class="fas fa-trash-alt mr-2"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
                
                <!-- Mensaje sin coincidencias -->
                <div id="mensajeSinCoincidencias" class="text-center py-8 hidden">
                    <i class="fas fa-info-circle text-gray-400 text-3xl mb-3"></i>
                    <p class="text-gray-500">No hay entrenamientos que coincidan con los filtros aplicados.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Edición -->
    <div x-show="showEditModal" 
        x-cloak
        class="fixed inset-0 z-50"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
        style="overflow: hidden;">
        
        <!-- Overlay de fondo -->
        <div x-show="showEditModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            @click="showEditModal = false">
        </div>

        <!-- Contenedor del modal con scroll -->
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                
                <!-- Contenido del modal -->
                <div x-show="showEditModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl"
                    style="max-height: calc(100vh - 2rem);">
                    
                    <form :action="`{{ url('/coach/horarios') }}/${editingTraining.id}`" 
                        method="POST" 
                        class="flex flex-col"
                        style="max-height: calc(100vh - 2rem);">
                        @csrf
                        @method('PUT')
                        
                        <!-- Encabezado del modal (FIJO) -->
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center" id="modal-title">
                                <i class="fas fa-edit text-blue-600 mr-2"></i>
                                Editar Entrenamiento
                            </h3>
                            <button type="button"
                                    @click="showEditModal = false" 
                                    class="text-gray-400 hover:text-gray-500 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <!-- Contenido con scroll -->
                        <div class="overflow-y-auto flex-1 px-6 py-6">
                            <div class="space-y-6">
                                <!-- Información básica -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                                        <select x-model="editingTraining.categoria" name="categoria" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Seleccione categoría...</option>
                                            @foreach($categorias as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Entrenamiento</label>
                                        <select x-model="editingTraining.tipo" name="tipo" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Seleccione tipo...</option>
                                            @foreach($tipos as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Fecha y horarios -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                                        <input type="date" 
                                            x-model="editingTraining.fecha" 
                                            name="fecha" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora Inicio</label>
                                        <input type="time" 
                                            x-model="editingTraining.hora_inicio" 
                                            name="hora_inicio" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Hora Fin</label>
                                        <input type="time" 
                                            x-model="editingTraining.hora_fin" 
                                            name="hora_fin" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <!-- Ubicación y entrenador -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                                        <select x-model="editingTraining.ubicacion" name="ubicacion" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Seleccione ubicación...</option>
                                            @foreach($ubicaciones as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Entrenador</label>
                                        <input type="text" value="{{ Auth::user()->name }}" readonly
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                                        <input type="hidden" name="entrenador_id" value="{{ Auth::id() }}">
                                    </div>
                                </div>

                                <!-- Objetivos -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Objetivos del Entrenamiento</label>
                                    <textarea x-model="editingTraining.objetivos" 
                                            name="objetivos" 
                                            rows="4"
                                            placeholder="Describa los objetivos y actividades planificadas..."
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción (FIJOS ABAJO) -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex-shrink-0">
                            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                <button type="button" 
                                        @click="showEditModal = false" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="fas fa-times mr-2"></i>Cancelar
                                </button>
                                <button type="submit" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
[x-cloak] {
    display: none !important;
}
</style>
