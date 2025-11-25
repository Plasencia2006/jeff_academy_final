<!-- USUARIOS - Gestión de Usuarios -->
<div class="space-y-6" x-data="{ 
    tipoUsuario: '', 
    showJugadorSelect: false,
    selectedRegistro: null 
}">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-users text-orange-600 mr-3"></i>
            Gestión de Usuarios
        </h1>
    </div>

    <!-- Formulario de Registro -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-user-plus text-orange-600 mr-2"></i>
            Registrar Nuevo Usuario
        </h3>

        <form id="formUsuario" method="POST" action="{{ route('admin.usuarios.store') }}">
            @csrf

            <!-- Tipo de Usuario -->
            <div class="mb-6">
                <label for="tipoUsuario" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo de Usuario <span class="text-red-500">*</span>
                </label>
                <select class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('tipo_usuario') border-red-500 @enderror" 
                    id="tipoUsuario" 
                    name="tipo_usuario" 
                    x-model="tipoUsuario"
                    @change="showJugadorSelect = (tipoUsuario === 'jugador')"
                    required>
                    <option value="">-- Seleccionar tipo --</option>
                    <option value="jugador" {{ old('tipo_usuario') == 'jugador' ? 'selected' : '' }}>Jugador</option>
                    <option value="entrenador" {{ old('tipo_usuario') == 'entrenador' ? 'selected' : '' }}>Entrenador</option>
                </select>
                @error('tipo_usuario')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Selección de Jugador (solo para tipo Jugador) -->
            <div x-show="showJugadorSelect" x-transition class="mb-6">
                <label for="seleccionarRegistro" class="block text-sm font-medium text-gray-700 mb-2">
                    Seleccionar Jugador <span class="text-red-500">*</span>
                </label>
                
                <!-- Campo de búsqueda -->
                <div class="mb-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="buscadorJugador" 
                            placeholder="Buscar por nombre, apellido o documento...">
                    </div>
                </div>

                <!-- Select de jugadores -->
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('registro_id') border-red-500 @enderror" 
                    id="seleccionarRegistro" 
                    name="registro_id" 
                    size="4" 
                    style="min-height: 150px;">
                    <option value="">-- Selecciona un jugador --</option>
                    @foreach($registros as $registro)
                        <option value="{{ $registro->id }}" 
                            data-search="{{ strtolower($registro->nombres . ' ' . $registro->apellido_paterno . ' ' . $registro->apellido_materno . ' ' . $registro->nro_documento) }}"
                            data-nombres="{{ $registro->nombres }}"
                            data-apellido-paterno="{{ $registro->apellido_paterno }}"
                            data-apellido-materno="{{ $registro->apellido_materno }}"
                            data-email="{{ $registro->email }}"
                            data-telefono="{{ $registro->nro_celular }}"
                            data-fecha-nacimiento="{{ $registro->fecha_nacimiento }}"
                            data-documento="{{ $registro->tipo_documento }} - {{ $registro->nro_documento }}"
                            data-genero="{{ $registro->genero }}"
                            {{ old('registro_id') == $registro->id ? 'selected' : '' }}>
                            {{ $registro->nombres }} {{ $registro->apellido_paterno }} {{ $registro->apellido_materno }} ({{ $registro->tipo_documento }}: {{ $registro->nro_documento }})
                        </option>
                    @endforeach
                </select>
                @error('registro_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Usa el campo de búsqueda para filtrar jugadores</p>
            </div>

            <!-- Información Personal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="nombres" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombres <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nombres') border-red-500 @enderror" 
                        id="nombres" 
                        name="nombres" 
                        placeholder="Ingresa los nombres"
                        value="{{ old('nombres') }}">
                    @error('nombres')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 mb-2">
                        Apellido Paterno <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('apellido_paterno') border-red-500 @enderror" 
                        id="apellido_paterno" 
                        name="apellido_paterno" 
                        placeholder="Ingresa el apellido paterno"
                        value="{{ old('apellido_paterno') }}">
                    @error('apellido_paterno')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="apellido_materno" class="block text-sm font-medium text-gray-700 mb-2">
                        Apellido Materno
                    </label>
                    <input type="text" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('apellido_materno') border-red-500 @enderror" 
                        id="apellido_materno" 
                        name="apellido_materno" 
                        placeholder="Ingresa el apellido materno"
                        value="{{ old('apellido_materno') }}">
                    @error('apellido_materno')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="documentoUsuario" class="block text-sm font-medium text-gray-700 mb-2">
                        Documento de Identidad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('documento') border-red-500 @enderror" 
                        id="documentoUsuario" 
                        name="documento" 
                        placeholder="Ej: DNI 12345678"
                        value="{{ old('documento') }}">
                    @error('documento')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="emailUsuario" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                        id="emailUsuario" 
                        name="email" 
                        placeholder="correo@gmail.com"
                        value="{{ old('email') }}"
                        required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telefonoUsuario" class="block text-sm font-medium text-gray-700 mb-2">
                        Teléfono
                    </label>
                    <input type="tel" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('telefono') border-red-500 @enderror" 
                        id="telefonoUsuario" 
                        name="telefono" 
                        placeholder="+51 999 999 999"
                        value="{{ old('telefono') }}">
                    @error('telefono')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="generoUsuario" class="block text-sm font-medium text-gray-700 mb-2">
                        Género <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('genero') border-red-500 @enderror" 
                        id="generoUsuario" 
                        name="genero">
                        <option value="">-- Seleccionar género --</option>
                        <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                    @error('genero')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fechaNacimiento" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha de Nacimiento
                    </label>
                    <input type="date" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('fecha_nacimiento') border-red-500 @enderror" 
                        id="fechaNacimiento" 
                        name="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento') }}">
                    @error('fecha_nacimiento')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contraseñas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="passwordUsuario" class="block text-sm font-medium text-gray-700 mb-2">
                        Contraseña del Sistema <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                        id="passwordUsuario" 
                        name="password" 
                        placeholder="Mínimo 8 caracteres" 
                        required 
                        minlength="8">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Esta contraseña es para acceder al sistema</p>
                </div>

                <div>
                    <label for="confirmarPassword" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmar Contraseña <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror" 
                        id="confirmarPassword" 
                        name="password_confirmation"
                        placeholder="Repite la contraseña" 
                        required 
                        minlength="8">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botón de Registrar -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors" id="btnRegistrar">
                    <i class="fas fa-user-plus mr-2"></i>Registrar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script para autocompletado y búsqueda -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscadorJugador = document.getElementById('buscadorJugador');
    const seleccionarRegistro = document.getElementById('seleccionarRegistro');
    
    // Función para filtrar jugadores en el select
    if (buscadorJugador && seleccionarRegistro) {
        buscadorJugador.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const options = seleccionarRegistro.querySelectorAll('option');
            
            options.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }
                
                const searchData = option.getAttribute('data-search') || '';
                if (searchData.includes(searchTerm)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });
        
        // Función para autocompletar campos cuando se selecciona un jugador
        seleccionarRegistro.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                // Obtener datos del jugador seleccionado
                const nombres = selectedOption.getAttribute('data-nombres') || '';
                const apellidoPaterno = selectedOption.getAttribute('data-apellido-paterno') || '';
                const apellidoMaterno = selectedOption.getAttribute('data-apellido-materno') || '';
                const email = selectedOption.getAttribute('data-email') || '';
                const telefono = selectedOption.getAttribute('data-telefono') || '';
                const fechaNacimiento = selectedOption.getAttribute('data-fecha-nacimiento') || '';
                const documento = selectedOption.getAttribute('data-documento') || '';
                const genero = selectedOption.getAttribute('data-genero') || '';
                
                // Autocompletar campos del formulario
                document.getElementById('nombres').value = nombres;
                document.getElementById('apellido_paterno').value = apellidoPaterno;
                document.getElementById('apellido_materno').value = apellidoMaterno;
                document.getElementById('emailUsuario').value = email;
                document.getElementById('telefonoUsuario').value = telefono;
                document.getElementById('fechaNacimiento').value = fechaNacimiento;
                document.getElementById('documentoUsuario').value = documento;
                
                // Seleccionar género (eliminar paréntesis si existen y convertir a minúsculas)
                const generoSelect = document.getElementById('generoUsuario');
                if (generoSelect) {
                    // Limpiar el valor del género eliminando paréntesis y espacios, convertir a minúsculas
                    let generoLimpio = genero.replace(/[()]/g, '').trim().toLowerCase();
                    console.log('Género original:', genero);
                    console.log('Género limpio:', generoLimpio);
                    generoSelect.value = generoLimpio;
                    console.log('Género seleccionado en el select:', generoSelect.value);
                }
                
                console.log('✅ Campos autocompletados correctamente');
            } else {
                // Limpiar campos si se deselecciona
                document.getElementById('nombres').value = '';
                document.getElementById('apellido_paterno').value = '';
                document.getElementById('apellido_materno').value = '';
                document.getElementById('emailUsuario').value = '';
                document.getElementById('telefonoUsuario').value = '';
                document.getElementById('fechaNacimiento').value = '';
                document.getElementById('documentoUsuario').value = '';
                document.getElementById('generoUsuario').value = '';
            }
        });
    }
});
</script>