<!-- Anuncios del Coach - Estilo TailPanel -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
            <i class="fas fa-bullhorn text-blue-600 mr-2 sm:mr-3"></i>
            Gestión de Anuncios
        </h1>
        <div class="flex items-center space-x-3">
            @php
                $totalAnuncios = isset($anuncios) ? $anuncios->count() : 0;
                $anunciosVigentes = isset($anuncios) ? $anuncios->filter(function($a) {
                    return $a->activo && (!$a->vigente_hasta || $a->vigente_hasta >= now()->toDateString());
                })->count() : 0;
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-check-circle mr-1"></i>
                {{ $anunciosVigentes }} vigentes
            </span>
        </div>
    </div>


    <!-- MENSAJES DE ÉXITO/ERROR -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative flex items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif


    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative flex items-center" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif


    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-bullhorn text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Anuncios</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAnuncios }}</p>
                    <p class="text-xs text-gray-500">Publicados</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Vigentes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $anunciosVigentes }}</p>
                    <p class="text-xs text-gray-500">Activos</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Importantes</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($anuncios) ? $anuncios->whereIn('prioridad', ['importante', 'urgente'])->count() : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Prioritarios</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Alcance</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ isset($anuncios) ? $anuncios->where('audiencia', 'todos')->count() : 0 }}
                    </p>
                    <p class="text-xs text-gray-500">Para todos</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Formulario para crear anuncio -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-plus-circle text-green-600 mr-2"></i>
                Crear Nuevo Anuncio
            </h3>
        </div>
        <div class="p-6">
            <form id="formCrearAnuncio" action="{{ route('anuncios.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Primera fila: Título y Prioridad -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Título del Anuncio</label>
                        <input type="text" name="titulo" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Ej. Cambio de horario de entrenamiento" 
                               required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioridad</label>
                        <select name="prioridad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="normal">Normal</option>
                            <option value="importante">Importante</option>
                            <option value="urgente">Urgente</option>
                        </select>
                    </div>
                </div>


                <!-- Segunda fila: Categoría, Audiencia y Vigencia -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoría Destino</label>
                        <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las categorías</option>
                            <option value="sub8">Sub-8</option>
                            <option value="sub12">Sub-12</option>
                            <option value="sub14">Sub-14</option>
                            <option value="sub16">Sub-16</option>
                            <option value="avanzado">Avanzado</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Audiencia</label>
                        <select name="audiencia" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="todos">Todos los jugadores</option>
                            <option value="categoria">Solo categoría seleccionada</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vigente hasta (opcional)</label>
                        <input type="date" name="vigente_hasta" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               min="{{ date('Y-m-d') }}">
                    </div>
                </div>


                <!-- Mensaje -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mensaje del Anuncio</label>
                    <textarea name="mensaje" rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                              placeholder="Escribe el contenido del anuncio aquí..." 
                              required></textarea>
                </div>


                <!-- Enlace opcional -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Enlace adicional (opcional)</label>
                    <input type="url" name="enlace" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="https://ejemplo.com">
                    <p class="text-xs text-gray-500 mt-1">Puedes agregar un enlace para más información</p>
                </div>


                <!-- Botones -->
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="document.getElementById('formCrearAnuncio').reset()" 
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Limpiar
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Publicar Anuncio
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Lista de anuncios publicados -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 sm:p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list text-purple-600 mr-2"></i>
                    Anuncios Publicados
                </h3>
                <div class="flex flex-wrap gap-2">
                    <select id="filtroCategoria" class="px-3 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="filtrarAnuncios()">
                        <option value="">Todas las categorías</option>
                        <option value="sub8">Sub-8</option>
                        <option value="sub12">Sub-12</option>
                        <option value="sub14">Sub-14</option>
                        <option value="sub16">Sub-16</option>
                        <option value="avanzado">Avanzado</option>
                    </select>
                    <select id="filtroEstado" class="px-3 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="filtrarAnuncios()">
                        <option value="">Todos los estados</option>
                        <option value="vigente">Vigentes</option>
                        <option value="vencido">Vencidos</option>
                        <option value="inactivo">Inactivos</option>
                    </select>
                    <button type="button" onclick="limpiarFiltros()" 
                            class="px-3 py-1 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-redo mr-1"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
        <div class="divide-y divide-gray-200" id="listaAnuncios">
            @php $anuncios = ($anuncios ?? collect()); @endphp
            @if($anuncios->count() === 0)
                <div class="p-12 text-center">
                    <i class="fas fa-bullhorn text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay anuncios publicados</h3>
                    <p class="text-gray-500">Crea tu primer anuncio usando el formulario de arriba.</p>
                </div>
            @else
                @foreach($anuncios as $anuncio)
                    @php 
                        $categoria = strtolower($anuncio->categoria ?? '');
                        // Determinar el estado
                        if (!$anuncio->activo) {
                            $estado = 'inactivo';
                        } elseif ($anuncio->vigente_hasta && $anuncio->vigente_hasta < now()->toDateString()) {
                            $estado = 'vencido';
                        } else {
                            $estado = 'vigente';
                        }
                    @endphp
                    <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors anuncio-item" 
                        data-categoria="{{ $categoria }}" 
                        data-estado="{{ $estado }}">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                            <!-- Icono según prioridad -->
                            <div class="flex-shrink-0">
                                @if(($anuncio->prioridad ?? 'normal') === 'urgente')
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                                    </div>
                                @elseif(($anuncio->prioridad ?? 'normal') === 'importante')
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-exclamation-circle text-orange-600"></i>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-info-circle text-blue-600"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Contenido del anuncio -->
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <h4 class="text-base sm:text-lg font-medium text-gray-900">{{ $anuncio->titulo }}</h4>
                                            @if($categoria)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ strtoupper($categoria) }}
                                                </span>
                                            @endif
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($estado === 'vigente')
                                                    bg-green-100 text-green-800
                                                @elseif($estado === 'vencido')
                                                    bg-gray-100 text-gray-800
                                                @else
                                                    bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($estado) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 mb-3">{{ $anuncio->mensaje }}</p>
                                        <div class="flex flex-wrap items-center gap-3 text-xs sm:text-sm text-gray-500">
                                            <span><i class="fas fa-calendar mr-1"></i>{{ optional($anuncio->created_at)->format('d/m/Y H:i') ?? 'N/A' }}</span>
                                            @if($anuncio->vigente_hasta ?? null)
                                                <span><i class="fas fa-clock mr-1"></i>Vigente hasta {{ \Carbon\Carbon::parse($anuncio->vigente_hasta)->format('d/m/Y') }}</span>
                                            @endif
                                            <span><i class="fas fa-users mr-1"></i>{{ ucfirst($anuncio->audiencia ?? 'todos') }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Acciones -->
                                    <div class="sm:ml-4 flex flex-wrap items-center gap-2">
                                        @if($anuncio->enlace ?? null)
                                            <a href="{{ $anuncio->enlace }}" target="_blank" 
                                                class="inline-flex items-center px-2 py-1 text-xs border border-blue-300 rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                                                    <i class="fas fa-external-link-alt mr-1"></i>
                                                    <span class="hidden sm:inline">Ver enlace</span>
                                                    <span class="sm:hidden">Enlace</span>
                                                </a>
                                        @endif
                                        
                                        <!-- Toggle activo/inactivo -->
                                        <form method="POST" action="{{ route('anuncios.toggle', $anuncio->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                class="inline-flex items-center px-2 py-1 text-xs border border-gray-300 rounded-md {{ $anuncio->activo ? 'text-green-700 bg-green-50 hover:bg-green-100' : 'text-gray-700 bg-white hover:bg-gray-50' }} transition-colors"
                                                title="{{ $anuncio->activo ? 'Desactivar' : 'Activar' }}">
                                                    <i class="fas fa-toggle-{{ $anuncio->activo ? 'on' : 'off' }} mr-1"></i>
                                                    <span class="hidden sm:inline">{{ $anuncio->activo ? 'Activo' : 'Inactivo' }}</span>
                                                </button>
                                            </form>
                                        
                                        <!-- Editar -->
                                        <button 
                                            class="inline-flex items-center px-2 py-1 text-xs border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors btn-editar"
                                            data-id="{{ $anuncio->id }}"
                                            data-titulo="{{ $anuncio->titulo }}"
                                            data-mensaje="{{ $anuncio->mensaje }}"
                                            data-categoria="{{ $anuncio->categoria ?? '' }}"
                                            data-audiencia="{{ $anuncio->audiencia ?? 'todos' }}"
                                            data-enlace="{{ $anuncio->enlace ?? '' }}"
                                            data-vigente-hasta="{{ $anuncio->vigente_hasta ? \Carbon\Carbon::parse($anuncio->vigente_hasta)->format('Y-m-d') : '' }}"
                                            data-prioridad="{{ $anuncio->prioridad ?? 'normal' }}">
                                            <i class="fas fa-edit mr-1"></i>
                                            Editar
                                        </button>
                                        
                                        <!-- Eliminar -->
                                        <form method="POST" action="{{ route('anuncios.destroy', $anuncio->id) }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este anuncio? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="inline-flex items-center px-2 py-1 text-xs border border-red-300 rounded-md text-red-700 bg-red-50 hover:bg-red-100 transition-colors">

                                                <!-- Ícono siempre visible -->
                                                <i class="fas fa-trash mr-1"></i>

                                                <!-- El texto solo en pantallas sm+ -->
                                                <span class="hidden sm:inline">Eliminar</span>
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>


<!-- Modal de Edición -->
<div id="modalEditarAnuncio" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-3xl" style="max-height: 90vh;">
            <!-- Encabezado del modal -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-edit text-blue-600 mr-2"></i>
                    Editar Anuncio
                </h3>
                <button onclick="cerrarModalEditar()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Formulario de edición (con scroll) -->
            <form id="formEditarAnuncio" method="POST" action="" class="flex flex-col" style="max-height: calc(90vh - 140px);">
                @csrf
                @method('PUT')
                
                <div class="overflow-y-auto px-6 py-4">
                    <div class="space-y-4">
                        <!-- Primera fila: Título y Prioridad -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Título del Anuncio</label>
                                <input type="text" id="edit_titulo" name="titulo" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Prioridad</label>
                                <select id="edit_prioridad" name="prioridad" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="normal">Normal</option>
                                    <option value="importante">Importante</option>
                                    <option value="urgente">Urgente</option>
                                </select>
                            </div>
                        </div>

                        <!-- Segunda fila: Categoría, Audiencia y Vigencia -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Categoría Destino</label>
                                <select id="edit_categoria" name="categoria" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Todas las categorías</option>
                                    <option value="sub8">Sub-8</option>
                                    <option value="sub12">Sub-12</option>
                                    <option value="sub14">Sub-14</option>
                                    <option value="sub16">Sub-16</option>
                                    <option value="avanzado">Avanzado</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Audiencia</label>
                                <select id="edit_audiencia" name="audiencia" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="todos">Todos los jugadores</option>
                                    <option value="categoria">Solo categoría seleccionada</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Vigente hasta</label>
                                <input type="date" id="edit_vigente_hasta" name="vigente_hasta" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- Mensaje -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Mensaje del Anuncio</label>
                            <textarea id="edit_mensaje" name="mensaje" rows="3" 
                                      class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" 
                                      required></textarea>
                        </div>

                        <!-- Enlace opcional -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Enlace adicional (opcional)</label>
                            <input type="url" id="edit_enlace" name="enlace" 
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="https://ejemplo.com">
                        </div>
                    </div>
                </div>

                <!-- Botones (fijos) -->
                <div class="flex justify-center gap-6 px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <button type="button" onclick="cerrarModalEditar()" 
                            class="px-6 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-white transition-colors">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </button>
                    <button type="submit" 
                            class="px-8 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
// Función para filtrar anuncios
function filtrarAnuncios() {
    const cat = (document.getElementById('filtroCategoria')?.value || '').toLowerCase();
    const est = (document.getElementById('filtroEstado')?.value || '').toLowerCase();
    
    document.querySelectorAll('.anuncio-item').forEach(item => {
        const itemCat = item.dataset.categoria || '';
        const itemEst = item.dataset.estado || '';
        const okCat = !cat || itemCat === cat;
        const okEst = !est || itemEst === est;
        item.style.display = okCat && okEst ? '' : 'none';
    });
}

// Función para limpiar filtros
function limpiarFiltros() {
    document.getElementById('filtroCategoria').value = '';
    document.getElementById('filtroEstado').value = '';
    filtrarAnuncios();
}

// Event listener para botones de editar
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-editar')) {
        const btn = e.target.closest('.btn-editar');
        const id = btn.dataset.id;
        
        const datos = {
            titulo: btn.getAttribute('data-titulo') || '',
            mensaje: btn.getAttribute('data-mensaje') || '',
            categoria: btn.getAttribute('data-categoria') || '',
            audiencia: btn.getAttribute('data-audiencia') || 'todos',
            enlace: btn.getAttribute('data-enlace') || '',
            vigente_hasta: btn.getAttribute('data-vigente-hasta') || '',
            prioridad: btn.getAttribute('data-prioridad') || 'normal'
        };
        
        console.log('Datos cargados:', datos);
        console.log('Vigente hasta específico:', datos.vigente_hasta);
        
        abrirModalEditar(id, datos);
    }
});

