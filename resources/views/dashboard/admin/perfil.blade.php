<!-- PERFIL DEL ADMINISTRADOR -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-circle text-teal-700 mr-3"></i>
            Mi Perfil - Administrador
        </h1>
    </div>



    <!-- Formulario de Perfil -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <form id="perfilAdminForm" method="POST" action="{{ route('admin.perfil.update') }}"
            enctype="multipart/form-data"
            x-data="{ 
                showModal: false, 
                tempImage: '{{ Auth::user()->foto_perfil ? asset('storage/' . Auth::user()->foto_perfil) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=200' }}', 
                currentImage: '{{ Auth::user()->foto_perfil ? asset('storage/' . Auth::user()->foto_perfil) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&size=200' }}' 
            }">
            @csrf
            @method('PUT')


            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Foto de Perfil -->
                    <div class="text-center">
                        <div class="relative inline-block">
                            <img :src="currentImage"
                                alt="Foto de Perfil"
                                class="w-48 h-48 rounded-full object-cover border-4 border-gray-200 shadow-lg">
                            <button type="button"
                                @click.stop="showModal = true; tempImage = currentImage"
                                class="absolute bottom-2 right-2 w-12 h-12 bg-green-700 hover:bg-green-800 text-white rounded-full shadow-lg transition-colors flex items-center justify-center">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">
                            JPG, PNG o GIF (máx. 2MB)
                        </p>


                        <!-- Modal para modificar foto -->
                        <div
                            x-show="showModal"
                            x-cloak
                            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
                            @click.self="showModal = false; tempImage = currentImage; if($refs.fileInput) $refs.fileInput.value = ''"
                            @keydown.escape.window="showModal = false; tempImage = currentImage; if($refs.fileInput) $refs.fileInput.value = ''">
                            <div class="bg-white rounded-xl shadow-xl max-w-md w-full" @click.stop>
                                <div class="bg-teal-700 text-white p-4 rounded-t-xl flex items-center justify-between">
                                    <h5 class="text-lg font-semibold">
                                        <i class="fas fa-camera mr-2"></i>Modificar Foto de Perfil
                                    </h5>
                                    <button
                                        type="button"
                                        class="text-white hover:text-gray-200"
                                        @click="showModal = false; tempImage = currentImage; if($refs.fileInput) $refs.fileInput.value = ''">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                                <div class="p-6">
                                    <div class="text-center mb-4">
                                        <img
                                            :src="tempImage"
                                            alt="Foto de perfil"
                                            class="w-40 h-40 rounded-full object-cover border-4 border-gray-200 mx-auto">
                                    </div>


                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                        <ul class="text-sm text-blue-800 space-y-1">
                                            <li>• El tamaño de la foto no debe superar los <strong>2 MB</strong>.</li>
                                            <li>• Formatos permitidos: <strong>JPG, PNG, GIF</strong>.</li>
                                        </ul>
                                    </div>


                                    <div class="mb-4">
                                        <label class="block w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-3 px-4 rounded-lg cursor-pointer text-center transition-colors">
                                            <i class="fas fa-plus mr-2"></i>Seleccionar Foto
                                            <input
                                                type="file"
                                                name="foto_perfil"
                                                accept="image/*"
                                                class="hidden"
                                                x-ref="fileInput"
                                                @change="
                                                    const file = $event.target.files[0];
                                                    if (file) {
                                                        if (file.size > 2 * 1024 * 1024) {
                                                            alert('La imagen no debe superar los 2MB');
                                                            $refs.fileInput.value = '';
                                                            return;
                                                        }
                                                        if (!file.type.match('image.*')) {
                                                            alert('Solo se permiten archivos de imagen (JPG, PNG, GIF)');
                                                            $refs.fileInput.value = '';
                                                            return;
                                                        }
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            tempImage = e.target.result;
                                                        };
                                                        reader.readAsDataURL(file);
                                                    }
                                                ">
                                        </label>
                                        <p class="text-sm text-gray-500 text-center mt-2">
                                            JPG, PNG o GIF (máx. 2MB)
                                        </p>
                                    </div>


                                    <button
                                        type="button"
                                        @click="currentImage = tempImage; showModal = false"
                                        class="w-full bg-teal-700 hover:bg-teal-800 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                                        <i class="fas fa-save mr-2"></i>Actualizar Vista Previa
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Información Personal -->
                    <div class="md:col-span-2 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                                <input type="text" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                    name="name" 
                                    value="{{ Auth::user()->name }}" 
                                    required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                    name="email" 
                                    value="{{ Auth::user()->email }}" 
                                    required>
                            </div>
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                            <input type="text" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" 
                                value="{{ ucfirst(Auth::user()->role) }}" 
                                disabled>
                            <p class="text-sm text-gray-500 mt-1">El rol no puede ser modificado</p>
                        </div>


                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Estado de la Cuenta</label>
                            <input type="text" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" 
                                value="{{ ucfirst(Auth::user()->estado) }}" 
                                disabled>
                            <p class="text-sm text-gray-500 mt-1">El estado no puede ser modificado</p>
                        </div>
                    </div>
                </div>


                <!-- Cambio de Contraseña -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-lock text-teal-700 mr-2"></i>
                        Cambiar Contraseña
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña Actual</label>
                            <input type="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                name="current_password">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                            <input type="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                name="password">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                            <input type="password" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-transparent" 
                                name="password_confirmation">
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Deja los campos en blanco si no deseas cambiar tu contraseña</p>
                </div>


                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
