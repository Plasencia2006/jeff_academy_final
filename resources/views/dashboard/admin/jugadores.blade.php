<!-- JUGADORES - Gestión de Jugadores -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user text-orange-600 mr-3"></i>
            Gestión de Jugadores
        </h1>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100" x-data="{
        buscarJugador: '',
        filtroEstado: '',
        filtrarJugadores() {
            const busqueda = this.buscarJugador.toLowerCase();
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
            this.buscarJugador = '';
            this.filtroEstado = '';
            this.filtrarJugadores();
        }
    }">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Jugador</label>
                    <input type="text" x-model="buscarJugador" @input="filtrarJugadores()"
                            placeholder="Nombre del jugador..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select x-model="filtroEstado" @change="filtrarJugadores()"
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

    <!-- Tabla de Jugadores Registrados -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-users text-orange-600 mr-2"></i>
                Jugadores Registrados
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
                    @forelse($usuarios->where('role', 'player') ?? [] as $usuario)
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
                                    title="Editar jugador">
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

                                <!-- Activar / Desactivar -->
                                <form action="{{ route('usuarios.toggle', $usuario->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    @if ($usuario->estado == 'activo')
                                        <button type="submit" 
                                            class="text-green-600 hover:text-green-800 transition-colors"
                                            onclick="return confirm('¿Desactivar este jugador?')"
                                            title="Activo - Click para desactivar">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    @else
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition-colors"
                                            onclick="return confirm('¿Activar este jugador?')"
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
                                        onclick="return confirm('¿Estás seguro de eliminar este jugador?\n\nEsta acción eliminará:\n- Todos sus datos personales\n- Sus inscripciones\n- Su historial\n\nEsta acción NO se puede deshacer.')"
                                        title="Eliminar jugador permanentemente">
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
                                <i class="fas fa-user text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg">No hay jugadores registrados</p>
                                <p class="text-gray-400 text-sm mt-2">Comienza agregando el primer jugador al sistema</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODALES - Sistema de Modales con Alpine.js -->
<div x-data="{ 
    currentModal: null,
    openModal(modalId) { this.currentModal = modalId; },
    closeModal() { this.currentModal = null; }
}" 
@open-modal.window="openModal($event.detail.modal)"
@keydown.escape.window="closeModal()">
    <!-- Modales para cada jugador -->
    @foreach($usuarios->where('role', 'player') ?? [] as $usuario)
    
    <!-- Modal: Editar Usuario -->
    <div x-show="currentModal === 'editUser{{ $usuario->id }}'" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
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
                 class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                
                <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Header -->
                    <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
                        <h3 class="text-lg font-semibold flex items-center">
                            <i class="fas fa-edit mr-2"></i>
                            Editar Jugador
                        </h3>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
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

                    <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end space-x-3">
                        <button type="button" @click="closeModal()" 
                                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
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