<!-- Gestión de Observaciones Técnicas - Estilo TailPanel -->
<div class="space-y-6" x-data="{ 
        currentView: 'main', 
        filtroCategoria: '', 
        filtroAspecto: '', 
        buscarJugador: '',
        
        filtrarObservaciones() {
            const items = document.querySelectorAll('.observacion-item');
            let visibleCount = 0;
            
            items.forEach(item => {
                const itemCategoria = item.dataset.categoria || '';
                const itemAspecto = item.dataset.aspecto || '';
                const itemJugador = item.dataset.jugador || '';
                
                const matchCategoria = !this.filtroCategoria || itemCategoria === this.filtroCategoria.toLowerCase();
                const matchAspecto = !this.filtroAspecto || itemAspecto === this.filtroAspecto.toLowerCase();
                const matchJugador = !this.buscarJugador || itemJugador.includes(this.buscarJugador.toLowerCase());
                
                if (matchCategoria && matchAspecto && matchJugador) {
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
        }
    }">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <i class="fas fa-clipboard-list text-blue-600 mr-2 sm:mr-3"></i>
                Observaciones Técnicas
            </h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Registra y consulta el seguimiento técnico de tus jugadores</p>
        </div>
        <div class="flex items-center flex-wrap gap-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <i class="fas fa-clipboard-check mr-1"></i>
                {{ $observaciones->count() }} observaciones
            </span>
            <button @click="currentView = 'crear'" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Nueva Observación
            </button>
        </div>
    </div>

    <!-- Vista Principal -->
    <div x-show="currentView === 'main'" class="space-y-6">
        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $observaciones->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-star text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Fortalezas</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $observaciones->where('aspecto', 'fortaleza')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">A Mejorar</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $observaciones->where('aspecto', 'mejora')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-calendar-week text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Esta Semana</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $observaciones->whereBetween('fecha', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                        <select x-model="filtroCategoria" @change="filtrarObservaciones()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Todas las categorías</option>
                            <option value="sub8">Sub-8</option>
                            <option value="sub12">Sub-12</option>
                            <option value="sub14">Sub-14</option>
                            <option value="sub16">Sub-16</option>
                            <option value="avanzado">Avanzado</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aspecto</label>
                        <select x-model="filtroAspecto" @change="filtrarObservaciones()"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Todos los aspectos</option>
                            <option value="fortaleza">Fortaleza</option>
                            <option value="mejora">A Mejorar</option>
                            <option value="general">General</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Jugador</label>
                        <input type="text" x-model="buscarJugador" @input="filtrarObservaciones()"
                                placeholder="Nombre del jugador..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de observaciones -->
        @if($observaciones->count() === 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-12 text-center">
                    <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay observaciones registradas</h3>
                    <p class="text-gray-500 mb-6">Comienza registrando la primera observación técnica de tus jugadores.</p>
                    <button @click="currentView = 'crear'" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Registrar Primera Observación
                    </button>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-list text-blue-600 mr-2"></i>
                        Historial de Observaciones
                    </h3>
                </div>
                <div class="p-6">
                    <div id="listaObservaciones" class="space-y-4">
                        @foreach($observaciones as $obs)
                            <div class="observacion-item border border-gray-200 rounded-lg p-3 sm:p-4 hover:bg-gray-50 transition-colors"
                                data-categoria="{{ strtolower($obs->inscripcion->categoria ?? '') }}"
                                data-aspecto="{{ strtolower($obs->aspecto) }}"
                                data-jugador="{{ strtolower($obs->inscripcion->jugador->name ?? '') }}">
                                
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 sm:space-x-3 mb-3">
                                            <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center
                                                @if($obs->aspecto === 'fortaleza') bg-blue-100 text-blue-600
                                                @elseif($obs->aspecto === 'mejora') bg-yellow-100 text-yellow-600
                                                @else bg-purple-100 text-purple-600 @endif">

                                                @if($obs->inscripcion->jugador->foto_url)
                                                    <img src="{{ $obs->inscripcion->jugador->foto_url }}" 
                                                        alt="Foto" 
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <i class="fas fa-user text-xl"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">{{ $obs->inscripcion->jugador->name ?? 'N/A' }}</h4>
                                                <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($obs->inscripcion->categoria ?? 'N/A') }}
                                                    </span>
                                                    <span>•</span>
                                                    <span>{{ \Carbon\Carbon::parse($obs->fecha)->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($obs->aspecto === 'fortaleza') bg-blue-100 text-blue-800
                                                @elseif($obs->aspecto === 'mejora') bg-yellow-100 text-yellow-800
                                                @else bg-purple-100 text-purple-800 @endif">
                                                <i class="fas @if($obs->aspecto === 'fortaleza') fa-star @elseif($obs->aspecto === 'mejora') fa-exclamation-triangle @else fa-info-circle @endif mr-1"></i>
                                                {{ ucfirst($obs->aspecto) }}
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <p class="text-sm text-gray-700"><span class="font-medium">Observación:</span> {{ $obs->detalle }}</p>
                                        </div>

                                        @if($obs->recomendaciones)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                                <p class="text-sm text-blue-900">
                                                    <i class="fas fa-lightbulb text-blue-600 mr-1"></i>
                                                    <span class="font-medium">Recomendaciones:</span> {{ $obs->recomendaciones }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4">
                                        <button onclick="eliminarObservacion({{ $obs->id }})" 
                                                class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="mensajeSinCoincidencias" class="text-center py-8 hidden">
                        <i class="fas fa-info-circle text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">No hay observaciones que coincidan con los filtros aplicados.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Vista de Crear -->
    <div x-show="currentView === 'crear'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="currentView = 'main'" class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-clipboard-check text-purple-600 mr-2"></i>
                            Registrar Observación Técnica
                        </h3>
                    </div>
                    <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
            
            <div class="p-6">
                <form action="{{ route('coach.observaciones.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jugador</label>
                            <select name="inscripcion_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Seleccione jugador...</option>
                                @foreach($inscripciones as $inscripcion)
                                    <option value="{{ $inscripcion->id }}">{{ $inscripcion->jugador->name }} - {{ ucfirst($inscripcion->categoria) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                            <input type="date" name="fecha" required value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aspecto Técnico</label>
                        <select name="aspecto" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Seleccione aspecto...</option>
                            <option value="fortaleza">Fortaleza</option>
                            <option value="mejora">A Mejorar</option>
                            <option value="general">General</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observación Técnica</label>
                        <textarea name="detalle" rows="4" required placeholder="Describe la observación técnica del jugador..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recomendaciones (opcional)</label>
                        <textarea name="recomendaciones" rows="3" placeholder="Recomendaciones para mejorar o mantener el rendimiento..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                    </div>
                    
                    <div class="flex justify-center gap-6 pt-6 border-t border-gray-200">
                        <button type="button" @click="currentView = 'main'" 
                                class="px-6 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                        <button type="submit" 
                                class="px-8 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Guardar Observación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function eliminarObservacion(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta observación?')) {
            // Crear formulario temporal para eliminar
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/coach/observaciones/${id}`;
            
            // Agregar token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Agregar método DELETE
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            // Agregar al body y enviar
            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>
</div>

<style>
[x-cloak] { display: none !important; }
</style>