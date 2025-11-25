<!-- NOTICIAS - Gestión de Noticias -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-newspaper text-orange-600 mr-3"></i>
            Gestión de Noticias
        </h1>
    </div>

    <!-- Mensajes de error -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tarjetas de Noticias -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total de Noticias -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100">
                    <i class="fas fa-newspaper text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $noticias->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Generales -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-globe text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Generales</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $noticias->where('categoria', 'general')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Torneos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100">
                    <i class="fas fa-trophy text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Torneos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $noticias->where('categoria', 'torneo')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Entrenamientos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-running text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Entrenamientos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $noticias->where('categoria', 'entrenamiento')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Logros -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-cyan-100">
                    <i class="fas fa-medal text-cyan-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Logros</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $noticias->where('categoria', 'logro')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Publicación -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-orange-600 mr-2"></i>
            Publicar Nueva Noticia
        </h3>

        <form id="formNoticia" method="POST" action="{{ route('admin.noticias.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tituloNoticia" class="block text-sm font-medium text-gray-700 mb-2">
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="tituloNoticia" 
                        name="titulo" 
                        placeholder="Título de la noticia" 
                        required 
                        value="{{ old('titulo') }}">
                </div>

                <div>
                    <label for="categoriaNoticia" class="block text-sm font-medium text-gray-700 mb-2">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="categoriaNoticia" 
                        name="categoria" 
                        required>
                        <option value="">Seleccionar categoría</option>
                        <option value="general" {{ old('categoria') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="torneo" {{ old('categoria') == 'torneo' ? 'selected' : '' }}>Torneo</option>
                        <option value="entrenamiento" {{ old('categoria') == 'entrenamiento' ? 'selected' : '' }}>Entrenamiento</option>
                        <option value="logro" {{ old('categoria') == 'logro' ? 'selected' : '' }}>Logro</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="descripcionNoticia" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción <span class="text-red-500">*</span>
                </label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                    id="descripcionNoticia" 
                    name="descripcion" 
                    rows="4" 
                    placeholder="Escribe la noticia aquí..." 
                    required>{{ old('descripcion') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="imagenNoticia" class="block text-sm font-medium text-gray-700 mb-2">
                        Imagen (Opcional)
                    </label>
                    <input type="file" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="imagenNoticia" 
                        name="imagen" 
                        accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Formatos permitidos: JPEG, PNG, JPG, GIF. Máximo 2MB</p>
                </div>

                <div>
                    <label for="fechaPublicacion" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha de Publicación <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="fechaPublicacion" 
                        name="fecha" 
                        required 
                        value="{{ old('fecha', date('Y-m-d')) }}">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Publicar Noticia
                </button>
            </div>
        </form>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100" x-data="{
        filtroCategoria: '',
        buscarNoticia: '',
        filtrarNoticias() {
            const categoria = this.filtroCategoria.toLowerCase();
            const busqueda = this.buscarNoticia.toLowerCase();
            
            document.querySelectorAll('.noticia-item').forEach(item => {
                const itemCategoria = item.dataset.categoria?.toLowerCase() || '';
                const itemTitulo = item.dataset.titulo?.toLowerCase() || '';
                
                const matchCategoria = !categoria || itemCategoria === categoria;
                const matchBusqueda = !busqueda || itemTitulo.includes(busqueda);
                
                if (matchCategoria && matchBusqueda) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        },
        limpiarFiltros() {
            this.filtroCategoria = '';
            this.buscarNoticia = '';
            this.filtrarNoticias();
        }
    }">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select x-model="filtroCategoria" @change="filtrarNoticias()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Todas las categorías</option>
                        <option value="general">General</option>
                        <option value="torneo">Torneo</option>
                        <option value="entrenamiento">Entrenamiento</option>
                        <option value="logro">Logro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Noticia</label>
                    <input type="text" x-model="buscarNoticia" @input="filtrarNoticias()"
                            placeholder="Título de la noticia..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
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

    <!-- Noticias Publicadas -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-list text-orange-600 mr-2"></i>
            Noticias Publicadas
        </h2>

        @if(($noticias ?? collect())->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($noticias ?? [] as $noticia)
                    <div class="noticia-item bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow"
                         data-categoria="{{ $noticia->categoria }}"
                         data-titulo="{{ $noticia->titulo }}">
                        <!-- Imagen de la Noticia -->
                        <div class="relative h-48 overflow-hidden">
                            @if($noticia->imagen)
                                @if(strpos($noticia->imagen, 'http') === 0)
                                    <img src="{{ $noticia->imagen }}" alt="{{ $noticia->titulo }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}" class="w-full h-full object-cover">
                                @endif
                            @else
                                <img src="https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" alt="{{ $noticia->titulo }}" class="w-full h-full object-cover">
                            @endif

                            <!-- Categoría Badge -->
                            @php
                                $categoryColors = [
                                    'general' => 'bg-blue-500',
                                    'torneo' => 'bg-green-500',
                                    'entrenamiento' => 'bg-orange-500',
                                    'logro' => 'bg-red-500'
                                ];
                                $categoryColor = $categoryColors[$noticia->categoria] ?? 'bg-gray-500';
                            @endphp
                            <span class="absolute top-3 right-3 {{ $categoryColor }} text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ ucfirst($noticia->categoria) }}
                            </span>
                        </div>

                        <!-- Contenido -->
                        <div class="p-5">
                            <!-- Título -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $noticia->titulo }}</h3>

                            <!-- Fecha -->
                            <p class="text-sm text-gray-500 mb-3 flex items-center">
                                <i class="fas fa-calendar mr-2"></i>
                                {{ \Carbon\Carbon::parse($noticia->fecha)->format('d/m/Y') }}
                            </p>

                            <!-- Descripción -->
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit($noticia->descripcion, 100, '...') }}
                            </p>
            
                            <!-- Estado -->
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Publicada
                                </span>
                        </div>
                        
                            <!-- Acciones -->
                            <div class="flex gap-2">
                                <button type="button" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors"
                                    @click="$dispatch('open-modal', { modal: 'editNews{{ $noticia->id }}' })">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </button>

                                <form action="{{ route('admin.noticias.destroy', $noticia->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors" 
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta noticia?')">
                                        <i class="fas fa-trash mr-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <i class="fas fa-newspaper text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No hay noticias publicadas aún</p>
                <p class="text-gray-400 text-sm mt-2">Publica tu primera noticia para comenzar</p>
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
    @foreach($noticias ?? [] as $noticia)
    <div x-show="currentModal === 'editNews{{ $noticia->id }}'" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="currentModal === 'editNews{{ $noticia->id }}'" @click="closeModal()" class="fixed inset-0 bg-black bg-opacity-50"></div>
                        <div x-show="currentModal === 'editNews{{ $noticia->id }}'" class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <form method="POST" action="{{ route('admin.noticias.update', $noticia->id) }}" enctype="multipart/form-data" x-data="{ imagePreview: null }">
                    @csrf
                    @method('PUT')
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg sticky top-0 z-10">
                        <h3 class="text-lg font-semibold"><i class="fas fa-edit mr-2"></i>Editar Noticia</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                                <input type="text" name="titulo" value="{{ $noticia->titulo }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                <select name="categoria" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                                    <option value="general" {{ $noticia->categoria == 'general' ? 'selected' : '' }}>General</option>
                                    <option value="torneo" {{ $noticia->categoria == 'torneo' ? 'selected' : '' }}>Torneo</option>
                                    <option value="entrenamiento" {{ $noticia->categoria == 'entrenamiento' ? 'selected' : '' }}>Entrenamiento</option>
                                    <option value="logro" {{ $noticia->categoria == 'logro' ? 'selected' : '' }}>Logro</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción *</label>
                            <textarea name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>{{ $noticia->descripcion }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Publicación *</label>
                                <input type="date" name="fecha" value="{{ \Carbon\Carbon::parse($noticia->fecha)->format('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                                <input type="file" name="imagen" accept="image/*" 
                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                                <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener actual</p>
                            </div>
                        </div>
                        @if($noticia->imagen)
                            <div class="mt-2">
                                <p class="text-xs font-medium text-gray-700 mb-2">Vista previa:</p>
                                <img :src="imagePreview || '{{ asset('storage/' . $noticia->imagen) }}'" alt="Preview" class="h-32 w-auto object-cover rounded border border-gray-300 shadow-sm">
                            </div>
                        @else
                            <div x-show="imagePreview" class="mt-2">
                                <p class="text-xs font-medium text-gray-700 mb-2">Vista previa:</p>
                                <img :src="imagePreview" alt="Preview" class="h-32 w-auto object-cover rounded border border-gray-300 shadow-sm">
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3 sticky bottom-0 border-t">
                        <button type="button" @click="closeModal()" class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-100">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700"><i class="fas fa-save mr-1"></i>Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<style>[x-cloak] { display: none !important; }</style>