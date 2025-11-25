<!-- Perfil del Jugador -->
<div class="space-y-6" x-data="profileData()">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user text-blue-600 mr-3"></i>
            Mi Perfil
        </h1>
        <button @click="showModal = true; modalType = 'editProfile'" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <i class="fas fa-edit"></i>
            <span>Editar Perfil</span>
        </button>
    </div>

    <!-- Información principal del perfil -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 sm:p-6">
            <div class="flex flex-col items-center space-y-4">
                <!-- Foto de perfil -->
                <div class="flex-shrink-0">
                    <div class="relative">
                        @php
                            $srcPerfil = $perfil->foto_url;
                        @endphp
                        <img :src="previewImage || '{{ $srcPerfil }}'" 
                            alt="Foto del jugador" 
                            class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-full object-cover border-4 border-blue-100">
                        <button @click="showModal = true; modalType = 'updateImage'" 
                                class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white w-8 h-8 flex items-center justify-center rounded-full shadow-lg transition-colors">
                            <i class="fas fa-camera text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Información básica -->
                <div class="w-full max-w-3xl">
                    <div class="text-center space-y-2">
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 break-words">
                            {{ Auth::user()->name }}
                        </h2>
                        <div class="flex items-center justify-center text-gray-600 text-sm">
                            <i class="fas fa-envelope mr-2 flex-shrink-0 text-xs"></i>
                            <span class="break-all">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Activo
                            </span>
                        </div>
                    </div>

                    <!-- Datos deportivos en grid compacto -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 mt-4">
                        <div class="text-center p-2.5 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <p class="text-lg sm:text-xl font-bold text-blue-600 break-words">
                                {{ $perfil->numero_jersey ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-600 mt-0.5">Jersey</p>
                        </div>
                        <div class="text-center p-2.5 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <p class="text-lg sm:text-xl font-bold text-green-600 break-words">
                                {{ $perfil->posicion ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-600 mt-0.5">Posición</p>
                        </div>
                        <div class="text-center p-2.5 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <p class="text-lg sm:text-xl font-bold text-purple-600 break-words">
                                {{ $perfil->categoria ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-600 mt-0.5">Categoría</p>
                        </div>
                        <div class="text-center p-2.5 sm:p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <p class="text-lg sm:text-xl font-bold text-yellow-600 break-words">
                                {{ $perfil->edad ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-600 mt-0.5">Edad</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Información personal -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-id-card text-blue-600 mr-2"></i>
                    Información Personal
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Altura:</span>
                    <span class="font-medium text-gray-900">{{ $perfil->altura ? $perfil->altura . ' cm' : 'No especificado' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Peso:</span>
                    <span class="font-medium text-gray-900">{{ $perfil->peso ? $perfil->peso . ' kg' : 'No especificado' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Edad:</span>
                    <span class="font-medium text-gray-900">{{ $perfil->edad ?? 'No especificado' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Teléfono:</span>
                    <span class="font-medium text-gray-900">{{ $perfil->telefono ?? 'No especificado' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Estado:</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Activo
                    </span>
                </div>
            </div>
        </div>

        <!-- Información deportiva -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-futbol text-green-600 mr-2"></i>
                    Información Deportiva
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Posición:</span>
                    <span class="font-medium text-gray-900">{{ $perfil->posicion ?? 'No especificado' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Categoría:</span>
                    <span class="font-medium text-gray-900">{{ $perfil->categoria ?? 'No especificado' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Número de Jersey:</span>
                    <span class="font-medium text-gray-900">{{ $perfil->numero_jersey ?? 'No asignado' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Fecha de Registro:</span>
                    <span class="font-medium text-gray-900">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Biografía y contacto -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Biografía -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-user-edit text-purple-600 mr-2"></i>
                    Biografía
                </h3>
            </div>
            <div class="p-6">
                @if($perfil->biografia)
                    <p class="text-gray-700 leading-relaxed">{{ $perfil->biografia }}</p>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-edit text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500 mb-4">No has agregado una biografía</p>
                        <button @click="showModal = true; modalType = 'editProfile'" 
                                class="text-blue-600 hover:text-blue-700 font-medium">
                            Agregar biografía
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Contacto y enlaces -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-address-book text-yellow-600 mr-2"></i>
                    Contacto y Dirección
                </h3>
            </div>
            <div class="p-6 space-y-4">
                @if($perfil->telefono || $perfil->direccion)
                    @if($perfil->telefono)
                        <div class="py-2 border-b border-gray-100">
                            <h4 class="font-medium text-gray-900 mb-1 flex items-center">
                                <i class="fas fa-phone text-blue-600 mr-2"></i>
                                Teléfono
                            </h4>
                            <p class="text-gray-700">{{ $perfil->telefono }}</p>
                        </div>
                    @endif
                    
                    @if($perfil->direccion)
                        <div class="py-2">
                            <h4 class="font-medium text-gray-900 mb-1 flex items-center">
                                <i class="fas fa-map-marker-alt text-red-600 mr-2"></i>
                                Dirección
                            </h4>
                            <p class="text-gray-700">{{ $perfil->direccion }}</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-address-book text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500 mb-4">No has agregado información de contacto</p>
                        <button @click="showModal = true; modalType = 'editProfile'" 
                                class="text-blue-600 hover:text-blue-700 font-medium">
                            Agregar información
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para actualizar imagen de perfil -->
    <div x-show="showModal && modalType === 'updateImage'" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay de fondo -->
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="showModal = false"></div>

            <!-- Centrar modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Contenido del modal -->
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <!-- Encabezado del modal -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                            Seleccionar imagen de perfil
                        </h3>
                        <button @click="showModal = false" 
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Opciones de imagen -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Opciones de imagen
                        </label>
                        
                        <!-- Dropdown de opciones -->
                        <div x-data="{ openDropdown: false, selectedOption: 'Cargar una imagen' }" 
                             class="relative">
                            <button @click="openDropdown = !openDropdown" 
                                    type="button"
                                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-left flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <span x-text="selectedOption" class="text-gray-900"></span>
                                <i class="fas fa-chevron-up text-gray-400 transition-transform duration-200" 
                                   :class="{ 'rotate-180': !openDropdown }"></i>
                            </button>

                            <!-- Opciones del dropdown -->
                            <div x-show="openDropdown" 
                                 @click.away="openDropdown = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden">
                                
                                <!-- Opción: Cargar una imagen -->
                                <label class="block px-4 py-3 hover:bg-blue-600 hover:text-white cursor-pointer transition-colors">
                                    <input type="radio" 
                                           name="imageOption" 
                                           value="upload" 
                                           class="hidden" 
                                           @change="selectedOption = 'Cargar una imagen'; openDropdown = false; $refs.fileInput.click()">
                                    <span class="flex items-center">
                                        <i class="fas fa-upload mr-3"></i>
                                        Cargar una imagen
                                    </span>
                                </label>

                                <!-- Opción: Hacer una foto -->
                                <label class="block px-4 py-3 hover:bg-blue-600 hover:text-white cursor-pointer transition-colors border-t border-gray-100">
                                    <input type="radio" 
                                           name="imageOption" 
                                           value="camera" 
                                           class="hidden" 
                                           @change="selectedOption = 'Hacer una foto'; openDropdown = false; activateCamera()">
                                    <span class="flex items-center">
                                        <i class="fas fa-camera mr-3"></i>
                                        Hacer una foto
                                    </span>
                                </label>

                                <!-- Opción: Desde Gravatar -->
                                <label class="block px-4 py-3 hover:bg-blue-600 hover:text-white cursor-pointer transition-colors border-t border-gray-100">
                                    <input type="radio" 
                                           name="imageOption" 
                                           value="gravatar" 
                                           class="hidden" 
                                           @change="selectedOption = 'Desde Gravatar'; openDropdown = false; loadGravatar()">
                                    <span class="flex items-center">
                                        <i class="fas fa-user-circle mr-3"></i>
                                        Desde Gravatar
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Input de archivo oculto -->
                    <input type="file" 
                           x-ref="fileInput" 
                           accept="image/*" 
                           class="hidden" 
                           @change="handleFileUpload($event)">

                    <!-- Vista previa de la imagen -->
                    <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                        <img :src="previewImage || '{{ $srcPerfil }}'" 
                             alt="Vista previa" 
                             class="mx-auto w-40 h-40 rounded-full object-cover border-4 border-gray-200 mb-4">
                        
                        <p class="text-blue-500 font-medium cursor-pointer hover:text-blue-600" 
                           @click="$refs.fileInput.click()">
                            elegir una imagen
                        </p>
                    </div>
                </div>

                <!-- Footer del modal -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="updateProfileImage()"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Guardar
                    </button>
                    <button type="button" 
                            @click="showModal = false; resetModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar perfil -->
    <div x-show="showModal && modalType === 'editProfile'" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay de fondo -->
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="showModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Contenido del modal -->
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                
                <form @submit.prevent="updateProfile()">
                    <!-- Encabezado -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Editar Perfil
                            </h3>
                            <button type="button" @click="showModal = false" 
                                    class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <!-- Formulario -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <!-- Email (Solo lectura - bloqueado) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email 
                                    <span class="text-xs text-gray-500">(Asignado por el administrador)</span>
                                </label>
                                <div class="relative">
                                    <input type="email" 
                                        x-model="formData.email"
                                        disabled
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                                <input type="tel" 
                                       x-model="formData.telefono"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Fecha de Nacimiento (Solo lectura) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Fecha de Nacimiento
                                    <span class="text-xs text-gray-500">(Asignada por el administrador)</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                        x-model="formData.fecha_nacimiento"
                                        disabled
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Altura -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Altura (cm)</label>
                                <input type="number" 
                                       x-model="formData.altura"
                                       step="0.01"
                                       placeholder="170"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Peso -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Peso (kg)</label>
                                <input type="number" 
                                       x-model="formData.peso"
                                       step="0.01"
                                       placeholder="70"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Posición -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Posición</label>
                                <select x-model="formData.posicion"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Seleccionar</option>
                                    <option value="Portero">Portero</option>
                                    <option value="Defensa">Defensa</option>
                                    <option value="Mediocampista">Mediocampista</option>
                                    <option value="Delantero">Delantero</option>
                                </select>
                            </div>

                            <!-- Número de Jersey -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Jersey</label>
                                <input type="text" 
                                       x-model="formData.numero_jersey"
                                       maxlength="3"
                                       placeholder="10"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Categoría (Solo lectura) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Categoría
                                    <span class="text-xs text-gray-500">(Asignada por el administrador)</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                        x-model="formData.categoria"
                                        disabled
                                        readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input type="text" 
                                       x-model="formData.direccion"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Biografía -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Biografía</label>
                                <textarea x-model="formData.biografia"
                                          rows="4"
                                          maxlength="1000"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span x-text="formData.biografia ? formData.biografia.length : 0"></span>/1000 caracteres
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer del modal -->
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Guardar Cambios
                        </button>
                        <button type="button" 
                                @click="showModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estilos CSS adicionales -->
<style>
    [x-cloak] { 
        display: none !important; 
    }

    .rotate-180 {
        transform: rotate(180deg);
    }
</style>

<!-- JavaScript Alpine.js -->
<script>
function profileData() {
    return {
        showModal: false,
        modalType: '',
        selectedFile: null,
        previewImage: null,
        formData: {
            email: '{{ Auth::user()->email }}',
            telefono: '{{ $perfil->telefono }}',
            fecha_nacimiento: '{{ $perfil->fecha_nacimiento ? $perfil->fecha_nacimiento->format("Y-m-d") : "" }}',
            altura: '{{ $perfil->altura }}',
            peso: '{{ $perfil->peso }}',
            posicion: '{{ $perfil->posicion }}',
            numero_jersey: '{{ $perfil->numero_jersey }}',
            categoria: '{{ $perfil->categoria }}',
            direccion: '{{ $perfil->direccion }}',
            biografia: '{{ $perfil->biografia }}'
        },
        
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                // Validar tamaño (máx 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('La imagen es demasiado grande. Tamaño máximo: 5MB');
                    return;
                }
                
                // Validar tipo
                if (!file.type.startsWith('image/')) {
                    alert('Por favor selecciona un archivo de imagen válido');
                    return;
                }
                
                this.selectedFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewImage = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        activateCamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                alert('Función de cámara en desarrollo. Por favor usa "Cargar una imagen".');
            } else {
                alert('Tu navegador no soporta acceso a cámara');
            }
        },
        
        loadGravatar() {
            const email = '{{ Auth::user()->email }}';
            const hash = this.md5(email.toLowerCase().trim());
            const gravatarUrl = `https://www.gravatar.com/avatar/${hash}?s=400&d=mp`;
            this.previewImage = gravatarUrl;
            this.selectedFile = null; // Limpiar archivo seleccionado
        },
        
        updateProfileImage() {
            const formData = new FormData();
            
            if (this.selectedFile) {
                formData.append('imagen', this.selectedFile);
            } else if (this.previewImage && this.previewImage.includes('gravatar')) {
                formData.append('gravatar_url', this.previewImage);
            } else {
                alert('Por favor selecciona una imagen');
                return;
            }
            
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');
            
            fetch('{{ route("player.update-image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Imagen actualizada correctamente');
                    location.reload();
                } else {
                    alert(data.message || 'Error al actualizar la imagen');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la imagen');
            });
        },
        
        updateProfile() {
            // Crear copia de formData sin el email
            const dataToSend = { ...this.formData };
            delete dataToSend.email; // Eliminar email del envío
            
            fetch('{{ route("player.update-profile") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    ...dataToSend,
                    _method: 'PUT'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Perfil actualizado correctamente');
                    location.reload();
                } else {
                    alert(data.message || 'Error al actualizar el perfil');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el perfil');
            });
        },

        
        resetModal() {
            this.previewImage = null;
            this.selectedFile = null;
        },
        
        md5(string) {
            function md5cycle(x, k) {
                var a = x[0], b = x[1], c = x[2], d = x[3];
                a = ff(a, b, c, d, k[0], 7, -680876936);
                d = ff(d, a, b, c, k[1], 12, -389564586);
                c = ff(c, d, a, b, k[2], 17, 606105819);
                b = ff(b, c, d, a, k[3], 22, -1044525330);
                a = ff(a, b, c, d, k[4], 7, -176418897);
                d = ff(d, a, b, c, k[5], 12, 1200080426);
                c = ff(c, d, a, b, k[6], 17, -1473231341);
                b = ff(b, c, d, a, k[7], 22, -45705983);
                a = ff(a, b, c, d, k[8], 7, 1770035416);
                d = ff(d, a, b, c, k[9], 12, -1958414417);
                c = ff(c, d, a, b, k[10], 17, -42063);
                b = ff(b, c, d, a, k[11], 22, -1990404162);
                a = ff(a, b, c, d, k[12], 7, 1804603682);
                d = ff(d, a, b, c, k[13], 12, -40341101);
                c = ff(c, d, a, b, k[14], 17, -1502002290);
                b = ff(b, c, d, a, k[15], 22, 1236535329);
                a = gg(a, b, c, d, k[1], 5, -165796510);
                d = gg(d, a, b, c, k[6], 9, -1069501632);
                c = gg(c, d, a, b, k[11], 14, 643717713);
                b = gg(b, c, d, a, k[0], 20, -373897302);
                a = gg(a, b, c, d, k[5], 5, -701558691);
                d = gg(d, a, b, c, k[10], 9, 38016083);
                c = gg(c, d, a, b, k[15], 14, -660478335);
                b = gg(b, c, d, a, k[4], 20, -405537848);
                a = gg(a, b, c, d, k[9], 5, 568446438);
                d = gg(d, a, b, c, k[14], 9, -1019803690);
                c = gg(c, d, a, b, k[3], 14, -187363961);
                b = gg(b, c, d, a, k[8], 20, 1163531501);
                a = gg(a, b, c, d, k[13], 5, -1444681467);
                d = gg(d, a, b, c, k[2], 9, -51403784);
                c = gg(c, d, a, b, k[7], 14, 1735328473);
                b = gg(b, c, d, a, k[12], 20, -1926607734);
                a = hh(a, b, c, d, k[5], 4, -378558);
                d = hh(d, a, b, c, k[8], 11, -2022574463);
                c = hh(c, d, a, b, k[11], 16, 1839030562);
                b = hh(b, c, d, a, k[14], 23, -35309556);
                a = hh(a, b, c, d, k[1], 4, -1530992060);
                d = hh(d, a, b, c, k[4], 11, 1272893353);
                c = hh(c, d, a, b, k[7], 16, -155497632);
                b = hh(b, c, d, a, k[10], 23, -1094730640);
                a = hh(a, b, c, d, k[13], 4, 681279174);
                d = hh(d, a, b, c, k[0], 11, -358537222);
                c = hh(c, d, a, b, k[3], 16, -722521979);
                b = hh(b, c, d, a, k[6], 23, 76029189);
                a = hh(a, b, c, d, k[9], 4, -640364487);
                d = hh(d, a, b, c, k[12], 11, -421815835);
                c = hh(c, d, a, b, k[15], 16, 530742520);
                b = hh(b, c, d, a, k[2], 23, -995338651);
                a = ii(a, b, c, d, k[0], 6, -198630844);
                d = ii(d, a, b, c, k[7], 10, 1126891415);
                c = ii(c, d, a, b, k[14], 15, -1416354905);
                b = ii(b, c, d, a, k[5], 21, -57434055);
                a = ii(a, b, c, d, k[12], 6, 1700485571);
                d = ii(d, a, b, c, k[3], 10, -1894986606);
                c = ii(c, d, a, b, k[10], 15, -1051523);
                b = ii(b, c, d, a, k[1], 21, -2054922799);
                a = ii(a, b, c, d, k[8], 6, 1873313359);
                d = ii(d, a, b, c, k[15], 10, -30611744);
                c = ii(c, d, a, b, k[6], 15, -1560198380);
                b = ii(b, c, d, a, k[13], 21, 1309151649);
                a = ii(a, b, c, d, k[4], 6, -145523070);
                d = ii(d, a, b, c, k[11], 10, -1120210379);
                c = ii(c, d, a, b, k[2], 15, 718787259);
                b = ii(b, c, d, a, k[9], 21, -343485551);
                x[0] = add32(a, x[0]);
                x[1] = add32(b, x[1]);
                x[2] = add32(c, x[2]);
                x[3] = add32(d, x[3]);
            }
            function cmn(q, a, b, x, s, t) {
                a = add32(add32(a, q), add32(x, t));
                return add32((a << s) | (a >>> (32 - s)), b);
            }
            function ff(a, b, c, d, x, s, t) {
                return cmn((b & c) | ((~b) & d), a, b, x, s, t);
            }
            function gg(a, b, c, d, x, s, t) {
                return cmn((b & d) | (c & (~d)), a, b, x, s, t);
            }
            function hh(a, b, c, d, x, s, t) {
                return cmn(b ^ c ^ d, a, b, x, s, t);
            }
            function ii(a, b, c, d, x, s, t) {
                return cmn(c ^ (b | (~d)), a, b, x, s, t);
            }
            function md51(s) {
                var n = s.length,
                    state = [1732584193, -271733879, -1732584194, 271733878], i;
                for (i = 64; i <= s.length; i += 64) {
                    md5cycle(state, md5blk(s.substring(i - 64, i)));
                }
                s = s.substring(i - 64);
                var tail = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                for (i = 0; i < s.length; i++)
                    tail[i >> 2] |= s.charCodeAt(i) << ((i % 4) << 3);
                tail[i >> 2] |= 0x80 << ((i % 4) << 3);
                if (i > 55) {
                    md5cycle(state, tail);
                    for (i = 0; i < 16; i++) tail[i] = 0;
                }
                tail[14] = n * 8;
                md5cycle(state, tail);
                return state;
            }
            function md5blk(s) {
                var md5blks = [], i;
                for (i = 0; i < 64; i += 4) {
                    md5blks[i >> 2] = s.charCodeAt(i) + (s.charCodeAt(i + 1) << 8) + (s.charCodeAt(i + 2) << 16) + (s.charCodeAt(i + 3) << 24);
                }
                return md5blks;
            }
            var hex_chr = '0123456789abcdef'.split('');
            function rhex(n) {
                var s = '', j = 0;
                for (; j < 4; j++)
                    s += hex_chr[(n >> (j * 8 + 4)) & 0x0F] + hex_chr[(n >> (j * 8)) & 0x0F];
                return s;
            }
            function hex(x) {
                for (var i = 0; i < x.length; i++)
                    x[i] = rhex(x[i]);
                return x.join('');
            }
            function add32(a, b) {
                return (a + b) & 0xFFFFFFFF;
            }
            return hex(md51(string));
        }
    }
}
</script>
