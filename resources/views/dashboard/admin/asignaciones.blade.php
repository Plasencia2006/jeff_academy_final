<!-- ASIGNACIONES - Gestionar Inscripciones de Jugadores -->
<div class="space-y-6" x-data="{
    modalEditarAbierto: false,
    modalDetallesAbierto: false,
    inscripcionId: null,
    disciplina: '',
    categoria: '',
    tipoEntrenamiento: '',
    fecha: '',
    entrenadorId: null,
    observaciones: '',
    jugadorNombre: '',
    detallesInscripcion: {},
    editarInscripcion(id, disc, cat, tipo, fec, entId, obs, jugador) {
        this.inscripcionId = id;
        this.disciplina = disc;
        this.categoria = cat;
        this.tipoEntrenamiento = tipo;
        this.fecha = fec;
        this.entrenadorId = entId;
        this.observaciones = obs;
        this.jugadorNombre = jugador;
        this.modalEditarAbierto = true;
    },
    verDetalles(inscripcion) {
        this.detallesInscripcion = inscripcion;
        this.modalDetallesAbierto = true;
    },
    cerrarModal() {
        this.modalEditarAbierto = false;
        this.modalDetallesAbierto = false;
    }
}" @keydown.escape.window="cerrarModal()">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-clipboard-list text-orange-600 mr-3"></i>
            Asignar Jugadores
        </h1>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-clipboard-list text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($inscripciones) ? $inscripciones->count() : 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <i class="fas fa-child text-yellow-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sub 8</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($inscripciones) ? $inscripciones->where('categoria', 'sub8')->count() : 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <i class="fas fa-child text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sub 12</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($inscripciones) ? $inscripciones->where('categoria', 'sub12')->count() : 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                    <i class="fas fa-child text-orange-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sub 14</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($inscripciones) ? $inscripciones->where('categoria', 'sub14')->count() : 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gray-100 rounded-lg p-3">
                    <i class="fas fa-child text-gray-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sub 16</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($inscripciones) ? $inscripciones->where('categoria', 'sub16')->count() : 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-child text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Avanzado</p>
                    <p class="text-2xl font-bold text-gray-900">{{ isset($inscripciones) ? $inscripciones->where('categoria', 'avanzado')->count() : 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Nueva Inscripción -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-plus-circle text-orange-600 mr-2"></i>
            Registrar Nueva Inscripción
        </h3>
        
        <form id="formInscripcion" method="POST" action="{{ route('admin.inscripciones.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Jugador -->
                <div>
                    <label for="jugadorInscripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Jugador <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="jugadorInscripcion" 
                        name="jugador_id" 
                        required>
                        <option value="">Seleccionar jugador</option>
                        @foreach($jugadores ?? [] as $jugador)
                            <option value="{{ $jugador->id }}">{{ $jugador->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Disciplina -->
                <div>
                    <label for="disciplinaInscripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Disciplina <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="disciplinaInscripcion" 
                        name="disciplina" 
                        required>
                        <option value="">Seleccionar disciplina</option>
                        @foreach($disciplinas as $disciplina)
                            <option value="{{ strtolower($disciplina->nombre) }}">{{ $disciplina->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Categoría -->
                <div>
                    <label for="categoriaInscripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="categoriaInscripcion" 
                        name="categoria" 
                        required>
                        <option value="">Seleccionar categoría</option>
                        <option value="sub8">Sub-8</option>
                        <option value="sub12">Sub-12</option>
                        <option value="sub14">Sub-14</option>
                        <option value="sub16">Sub-16</option>
                        <option value="avanzado">Avanzado</option>
                    </select>
                </div>

                <!-- Tipo de Entrenamiento -->
                <div>
                    <label for="tipoEntrenamiento" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Entrenamiento <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="tipoEntrenamiento" 
                        name="tipo_entrenamiento" 
                        required>
                        <option value="">Seleccionar tipo</option>
                        <option value="regular">Regular</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                </div>

                <!-- Fecha de Inscripción -->
                <div>
                    <label for="fechaInscripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha de Inscripción <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="fechaInscripcion" 
                        name="fecha" 
                        value="{{ date('Y-m-d') }}"
                        required>
                </div>

                <!-- Entrenador Asignado -->
                <div>
                    <label for="entrenadorAsignado" class="block text-sm font-medium text-gray-700 mb-2">
                        Entrenador Asignado
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        id="entrenadorAsignado" 
                        name="entrenador_id">
                        <option value="">Seleccionar entrenador</option>
                        @foreach($entrenadores ?? [] as $entrenador)
                            <option value="{{ $entrenador->id }}">{{ $entrenador->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="mt-4">
                <label for="observacionesInscripcion" class="block text-sm font-medium text-gray-700 mb-2">
                    Observaciones
                </label>
                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                    id="observacionesInscripcion" 
                    name="observaciones" 
                    rows="3"
                    placeholder="Observaciones adicionales"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Asignar Inscripción
                </button>
            </div>
        </form>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100" x-data="{
        filtroCategoria: '',
        buscarJugador: '',
        filtroEntrenador: '',
        filtrarAsignaciones() {
            const categoria = this.filtroCategoria.toLowerCase();
            const jugador = this.buscarJugador.toLowerCase();
            const entrenador = this.filtroEntrenador;
            
            document.querySelectorAll('.asignacion-row').forEach(row => {
                const rowCategoria = row.dataset.categoria?.toLowerCase() || '';
                const rowJugador = row.dataset.jugador?.toLowerCase() || '';
                const rowEntrenador = row.dataset.entrenador || '';
                
                const matchCategoria = !categoria || rowCategoria === categoria;
                const matchJugador = !jugador || rowJugador.includes(jugador);
                const matchEntrenador = !entrenador || rowEntrenador === entrenador;
                
                if (matchCategoria && matchJugador && matchEntrenador) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        },
        limpiarFiltros() {
            this.filtroCategoria = '';
            this.buscarJugador = '';
            this.filtroEntrenador = '';
            this.filtrarAsignaciones();
        }
    }">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select x-model="filtroCategoria" @change="filtrarAsignaciones()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todas las categorías</option>
                        <option value="sub8">Sub-8</option>
                        <option value="sub12">Sub-12</option>
                        <option value="sub14">Sub-14</option>
                        <option value="sub16">Sub-16</option>
                        <option value="avanzado">Avanzado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Jugador</label>
                    <input type="text" x-model="buscarJugador" @input="filtrarAsignaciones()"
                            placeholder="Nombre del jugador..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Entrenador</label>
                    <select x-model="filtroEntrenador" @change="filtrarAsignaciones()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos los entrenadores</option>
                        @foreach($coaches ?? [] as $coach)
                            <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                        @endforeach
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

    <!-- Tabla de Usuarios Asignados -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-users text-orange-600 mr-2"></i>
                Usuarios Asignados
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jugador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disciplina</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrenador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observaciones</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($inscripciones ?? [] as $inscripcion)
                    <tr class="asignacion-row hover:bg-gray-50 transition-colors"
                        data-categoria="{{ $inscripcion->categoria }}"
                        data-jugador="{{ $inscripcion->jugador->name ?? '' }}"
                        data-entrenador="{{ $inscripcion->entrenador_id ?? '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500">#{{ $inscripcion->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $inscripcion->jugador->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $inscripcion->jugador->email ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($inscripcion->disciplina) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                {{ strtoupper($inscripcion->categoria) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ ucfirst($inscripcion->tipo_entrenamiento ?? 'Regular') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $inscripcion->entrenador->name ?? 'Sin asignar' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($inscripcion->fecha)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $inscripcion->observaciones }}">
                            {{ $inscripcion->observaciones ? \Str::limit($inscripcion->observaciones, 20) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-3">
                                <!-- Botón Ver Detalles -->
                                <button @click="verDetalles({
                                            id: {{ $inscripcion->id }},
                                            jugador: '{{ $inscripcion->jugador->name ?? 'N/A' }}',
                                            email: '{{ $inscripcion->jugador->email ?? 'N/A' }}',
                                            telefono: '{{ $inscripcion->jugador->telefono ?? 'N/A' }}',
                                            disciplina: '{{ ucfirst($inscripcion->disciplina) }}',
                                            categoria: '{{ strtoupper($inscripcion->categoria) }}',
                                            tipo: '{{ ucfirst($inscripcion->tipo_entrenamiento ?? 'Regular') }}',
                                            entrenador: '{{ $inscripcion->entrenador->name ?? 'Sin asignar' }}',
                                            fecha: '{{ \Carbon\Carbon::parse($inscripcion->fecha)->format('d/m/Y') }}',
                                            observaciones: '{{ $inscripcion->observaciones ?? '-' }}'
                                        })" 
                                        class="text-green-600 hover:text-green-800 transition-colors" 
                                        title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <!-- Botón Editar -->
                                <button @click="editarInscripcion({{ $inscripcion->id }}, '{{ $inscripcion->disciplina }}', '{{ $inscripcion->categoria }}', '{{ $inscripcion->tipo_entrenamiento ?? 'regular' }}', '{{ $inscripcion->fecha }}', {{ $inscripcion->entrenador_id ?? 'null' }}, '{{ addslashes($inscripcion->observaciones ?? '') }}', '{{ $inscripcion->jugador->name ?? '' }}')" 
                                        class="text-blue-600 hover:text-blue-800 transition-colors" 
                                        title="Editar inscripción">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('admin.inscripciones.destroy', $inscripcion->id) }}" 
                                    method="POST" 
                                    class="inline"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta inscripción? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition-colors" 
                                            title="Eliminar inscripción">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg">No hay inscripciones registradas</p>
                                <p class="text-gray-400 text-sm mt-2">Crea la primera inscripción para comenzar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Edición de Inscripción -->
    <div>
        <div x-show="modalEditarAbierto" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div x-show="modalEditarAbierto" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="cerrarModal()"
                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                <!-- Modal Content -->
                <div x-show="modalEditarAbierto" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    
                    <form x-bind:action="'{{ url('admin/inscripciones') }}/' + inscripcionId" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="bg-white px-6 pt-5 pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-edit text-blue-600 mr-2"></i>
                                    Editar Inscripción
                                </h3>
                                <button @click="cerrarModal()" type="button" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <!-- Jugador (Solo lectura) -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jugador
                                    </label>
                                    <input type="text" 
                                           :value="jugadorNombre" 
                                           readonly
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                                </div>

                                <!-- Disciplina -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Disciplina <span class="text-red-500">*</span>
                                    </label>
                                    <select x-model="disciplina" 
                                            name="disciplina" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Seleccionar disciplina</option>
                                        @foreach($disciplinas as $disciplina)
                                            <option value="{{ strtolower($disciplina->nombre) }}">{{ $disciplina->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Categoría -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Categoría <span class="text-red-500">*</span>
                                    </label>
                                    <select x-model="categoria" 
                                            name="categoria" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Seleccionar categoría</option>
                                        <option value="sub8">Sub-8</option>
                                        <option value="sub12">Sub-12</option>
                                        <option value="sub14">Sub-14</option>
                                        <option value="sub16">Sub-16</option>
                                        <option value="avanzado">Avanzado</option>
                                    </select>
                                </div>

                                <!-- Tipo de Entrenamiento -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipo de Entrenamiento <span class="text-red-500">*</span>
                                    </label>
                                    <select x-model="tipoEntrenamiento" 
                                            name="tipo_entrenamiento" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="regular">Regular</option>
                                        <option value="personalizado">Personalizado</option>
                                    </select>
                                </div>

                                <!-- Fecha -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Fecha de Inscripción <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           x-model="fecha" 
                                           name="fecha" 
                                           required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>

                                <!-- Entrenador -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Entrenador Asignado
                                    </label>
                                    <select x-model="entrenadorId" 
                                            name="entrenador_id"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Seleccionar entrenador</option>
                                        @foreach($entrenadores ?? [] as $entrenador)
                                            <option value="{{ $entrenador->id }}">{{ $entrenador->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Observaciones -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Observaciones
                                    </label>
                                    <textarea x-model="observaciones" 
                                              name="observaciones" 
                                              rows="3"
                                              placeholder="Observaciones adicionales"
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                            <button @click="cerrarModal()" 
                                    type="button" 
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles de Inscripción -->
    <div>
        <div x-show="modalDetallesAbierto" 
            x-cloak
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div x-show="modalDetallesAbierto" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click="cerrarModal()"
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                <!-- Modal Content -->
                <div x-show="modalDetallesAbierto" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    
                    <div class="bg-white px-6 pt-5 pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-info-circle text-green-600 mr-2"></i>
                                Detalles de la Inscripción
                            </h3>
                            <button @click="cerrarModal()" type="button" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- ID -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">ID</p>
                                <p class="text-lg font-semibold text-gray-900" x-text="'#' + detallesInscripcion.id"></p>
                            </div>

                            <!-- Jugador -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Jugador</p>
                                <p class="text-lg font-semibold text-gray-900" x-text="detallesInscripcion.jugador"></p>
                            </div>

                            <!-- Email -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</p>
                                <p class="text-sm text-gray-700" x-text="detallesInscripcion.email"></p>
                            </div>

                            <!-- Teléfono -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Teléfono</p>
                                <p class="text-sm text-gray-700" x-text="detallesInscripcion.telefono"></p>
                            </div>

                            <!-- Disciplina -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Disciplina</p>
                                <span class="inline-flex px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800 font-medium" x-text="detallesInscripcion.disciplina"></span>
                            </div>

                            <!-- Categoría -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Categoría</p>
                                <span class="inline-flex px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800 font-medium" x-text="detallesInscripcion.categoria"></span>
                            </div>

                            <!-- Tipo de Entrenamiento -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tipo de Entrenamiento</p>
                                <p class="text-sm text-gray-700" x-text="detallesInscripcion.tipo"></p>
                            </div>

                            <!-- Entrenador -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Entrenador Asignado</p>
                                <p class="text-sm text-gray-700" x-text="detallesInscripcion.entrenador"></p>
                            </div>

                            <!-- Fecha -->
                            <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Fecha de Inscripción</p>
                                <p class="text-sm text-gray-700" x-text="detallesInscripcion.fecha"></p>
                            </div>

                            <!-- Observaciones -->
                            <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Observaciones</p>
                                <p class="text-sm text-gray-700 whitespace-pre-wrap" x-text="detallesInscripcion.observaciones"></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end">
                        <button @click="cerrarModal()" 
                                type="button" 
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class="fas fa-times mr-2"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>