<!-- DISCIPLINAS - Gestión de Disciplinas -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-running text-orange-600 mr-3"></i>
            Gestión de Disciplinas
        </h1>
    </div>

    <!-- Mensajes de error -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario de Registro de Disciplinas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-orange-600 mr-2"></i>
            Crear Nueva Disciplina
        </h3>

        <form id="formDisciplina" method="POST" action="{{ route('admin.disciplinas.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nombreDisciplina" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="nombreDisciplina" 
                        name="nombre" 
                        placeholder="Ej: Fútbol" 
                        required 
                        value="{{ old('nombre') }}">
                </div>

                <div>
                    <label for="categoriaDisciplina" class="block text-sm font-medium text-gray-700 mb-2">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="categoriaDisciplina" 
                        name="categoria" 
                        required>
                        <option value="">Seleccionar categoría</option>
                        <option value="Fútbol" {{ old('categoria') == 'Fútbol' ? 'selected' : '' }}>Fútbol</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="edadMinima" class="block text-sm font-medium text-gray-700 mb-2">
                        Edad Mínima
                    </label>
                    <input type="number" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="edadMinima" 
                        name="edad_minima" 
                        placeholder="5" 
                        value="{{ old('edad_minima') }}">
                </div>

                <div>
                    <label for="edadMaxima" class="block text-sm font-medium text-gray-700 mb-2">
                        Edad Máxima
                    </label>
                    <input type="number" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="edadMaxima" 
                        name="edad_maxima" 
                        placeholder="18" 
                        value="{{ old('edad_maxima') }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="cupoDisciplina" class="block text-sm font-medium text-gray-700 mb-2">
                        Cupo Máximo
                    </label>
                    <input type="number" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="cupoDisciplina" 
                        name="cupo_maximo" 
                        placeholder="20" 
                        value="{{ old('cupo_maximo') }}">
                </div>

                <div>
                    <label for="estadoDisciplina" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="estadoDisciplina" 
                        name="estado" 
                        required>
                        <option value="activa">Activa</option>
                        <option value="inactiva">Inactiva</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="imagenDisciplina" class="block text-sm font-medium text-gray-700 mb-2">
                    Imagen de la Disciplina
                </label>
                <input type="file" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                    id="imagenDisciplina" 
                    name="imagen" 
                    accept="image/*">
                <p class="text-sm text-gray-500 mt-1">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 5MB</p>
            </div>

            <div class="mb-4">
                <label for="descripcionDisciplina" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción
                </label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                    id="descripcionDisciplina" 
                    name="descripcion" 
                    rows="3" 
                    placeholder="Descripción de la disciplina">{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="requisitosDisciplina" class="block text-sm font-medium text-gray-700 mb-2">
                    Requisitos
                </label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                    id="requisitosDisciplina" 
                    name="requisitos" 
                    rows="3" 
                    placeholder="Requisitos para inscribirse">{{ old('requisitos') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Crear Disciplina
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Disciplinas (Grid de Tarjetas) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="border-b border-gray-100 pb-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-th-large text-orange-600 mr-2"></i>
                Disciplinas Disponibles
            </h2>
        </div>

        <!-- Filtros -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <i class="fas fa-filter text-gray-500"></i>
                    <span class="text-sm font-medium text-gray-700">Filtrar por:</span>
                </div>
                
                <select id="filtroEstado" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" onchange="filtrarDisciplinas()">
                    <option value="">Todos los estados</option>
                    <option value="activa">Activas</option>
                    <option value="inactiva">Inactivas</option>
                </select>

                <select id="filtroCategoria" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" onchange="filtrarDisciplinas()">
                    <option value="">Todas las categorías</option>
                    <option value="Fútbol">Fútbol</option>
                </select>

                <!-- BOTÓN LIMPIAR CORREGIDO -->
                <button type="button" 
                        id="btnLimpiarFiltros"
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <i class="fas fa-redo mr-1"></i>Limpiar
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($disciplinas as $disciplina)
            <div class="disciplina-card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group"
                 data-estado="{{ $disciplina->estado }}"
                 data-categoria="{{ $disciplina->categoria }}">
                <!-- Imagen y Estado -->
                <div class="relative h-48 bg-gradient-to-br from-gray-50 to-gray-100">
                    @if($disciplina->imagen)
                        <img src="{{ asset('storage/' . $disciplina->imagen) }}" alt="{{ $disciplina->nombre }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-running text-gray-300 text-5xl"></i>
                        </div>
                    @endif
                    
                    <!-- Badge de Estado -->
                    <div class="absolute top-3 right-3">
                        @if($disciplina->estado == 'activa')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500 text-white shadow-lg">
                                <i class="fas fa-check-circle mr-1"></i>Activa
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-500 text-white shadow-lg">
                                <i class="fas fa-times-circle mr-1"></i>Inactiva
                            </span>
                        @endif
                    </div>

                    <!-- Badge de Categoría -->
                    <div class="absolute bottom-3 left-3">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-white/95 text-gray-800 shadow-md backdrop-blur-sm border border-gray-200">
                            <i class="fas fa-tag mr-1 text-orange-500"></i>{{ $disciplina->categoria }}
                        </span>
                    </div>
                    
                    <!-- ID Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="px-2 py-1 text-xs font-mono font-bold rounded bg-black/70 text-white backdrop-blur-sm">
                            #{{ $disciplina->id }}
                        </span>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors">
                        {{ $disciplina->nombre }}
                    </h3>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-users w-5 text-orange-500 mr-2"></i>
                            <span class="font-medium">Edad:</span>
                            <span class="ml-2">
                                @if($disciplina->edad_minima || $disciplina->edad_maxima)
                                    {{ $disciplina->edad_minima ?? '0' }} - {{ $disciplina->edad_maxima ?? '∞' }} años
                                @else
                                    Sin límite
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-user-friends w-5 text-orange-500 mr-2"></i>
                            <span class="font-medium">Cupo:</span>
                            <span class="ml-2">{{ $disciplina->cupo_maximo ?? 'Ilimitado' }}</span>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                        <button @click="$dispatch('open-modal', { modal: 'editDisciplina{{ $disciplina->id }}' })" 
                            class="flex-1 flex items-center justify-center gap-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 py-2 px-3 rounded-lg transition-colors">
                            <i class="fas fa-edit"></i>
                            <span>Editar</span>
                        </button>
                        
                        <form action="{{ route('admin.disciplinas.destroy', $disciplina->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-full flex items-center justify-center gap-1 text-sm font-medium text-white bg-red-600 hover:bg-red-700 py-2 px-3 rounded-lg transition-colors" 
                                onclick="return confirm('¿Eliminar esta disciplina?')">
                                <i class="fas fa-trash"></i>
                                <span>Eliminar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border-2 border-dashed border-gray-300">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-white p-6 rounded-full shadow-lg mb-4">
                        <i class="fas fa-running text-orange-500 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No hay disciplinas registradas</h3>
                    <p class="text-gray-500">Comienza creando la primera disciplina desde el formulario superior.</p>
                </div>
            </div>
            @endforelse
        </div>
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
    @foreach($disciplinas as $disciplina)
    <div x-show="currentModal === 'editDisciplina{{ $disciplina->id }}'" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="currentModal === 'editDisciplina{{ $disciplina->id }}'" @click="closeModal()" class="fixed inset-0 bg-black bg-opacity-50"></div>
            <div x-show="currentModal === 'editDisciplina{{ $disciplina->id }}'" class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" x-data="{ imagePreview: null }">
                <form method="POST" action="{{ route('admin.disciplinas.update', $disciplina->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg sticky top-0 z-10">
                        <h3 class="text-xl font-semibold"><i class="fas fa-edit mr-2"></i>Editar Disciplina: {{ $disciplina->nombre }}</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                                <input type="text" name="nombre" value="{{ $disciplina->nombre }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
                                <select name="categoria" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                                    <option value="Fútbol" {{ $disciplina->categoria == 'Fútbol' ? 'selected' : '' }}>Fútbol</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Edad Mínima</label>
                                <input type="number" name="edad_minima" value="{{ $disciplina->edad_minima }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Edad Máxima</label>
                                <input type="number" name="edad_maxima" value="{{ $disciplina->edad_maxima }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cupo Máximo</label>
                                <input type="number" name="cupo_maximo" value="{{ $disciplina->cupo_maximo }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                                <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                                    <option value="activa" {{ $disciplina->estado == 'activa' ? 'selected' : '' }}>Activa</option>
                                    <option value="inactiva" {{ $disciplina->estado == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen de la Disciplina</label>
                            <input type="file" name="imagen" accept="image/*" 
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                            <p class="text-xs text-gray-500 mt-1">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 5MB</p>
                            @if($disciplina->imagen)
                                <div class="mt-3">
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-700 mb-2">Vista previa:</p>
                                            <img :src="imagePreview || '{{ asset('storage/' . $disciplina->imagen) }}'" alt="Preview" class="h-32 w-auto object-cover rounded border border-gray-300 shadow-sm">
                                        </div>
                                        <div class="flex-1">
                                            <label class="flex items-center space-x-2 text-sm text-red-600 cursor-pointer">
                                                <input type="checkbox" name="eliminar_imagen" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                <span>Eliminar imagen actual</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div x-show="imagePreview" class="mt-3">
                                    <p class="text-xs font-medium text-gray-700 mb-2">Vista previa:</p>
                                    <img :src="imagePreview" alt="Preview" class="h-32 w-auto object-cover rounded border border-gray-300 shadow-sm">
                                </div>
                            @endif
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <textarea name="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ $disciplina->descripcion }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Requisitos</label>
                            <textarea name="requisitos" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ $disciplina->requisitos }}</textarea>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3 sticky bottom-0 border-t">
                        <button type="button" @click="closeModal()" class="px-5 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancelar</button>
                        <button type="submit" class="px-5 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700"><i class="fas fa-save mr-2"></i>Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de filtros cargado correctamente');
    
    // Verificar elementos del DOM
    const filtroEstado = document.getElementById('filtroEstado');
    const filtroCategoria = document.getElementById('filtroCategoria');
    const btnLimpiar = document.getElementById('btnLimpiarFiltros');
    const cards = document.querySelectorAll('.disciplina-card');
    
    console.log('Elementos encontrados:');
    console.log('  - Filtro Estado:', filtroEstado !== null);
    console.log('  - Filtro Categoría:', filtroCategoria !== null);
    console.log('  - Botón Limpiar:', btnLimpiar !== null);
    console.log('  - Tarjetas de disciplinas:', cards.length);

    window.filtrarDisciplinas = function() {
        console.log('Iniciando filtrado de disciplinas...');
        
        const estado = (document.getElementById('filtroEstado')?.value || '').toLowerCase();
        const categoria = (document.getElementById('filtroCategoria')?.value || '').toLowerCase();
        
        console.log('Estado seleccionado:', estado || '(todos)');
        console.log('Categoría seleccionada:', categoria || '(todas)');
        
        const cards = document.querySelectorAll('.disciplina-card');
        let visibles = 0;
        let ocultas = 0;
        
        cards.forEach(card => {
            const cardEstado = (card.dataset.estado || '').toLowerCase();
            const cardCategoria = (card.dataset.categoria || '').toLowerCase();
            
            const matchEstado = !estado || cardEstado === estado;
            const matchCategoria = !categoria || cardCategoria === categoria;
            
            if (matchEstado && matchCategoria) {
                card.style.display = '';
                visibles++;
            } else {
                card.style.display = 'none';
                ocultas++;
            }
        });
        
        console.log('Resultado: ' + visibles + ' visibles, ' + ocultas + ' ocultas');
    };
    
    window.limpiarFiltros = function() {
        console.log('Limpiando filtros...');
        
        const selectEstado = document.getElementById('filtroEstado');
        const selectCategoria = document.getElementById('filtroCategoria');
        
        // Resetear select de estado
        if (selectEstado) {
            selectEstado.selectedIndex = 0;
            console.log('Filtro de estado reseteado');
        } else {
            console.error('No se encontró el elemento #filtroEstado');
        }
        
        // Resetear select de categoría
        if (selectCategoria) {
            selectCategoria.selectedIndex = 0;
            console.log('Filtro de categoría reseteado');
        } else {
            console.error('No se encontró el elemento #filtroCategoria');
        }
        
        // Mostrar todas las tarjetas
        const cards = document.querySelectorAll('.disciplina-card');
        let count = 0;
        cards.forEach(card => {
            card.style.display = '';
            count++;
        });
        
        console.log('Mostrando todas las tarjetas (' + count + ')');
    };
    

    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Click en botón Limpiar detectado');
            limpiarFiltros();
        });
        console.log('Event listener agregado al botón Limpiar');
    } else {
        console.error('No se encontró el botón #btnLimpiarFiltros');
    }
    

    if (filtroEstado) {
        filtroEstado.addEventListener('change', function() {
            console.log('Cambio en filtro de estado:', this.value);
            filtrarDisciplinas();
        });
    }
    
    if (filtroCategoria) {
        filtroCategoria.addEventListener('change', function() {
            console.log('Cambio en filtro de categoría:', this.value);
            filtrarDisciplinas();
        });
    }
    
    console.log('Sistema de filtros inicializado correctamente');
});

</script>

<style>[x-cloak] { display: none !important; }</style>