// Función para abrir modal de edición
function abrirModalEditar(id, datos) {
    // Establecer la acción del formulario
    document.getElementById('formEditarAnuncio').action = `/coach/anuncios/${id}`;
    
    // DEBUG: Verificar qué se está recibiendo
    console.log('ID del anuncio:', id);
    console.log('Fecha vigente_hasta recibida:', datos.vigente_hasta);
    console.log('Tipo de dato:', typeof datos.vigente_hasta);
    
    // Llenar los campos con los datos
    document.getElementById('edit_titulo').value = datos.titulo || '';
    document.getElementById('edit_mensaje').value = datos.mensaje || '';
    document.getElementById('edit_categoria').value = datos.categoria || '';
    document.getElementById('edit_audiencia').value = datos.audiencia || 'todos';
    document.getElementById('edit_enlace').value = datos.enlace || '';
    
    // Asignar y verificar el campo de fecha
    const campoFecha = document.getElementById('edit_vigente_hasta');
    campoFecha.value = datos.vigente_hasta || '';
    console.log('Valor asignado al input:', campoFecha.value);
    
    document.getElementById('edit_prioridad').value = datos.prioridad || 'normal';
    
    // Mostrar el modal
    document.getElementById('modalEditarAnuncio').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}


// Función para cerrar modal de edición
function cerrarModalEditar() {
    document.getElementById('modalEditarAnuncio').classList.add('hidden');
    document.getElementById('formEditarAnuncio').reset();
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalEditarAnuncio')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalEditar();
    }
});

// Cerrar modal con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('modalEditarAnuncio').classList.contains('hidden')) {
        cerrarModalEditar();
    }
});
</script>
@endpush
