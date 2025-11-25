<!-- Anuncios del Jugador -->
<div class="space-y-6" x-data="{ 
    filtroTipo: '', 
    filtroCategoria: '' 
}">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-bullhorn text-orange-600 mr-3"></i>
            Anuncios y Avisos
        </h1>
        <div class="flex items-center space-x-3">
            @php
                $anunciosActivos = isset($anuncios) ? $anuncios->filter(function($a) {
                    return $a->activo && (!$a->vigente_hasta || $a->vigente_hasta >= now()->toDateString());
                })->count() : 0;
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-bell mr-1"></i>
                {{ $anunciosActivos }} activos
            </span>
        </div>
    </div>

    <!-- Filtros de anuncios -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Prioridad:</label>
                <select x-model="filtroTipo" @change="filtrarAnuncios()" 
                        class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">Todas las prioridades</option>
                    <option value="urgente">Urgentes</option>
                    <option value="importante">Importantes</option>
                    <option value="normal">Normales</option>
                </select>
            </div>
            <button @click="filtroTipo = ''; filtroCategoria = ''; $nextTick(() => filtrarAnuncios())" 
                    class="text-sm px-3 py-1 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-redo mr-1"></i>Limpiar filtros
            </button>
        </div>
    </div>

    <!-- Lista de todos los anuncios -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-list text-blue-600 mr-2"></i>
                Todos los Anuncios ({{ isset($anuncios) ? $anuncios->count() : 0 }})
            </h3>
        </div>
        <div class="divide-y divide-gray-200" id="listaAnunciosPlayer">
            @if(isset($anuncios) && $anuncios->count() > 0)
                @foreach($anuncios->sortByDesc('created_at') as $anuncio)
                    @php
                        $esVigente = !$anuncio->vigente_hasta || $anuncio->vigente_hasta >= now()->toDateString();
                        $prioridadClase = match($anuncio->prioridad ?? 'normal') {
                            'urgente' => 'border-l-4 border-red-500',
                            'importante' => 'border-l-4 border-orange-500',
                            default => 'border-l-4 border-blue-500'
                        };
                    @endphp
                    <div class="p-4 sm:p-6 hover:bg-gray-50 transition-colors anuncio-item {{ $prioridadClase }}" 
                        data-prioridad="{{ $anuncio->prioridad ?? 'normal' }}"
                        data-categoria="{{ strtolower($anuncio->categoria ?? '') }}">
                        <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-4">
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
                            <div class="flex-1 w-full">
                                <div class="flex flex-col sm:flex-row items-start justify-between space-y-3 sm:space-y-0">
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <h4 class="text-base sm:text-lg font-medium text-gray-900">{{ $anuncio->titulo }}</h4>
                                            
                                            <!-- Badge de prioridad -->
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if(($anuncio->prioridad ?? 'normal') === 'urgente')
                                                    bg-red-100 text-red-800
                                                @elseif(($anuncio->prioridad ?? 'normal') === 'importante')
                                                    bg-orange-100 text-orange-800
                                                @else
                                                    bg-blue-100 text-blue-800
                                                @endif">
                                                {{ ucfirst($anuncio->prioridad ?? 'normal') }}
                                            </span>
                                            
                                            <!-- Badge de categoría -->
                                            @if($anuncio->categoria)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ strtoupper($anuncio->categoria) }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-sm sm:text-base text-gray-700 mb-3">{{ $anuncio->mensaje }}</p>
                                        
                                        <div class="flex flex-col sm:flex-row sm:items-center flex-wrap gap-2 sm:gap-4 text-xs sm:text-sm text-gray-500">
                                            <span><i class="fas fa-calendar mr-1"></i>{{ $anuncio->created_at->format('d/m/Y H:i') }}</span>
                                            <span><i class="fas fa-user mr-1"></i>{{ optional($anuncio->coach)->name ?? 'Administración' }}</span>
                                            @if($anuncio->vigente_hasta)
                                                <span><i class="fas fa-clock mr-1"></i>Vigente hasta {{ \Carbon\Carbon::parse($anuncio->vigente_hasta)->format('d/m/Y') }}</span>
                                            @endif
                                            @if($anuncio->audiencia)
                                                <span><i class="fas fa-users mr-1"></i>{{ ucfirst($anuncio->audiencia) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Acciones y estado -->
                                    <div class="sm:ml-4 flex flex-row sm:flex-col items-start sm:items-end gap-2 sm:space-y-2">
                                        @if($anuncio->enlace)
                                            <a href="{{ $anuncio->enlace }}" target="_blank" 
                                               class="inline-flex items-center px-3 py-1 border border-blue-300 rounded-md text-sm text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                                                <i class="fas fa-external-link-alt mr-1"></i>
                                                Ver más
                                            </a>
                                        @endif
                                        
                                        <!-- Estado de vigencia -->
                                        @if(!$anuncio->activo)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-ban mr-1"></i>Inactivo
                                            </span>
                                        @elseif($anuncio->vigente_hasta)
                                            @if($esVigente)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Vigente
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-times-circle mr-1"></i>Expirado
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-infinity mr-1"></i>Permanente
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-bullhorn text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay anuncios disponibles</h3>
                    <p class="text-gray-500">Los anuncios de tu entrenador y la academia aparecerán aquí.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Función para filtrar anuncios del jugador
function filtrarAnuncios() {
    const prioridad = document.querySelector('[x-model="filtroTipo"]')?.value || '';
    const categoria = document.querySelector('[x-model="filtroCategoria"]')?.value || '';
    
    document.querySelectorAll('#listaAnunciosPlayer .anuncio-item').forEach(item => {
        const itemPrioridad = item.dataset.prioridad || '';
        const itemCategoria = item.dataset.categoria || '';
        
        const matchPrioridad = !prioridad || itemPrioridad === prioridad;
        const matchCategoria = !categoria || itemCategoria === categoria.toLowerCase();
        
        item.style.display = matchPrioridad && matchCategoria ? '' : 'none';
    });
}
</script>
@endpush
