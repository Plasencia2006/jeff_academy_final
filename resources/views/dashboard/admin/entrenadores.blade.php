<!-- ENTRENADORES - Gestión de Entrenadores -->
<div class="space-y-6" x-data="{ 
    currentView: 'main',
    entrenadorSeleccionado: null,
    jugadoresEntrenador: [],
    jugadorSeleccionado: null,
    inscripcionEditar: null,
    disciplina: '',
    quitarJugador(inscripcionId) {
        fetch(`/admin/inscripciones/${inscripcionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                jugadoresEntrenador = jugadoresEntrenador.filter(j => j.id !== inscripcionId);
                if(jugadoresEntrenador.length === 0) {
                    currentView = 'main';
                }
                // Opcional: Mostrar mensaje de éxito
            } else {
                alert(data.message || 'Error al quitar el jugador');
            }
        })
        .catch(error => {
            alert('Error al quitar el jugador');
            console.error(error);
        });
    }
}">
<!-- Vista Principal -->
<div x-show="currentView === 'main'" class="space-y-6">
        <!-- Título de la sección -->
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-chalkboard-teacher text-orange-600 mr-3"></i>
                Gestión de Entrenadores
            </h1>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100" x-data="{
            buscarEntrenador: '',
            filtroEstado: '',
            filtrarEntrenadores() {
                const busqueda = this.buscarEntrenador.toLowerCase();
                const estado = this.filtroEstado.toLowerCase();
                
                document.querySelectorAll('tbody tr').forEach(row => {
                    // Skip empty state row
                    if (row.querySelector('td[colspan]')) return;
                    
                    const nombre = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                    const estadoCell = row.querySelector('td:nth-child(5)');
                    const estadoTexto = estadoCell?.textContent.toLowerCase().trim() || '';
                    
                    const matchNombre = !busqueda || nombre.includes(busqueda);
                    const matchEstado = !estado || estadoTexto.includes(estado);
                    
                    if (matchNombre && matchEstado) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            },
            limpiarFiltros() {
                this.buscarEntrenador = '';
                this.filtroEstado = '';
                this.filtrarEntrenadores();
            }
        }">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Entrenador</label>
                        <input type="text" x-model="buscarEntrenador" @input="filtrarEntrenadores()"
                                placeholder="Nombre del entrenador..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select x-model="filtroEstado" @change="filtrarEntrenadores()"
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

        <!-- Tabla de Entrenadores Registrados -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users text-orange-600 mr-2"></i>
                    Entrenadores Registrados
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($usuarios->where('role', 'coach') ?? [] as $usuario)
                        <tr class="hover:bg-gray-50 transition-colors {{ $usuario->estado == 'inactivo' ? 'bg-gray-100' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500">#{{ $usuario->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($usuario->foto_perfil)
                                        <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" 
                                        alt="{{ $usuario->name }}"
                                        class="flex-shrink-0 h-10 w-10 rounded-full object-cover">
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10 bg-yellow-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ substr($usuario->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $usuario->name }}</div>
                                        @if($usuario->fecha_nacimiento)
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($usuario->fecha_nacimiento)->age }} años
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div class="truncate max-w-xs" title="{{ $usuario->email }}">
                                    {{ $usuario->email }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                @if($usuario->telefono)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                        <i class="fas fa-phone mr-1"></i>{{ $usuario->telefono }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($usuario->estado == 'activo')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Activo
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Editar -->
                                    <button 
                                        @click="$dispatch('open-modal', { modal: 'editUser{{ $usuario->id }}' })"
                                        class="text-blue-600 hover:text-blue-800 transition-colors" 
                                        title="Editar entrenador">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Cambiar contraseña -->
                                    <button 
                                        @click="$dispatch('open-modal', { modal: 'changePassword{{ $usuario->id }}' })"
                                        class="text-yellow-600 hover:text-yellow-800 transition-colors" 
                                        title="Cambiar contraseña">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <!-- Compartir Credenciales -->
                                    <button 
                                        @click="$dispatch('open-modal', { modal: 'shareCredentials{{ $usuario->id }}' })"
                                        class="text-indigo-600 hover:text-indigo-800 transition-colors" 
                                        title="Compartir credenciales">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                              
                                    <!-- Ver Jugadores -->
                                    <button 
                                        @click="currentView = 'jugadores'; entrenadorSeleccionado = {{ $usuario->id }}; jugadoresEntrenador = {{ $usuario->inscripcionesComoEntrenador->load('jugador')->values()->toJson() }}"
                                        class="text-purple-600 hover:text-purple-800 transition-colors" 
                                        title="Ver jugadores asignados">
                                        <i class="fas fa-users"></i>
                                    </button>

                                    <!-- Activar / Desactivar -->
                                    <form action="{{ route('usuarios.toggle', $usuario->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        @if ($usuario->estado == 'activo')
                                            <button type="submit" 
                                                class="text-green-600 hover:text-green-800 transition-colors"
                                                onclick="return confirm('¿Desactivar este entrenador?')"
                                                title="Activo - Click para desactivar">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        @else
                                            <button type="submit" 
                                                class="text-red-600 hover:text-red-800 transition-colors"
                                                onclick="return confirm('¿Activar este entrenador?')"
                                                title="Inactivo - Click para activar">
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        @endif
                                    </form>
                                                                    
                                    <!-- Eliminar -->
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-gray-600 hover:text-gray-800 transition-colors"
                                            onclick="return confirm('¿Estás seguro de eliminar este entrenador?\n\nEsta acción eliminará:\n- Todos sus datos personales\n- Sus asignaciones\n- Su historial\n\nEsta acción NO se puede deshacer.')"
                                            title="Eliminar entrenador permanentemente">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-whistle text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">No hay entrenadores registrados</p>
                                    <p class="text-gray-400 text-sm mt-2">Comienza agregando el primer entrenador al sistema</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Vista de Jugadores del Entrenador -->
    <div x-show="currentView === 'jugadores'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="currentView = 'main'" 
                                class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-users text-purple-600 mr-2"></i>
                            Jugadores Asignados
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <template x-if="jugadoresEntrenador.length === 0">
                    <div class="text-center py-12">
                        <i class="fas fa-user-slash text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay jugadores asignados</h3>
                        <p class="text-gray-500 mb-4">Este entrenador aún no tiene jugadores asignados</p>
                        <button @click="currentView = 'main'" 
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Volver a Entrenadores
                        </button>
                    </div>
                </template>
                
                <template x-if="jugadoresEntrenador.length > 0">
                    <div>
                        <!-- Tabla de jugadores -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jugador</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disciplina</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Entrenamiento</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <template x-for="jugador in jugadoresEntrenador" :key="jugador.id">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <template x-if="jugador.jugador?.foto_perfil">
                                                        <img :src="'/storage/' + jugador.jugador.foto_perfil" 
                                                            alt="Foto de perfil" 
                                                            class="w-10 h-10 rounded-full object-cover">
                                                    </template>
                                                    <template x-if="!jugador.jugador?.foto_perfil">
                                                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                            <span x-text="jugador.jugador?.name?.charAt(0) || 'J'"></span>
                                                        </div>
                                                    </template>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-medium text-gray-900" x-text="jugador.jugador?.name || 'Sin nombre'"></div>
                                                        <div class="text-xs text-gray-500" x-text="'ID: ' + jugador.jugador_id"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800" x-text="jugador.disciplina"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" x-text="jugador.categoria"></span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600" x-text="jugador.tipo_entrenamiento"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600" x-text="jugador.fecha ? new Date(jugador.fecha).toLocaleDateString() : 'Sin fecha'"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <!-- Ver Detalles -->
                                                    <button @click="currentView = 'detalles'; jugadorSeleccionado = jugador"
                                                            class="text-green-600 hover:text-green-800 transition-colors" 
                                                            title="Ver detalles del jugador">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    <!-- Editar Inscripción -->
                                                    <button @click="currentView = 'editar'; inscripcionEditar = jugador; disciplina = jugador.disciplina"
                                                            class="text-blue-600 hover:text-blue-800 transition-colors" 
                                                            title="Editar inscripción">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    
                                                    <!-- Quitar Jugador -->
                                                    <button @click="if(confirm('¿Estás seguro de quitar este jugador del entrenador?')) { quitarJugador(jugador.id) }"
                                                            class="text-red-600 hover:text-red-800 transition-colors" 
                                                            title="Quitar jugador">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Botón volver -->
                        <div class="mt-6 flex justify-center">
                            <button @click="currentView = 'main'" 
                                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Volver a Entrenadores
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
        <!-- Vista de Detalles del Jugador -->
    <div x-show="currentView === 'detalles'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="currentView = 'jugadores'" 
                                class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-user text-green-600 mr-2"></i>
                            Detalles del Jugador
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <template x-if="jugadorSeleccionado">
                    <div>
                        <!-- Header del jugador -->
                        <div class="flex items-center mb-6">
                            <template x-if="jugadorSeleccionado.jugador?.foto_perfil">
                                <img :src="'/storage/' + jugadorSeleccionado.jugador.foto_perfil" 
                                    alt="Foto de perfil" 
                                    class="w-16 h-16 rounded-full object-cover border-2 border-blue-600">
                            </template>
                            <template x-if="!jugadorSeleccionado.jugador?.foto_perfil">
                                <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-2xl">
                                    <span x-text="jugadorSeleccionado.jugador?.name?.charAt(0) || 'J'"></span>
                                </div>
                            </template>
                            <div class="ml-4 flex-1">
                                <h4 class="text-xl font-semibold text-gray-900" x-text="jugadorSeleccionado.jugador?.name || 'Sin nombre'"></h4>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-layer-group mr-1"></i>
                                        <span x-text="jugadorSeleccionado.categoria"></span>
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-futbol mr-1"></i>
                                        <span x-text="jugadorSeleccionado.disciplina"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información del jugador -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <i class="fas fa-envelope w-5 mr-3 text-blue-500"></i>
                                    <span class="font-medium">Email:</span>
                                </div>
                                <p class="text-gray-900 ml-8" x-text="jugadorSeleccionado.jugador?.email || 'Sin correo'"></p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <i class="fas fa-dumbbell w-5 mr-3 text-green-500"></i>
                                    <span class="font-medium">Tipo de Entrenamiento:</span>
                                </div>
                                <p class="text-gray-900 ml-8" x-text="jugadorSeleccionado.tipo_entrenamiento || 'Regular'"></p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <i class="fas fa-calendar-alt w-5 mr-3 text-purple-500"></i>
                                    <span class="font-medium">Fecha de Inscripción:</span>
                                </div>
                                <p class="text-gray-900 ml-8" x-text="jugadorSeleccionado.fecha ? new Date(jugadorSeleccionado.fecha).toLocaleDateString() : 'Sin fecha'"></p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <i class="fas fa-info-circle w-5 mr-3 text-yellow-500"></i>
                                    <span class="font-medium">Estado:</span>
                                </div>
                                <p class="text-gray-900 ml-8">
                                    <span :class="jugadorSeleccionado.estado === 'activa' ? 'text-green-600' : 'text-red-600'" 
                                          x-text="jugadorSeleccionado.estado || 'Activa'"></span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Observaciones -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-6" x-show="jugadorSeleccionado.observaciones">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-sticky-note w-5 mr-3 text-indigo-500"></i>
                                <span class="font-medium">Observaciones:</span>
                            </div>
                            <p class="text-gray-900 ml-8" x-text="jugadorSeleccionado.observaciones || 'Sin observaciones'"></p>
                        </div>
                        
                        <!-- Botón volver -->
                        <div class="flex justify-center">
                            <button @click="currentView = 'jugadores'" 
                                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Volver a Lista
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Vista de Editar Inscripción -->
    <div x-show="currentView === 'editar'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="currentView = 'jugadores'" 
                                class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-edit text-blue-600 mr-2"></i>
                            Editar Inscripción
                        </h3>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <template x-if="inscripcionEditar">
                    <form :action="`/admin/inscripciones/${inscripcionEditar.id}`" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jugador (solo lectura) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jugador</label>
                                <input type="text" 
                                       :value="inscripcionEditar.jugador?.name || 'Sin nombre'" 
                                       readonly
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
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
                                    <option value="futbol">Fútbol</option>
                                </select>
                            </div>
                            
                            <!-- Categoría -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                                <select name="categoria" 
                                        :value="inscripcionEditar.categoria"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="sub8">Sub-8</option>
                                    <option value="sub12">Sub-12</option>
                                    <option value="sub14">Sub-14</option>
                                    <option value="sub16">Sub-16</option>
                                    <option value="avanzado">Avanzado</option>
                                </select>
                            </div>
                            
                            <!-- Tipo de Entrenamiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Entrenamiento</label>
                                <select name="tipo_entrenamiento" 
                                        :value="inscripcionEditar.tipo_entrenamiento"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="regular">Regular</option>
                                    <option value="personalizado">Personalizado</option>
                                </select>
                            </div>
                            
                            <!-- Fecha -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inscripción</label>
                                <input type="date" 
                                       name="fecha" 
                                       :value="inscripcionEditar.fecha"
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <!-- Observaciones -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                                <textarea name="observaciones" 
                                          rows="3"
                                          :value="inscripcionEditar.observaciones"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                        
                        <!-- Botones -->
                        <div class="flex justify-center gap-4 mt-6">
                            <button type="button" 
                                    @click="currentView = 'jugadores'"
                                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </button>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</div>
<!-- Fin Vista Principal -->

<!-- MODALES - Sistema de Modales con Alpine.js -->
<div x-data="{ 
    currentModal: null,
    openModal(modalId) { this.currentModal = modalId; },
    closeModal() { this.currentModal = null; }
}" 
@open-modal.window="openModal($event.detail.modal)"
@keydown.escape.window="closeModal()">
    <!-- Modales para cada entrenador -->
    @foreach($usuarios->where('role', 'coach') ?? [] as $usuario)
    
    <!-- Modal: Editar Usuario -->
    <div x-show="currentModal === 'editUser{{ $usuario->id }}'" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <!-- Overlay -->
            <div x-show="currentModal === 'editUser{{ $usuario->id }}'"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeModal()"
                 class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
                 
            <!-- Modal Content -->
            <div x-show="currentModal === 'editUser{{ $usuario->id }}'"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                
                <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Header -->
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg sticky top-0 z-10">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Entrenador
                        </h3>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-6 space-y-4">
                        <!-- Información Personal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nombres <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nombres" value="{{ $usuario->nombres ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" 
                                       placeholder="Ingresa los nombres">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Apellido Paterno <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="apellido_paterno" value="{{ $usuario->apellido_paterno ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" 
                                       placeholder="Apellido paterno">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Apellido Materno
                                </label>
                                <input type="text" name="apellido_materno" value="{{ $usuario->apellido_materno ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" 
                                       placeholder="Apellido materno">
                            </div>
                        </div>
                        
                        <!-- Información de Contacto -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ $usuario->email }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" 
                                       required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input type="text" name="telefono" value="{{ $usuario->telefono }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                       placeholder="Número de teléfono">
                            </div>
                        </div>
                        
                        <!-- Información Adicional -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">               
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Fecha de Nacimiento
                                </label>
                                <input type="date" name="fecha_nacimiento" 
                                       value="{{ $usuario->fecha_nacimiento ? \Carbon\Carbon::parse($usuario->fecha_nacimiento)->format('Y-m-d') : '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end space-x-3 sticky bottom-0">
                        <button type="button" @click="closeModal()" 
                                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-1"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal: Cambiar Contraseña -->
    <div x-show="currentModal === 'changePassword{{ $usuario->id }}'" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Overlay -->
            <div x-show="currentModal === 'changePassword{{ $usuario->id }}'"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeModal()"
                 class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            <!-- Modal Content -->
            <div x-show="currentModal === 'changePassword{{ $usuario->id }}'"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                
                <form method="POST" action="{{ route('usuarios.password', $usuario->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Header -->
                    <div class="bg-yellow-500 text-white px-6 py-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-key mr-2"></i>
                            Cambiar Contraseña
                        </h3>
                    </div>
                    <!-- Body -->
                    <div class="p-6 space-y-4">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 mb-4">
                            <p class="text-sm text-yellow-700">
                                <i class="fas fa-info-circle mr-1"></i>
                                Cambiando contraseña para: <strong>{{ $usuario->name }}</strong>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                            <input type="password" name="password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                                   minlength="8" required>
                            <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" 
                                   minlength="8" required>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end space-x-3">
                        <button type="button" @click="closeModal()" 
                                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal: Compartir Credenciales -->
    <div x-show="currentModal === 'shareCredentials{{ $usuario->id }}'" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Overlay -->
            <div x-show="currentModal === 'shareCredentials{{ $usuario->id }}'"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeModal()"
                 class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            
            <!-- Modal Content -->
            <div x-show="currentModal === 'shareCredentials{{ $usuario->id }}'"
                 x-data="{ 
                    password: '{{ $usuario->password_plain ?? 'Usuario123' }}', 
                    sending: false,
                    async sendCredentials() {
                        if (!this.password) {
                            alert('⚠️ Por favor ingresa una contraseña');
                            return;
                        }
                        this.sending = true;
                        try {
                            const response = await fetch('/enviar-credenciales', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    usuario_id: {{ $usuario->id }},
                                    password: this.password
                                })
                            });
                            const data = await response.json();
                            if (response.ok) {
                                alert('✅ ' + (data.message || 'Credenciales enviadas correctamente'));
                                $dispatch('open-modal', { modal: null });
                            } else {
                                alert('❌ Error: ' + (data.message || 'Error al enviar'));
                            }
                        } catch (e) {
                            console.error(e);
                            alert('❌ Error de conexión al enviar el correo');
                        } finally {
                            this.sending = false;
                        }
                    }
                 }"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                
                <!-- Header -->
                <div class="bg-indigo-600 text-white px-6 py-4 rounded-t-lg">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="fas fa-share-alt mr-2"></i>
                        Compartir Credenciales
                    </h3>
                </div>
                <!-- Body -->
                <div class="p-6 space-y-4">
                    <div class="bg-indigo-50 border-l-4 border-indigo-400 p-3 mb-4">
                        <p class="text-sm text-indigo-700">
                            <i class="fas fa-info-circle mr-1"></i>
                            Credenciales de acceso para <strong>{{ $usuario->name }}</strong>
                        </p>
                    </div>
                    <div class="space-y-3">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Nombre</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" value="{{ $usuario->name }}" readonly 
                                       class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                                <button type="button" onclick="navigator.clipboard.writeText('{{ $usuario->name }}')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                    <i class="fas fa-copy text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Email / Usuario</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" value="{{ $usuario->email }}" readonly 
                                       class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                                <button type="button" onclick="navigator.clipboard.writeText('{{ $usuario->email }}')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                    <i class="fas fa-copy text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Teléfono -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Teléfono</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" value="{{ $usuario->telefono ?? 'No especificado' }}" readonly 
                                       class="flex-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                                @if($usuario->telefono)
                                <button type="button" onclick="navigator.clipboard.writeText('{{ $usuario->telefono }}')" 
                                        class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                    <i class="fas fa-copy text-gray-600"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        <!-- Contraseña para Enviar -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Contraseña para Enviar</label>
                            <div class="flex items-center space-x-2">
                                <input type="text" x-model="password" 
                                       class="flex-1 px-3 py-2 bg-white border border-yellow-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                       placeholder="Escribe la contraseña...">
                                <button type="button" @click="navigator.clipboard.writeText(password)" 
                                        class="px-3 py-2 bg-yellow-100 hover:bg-yellow-200 rounded-lg transition"
                                        title="Copiar contraseña">
                                    <i class="fas fa-copy text-yellow-700"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-edit text-yellow-500 mr-1"></i>
                                Puedes editar esta contraseña antes de enviarla.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end space-x-3">
                    <button type="button" @click="closeModal()" 
                            class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cerrar
                    </button>
                    <button type="button" 
                            @click="sendCredentials()"
                            :disabled="sending"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <template x-if="!sending">
                            <span><i class="fas fa-envelope mr-1"></i> Enviar por Email</span>
                        </template>
                        <template x-if="sending">
                            <span><i class="fas fa-spinner fa-spin mr-1"></i> Enviando...</span>
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- Estilos adicionales para x-cloak -->
<style>
    [x-cloak] { display: none !important; }
</style>