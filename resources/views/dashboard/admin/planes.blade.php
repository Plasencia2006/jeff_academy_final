<!-- PLANES - Gestión de Planes -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-credit-card text-orange-600 mr-3"></i>
            Gestión de Planes
        </h1>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
        <!-- Total de Planes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100">
                    <i class="fas fa-credit-card text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $planes->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Planes Básicos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gray-100">
                    <i class="fas fa-star text-gray-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Básico</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $planes->where('tipo', 'basico')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Planes Premium -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-gem text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Premium</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $planes->where('tipo', 'premium')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Planes VIP -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-crown text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">VIP</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $planes->where('tipo', 'vip')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Planes Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Activos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $planes->where('estado', 'activo')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Planes Inactivos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Inactivos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $planes->where('estado', 'inactivo')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Registro de Planes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-orange-600 mr-2"></i>
            Crear Nuevo Plan
        </h3>

        <form id="formPlan" method="POST" action="{{ route('admin.planes.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nombrePlan" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Plan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="nombrePlan" 
                        name="nombre" 
                        placeholder="Ej: Plan Básico" 
                        required>
                </div>

                <div>
                    <label for="precioPlan" class="block text-sm font-medium text-gray-700 mb-2">
                        Precio (S/.) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                        step="0.01" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="precioPlan" 
                        name="precio" 
                        placeholder="0.00" 
                        required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="duracionPlan" class="block text-sm font-medium text-gray-700 mb-2">
                        Duración (meses) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="duracionPlan" 
                        name="duracion" 
                        placeholder="3" 
                        required>
                </div>

                <div>
                    <label for="tipoPlan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Plan <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="tipoPlan" 
                        name="tipo" 
                        required>
                        <option value="">Seleccionar tipo</option>
                        <option value="basico">Básico</option>
                        <option value="premium">Premium</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="disciplinasPlan" class="block text-sm font-medium text-gray-700 mb-2">
                        Disciplinas Incluidas
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="disciplinasPlan" 
                        name="disciplinas[]" 
                        multiple 
                        size="4">
                        @foreach($disciplinas as $disciplina)
                            <option value="{{ $disciplina->id }}">{{ $disciplina->nombre }}</option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Mantén presionado Ctrl para seleccionar múltiples disciplinas</p>
                </div>

                <div>
                    <label for="estadoPlan" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="estadoPlan" 
                        name="estado" 
                        required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="descripcionPlan" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción
                </label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                    id="descripcionPlan" 
                    name="descripcion" 
                    rows="3" 
                    placeholder="Descripción detallada del plan"></textarea>
            </div>

            <div class="mb-6">
                <label for="beneficiosPlan" class="block text-sm font-medium text-gray-700 mb-2">
                    Beneficios
                </label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                    id="beneficiosPlan" 
                    name="beneficios" 
                    rows="3" 
                    placeholder="Lista de beneficios separados por comas"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Crear Plan
                </button>
            </div>
        </form>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100" x-data="{
        filtroTipo: '',
        filtroEstado: '',
        filtrarPlanes() {
            const tipo = this.filtroTipo.toLowerCase();
            const estado = this.filtroEstado.toLowerCase();
            
            document.querySelectorAll('.plan-item').forEach(item => {
                const itemTipo = item.dataset.tipo?.toLowerCase() || '';
                const itemEstado = item.dataset.estado?.toLowerCase() || '';
                
                const matchTipo = !tipo || itemTipo === tipo;
                const matchEstado = !estado || itemEstado === estado;
                
                if (matchTipo && matchEstado) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        },
        limpiarFiltros() {
            this.filtroTipo = '';
            this.filtroEstado = '';
            this.filtrarPlanes();
        }
    }">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Plan</label>
                    <select x-model="filtroTipo" @change="filtrarPlanes()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Todos los tipos</option>
                        <option value="basico">Básico</option>
                        <option value="premium">Premium</option>
                        <option value="vip">VIP</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select x-model="filtroEstado" @change="filtrarPlanes()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button @click="limpiarFiltros()" type="button"
                            class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-redo mr-2"></i>
                        Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Planes -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-list text-orange-600 mr-2"></i>
            Planes Disponibles
        </h2>

        @if($planes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($planes as $plan)
                    <div class="plan-item bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow"
                         data-tipo="{{ $plan->tipo }}"
                         data-estado="{{ $plan->estado }}">
                        <!-- Header de la tarjeta -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $plan->nombre }}</h3>
                                    <p class="text-sm text-gray-500">#{{ $plan->id }}</p>
                                </div>
                                <!-- Badge de tipo -->
                                @php
                                    $typeColors = [
                                        'basico' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
                                        'premium' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                        'vip' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800']
                                    ];
                                    $typeStyle = $typeColors[$plan->tipo] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $typeStyle['bg'] }} {{ $typeStyle['text'] }}">
                                    {{ ucfirst($plan->tipo) }}
                                </span>
                            </div>

                            <!-- Precio -->
                            <div class="flex items-baseline">
                                <span class="text-3xl font-bold text-orange-600">S/. {{ number_format($plan->precio, 2) }}</span>
                                <span class="ml-2 text-sm text-gray-500">/ {{ $plan->duracion }} {{ $plan->duracion == 1 ? 'mes' : 'meses' }}</span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-6 space-y-4">
                            <!-- Descripción -->
                            @if($plan->descripcion)
                            <div>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $plan->descripcion }}</p>
                            </div>
                            @endif

                            <!-- Disciplinas -->
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Disciplinas incluidas</p>
                                @if($plan->disciplinas)
                                    @php
                                        $disciplinasIds = explode(',', $plan->disciplinas);
                                        $disciplinasNombres = \App\Models\Disciplina::whereIn('id', $disciplinasIds)->pluck('nombre')->toArray();
                                    @endphp
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($disciplinasNombres as $disciplinaNombre)
                                            <span class="px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded-md">{{ $disciplinaNombre }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400">Sin disciplinas asignadas</p>
                                @endif
                            </div>

                            <!-- Beneficios -->
                            @if($plan->beneficios)
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Beneficios</p>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $plan->beneficios }}</p>
                            </div>
                            @endif

                            <!-- Estado -->
                            <div class="pt-3 border-t border-gray-100">
                                @if($plan->estado == 'activo')
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-2">
                            <button @click="$dispatch('open-modal', { modal: 'editPlan{{ $plan->id }}' })" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </button>
                            <form action="{{ route('admin.planes.destroy', $plan->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors" 
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este plan?')">
                                    <i class="fas fa-trash mr-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <i class="fas fa-credit-card text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No hay planes registrados</p>
                <p class="text-gray-400 text-sm mt-2">Crea el primer plan para comenzar</p>
            </div>
        @endif
    </div>
</div>

<!-- Sistema de Modales con Alpine.js -->
<div x-data="{ 
    currentModal: null,
    openModal(modalId) { this.currentModal = modalId; },
    closeModal() { this.currentModal = null; }
}" 
@open-modal.window="openModal($event.detail.modal)"
@keydown.escape.window="closeModal()">
    @foreach($planes as $plan)
    <div x-show="currentModal === 'editPlan{{ $plan->id }}'" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="currentModal === 'editPlan{{ $plan->id }}'" @click="closeModal()" class="fixed inset-0 bg-black bg-opacity-50"></div>
            <div x-show="currentModal === 'editPlan{{ $plan->id }}'" class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <form method="POST" action="{{ route('admin.planes.update', $plan->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="bg-green-600 text-white px-6 py-4 rounded-t-lg sticky top-0 z-10">
                        <h3 class="text-xl font-semibold"><i class="fas fa-edit mr-2"></i>Editar Plan: {{ $plan->nombre }}</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Plan *</label>
                                <input type="text" name="nombre" value="{{ $plan->nombre }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Precio (S/.) *</label>
                                <input type="number" step="0.01" name="precio" value="{{ $plan->precio }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Duración (meses) *</label>
                                <input type="number" name="duracion" value="{{ $plan->duracion }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Plan *</label>
                                <select name="tipo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                                    <option value="basico" {{ $plan->tipo == 'basico' ? 'selected' : '' }}>Básico</option>
                                    <option value="premium" {{ $plan->tipo == 'premium' ? 'selected' : '' }}>Premium</option>
                                    <option value="vip" {{ $plan->tipo == 'vip' ? 'selected' : '' }}>VIP</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Disciplinas Incluidas</label>
                                <select name="disciplinas[]" multiple size="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                    @foreach($disciplinas as $disciplina)
                                    @php
                                        $disciplinasArray = $plan->disciplinas ? explode(',', $plan->disciplinas) : [];
                                    @endphp
                                    <option value="{{ $disciplina->id }}" {{ in_array($disciplina->id, $disciplinasArray) ? 'selected' : '' }}>
                                        {{ $disciplina->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Mantén presionado Ctrl para seleccionar múltiples</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                                <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500" required>
                                    <option value="activo" {{ $plan->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ $plan->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <textarea name="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">{{ $plan->descripcion }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Beneficios</label>
                            <textarea name="beneficios" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">{{ $plan->beneficios }}</textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3 sticky bottom-0 border-t">
                        <button type="button" @click="closeModal()" class="px-5 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancelar</button>
                        <button type="submit" class="px-5 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700"><i class="fas fa-save mr-2"></i>Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<style>[x-cloak] { display: none !important; }</style>