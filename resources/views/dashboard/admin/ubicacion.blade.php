<!-- UBICACION - Gestión de Información de Contacto -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-map-marker-alt text-orange-600 mr-3"></i>
            Información de Contacto
        </h1>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulario de Configuración -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-cog text-orange-600 mr-2"></i>
            Configurar Información de Contacto
        </h3>

        <form method="POST" action="{{ route('admin.configuracion.contacto.update') }}">
            @csrf
            @method('PUT')

            <!-- Información de Ubicación -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                    <i class="fas fa-map-marked-alt text-blue-600 mr-2"></i>
                    Ubicación
                </h4>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección Completa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="direccion" 
                            name="direccion" 
                            value="{{ old('direccion', $config->direccion ?? 'Trujillo, La Libertad - Perú') }}"
                            placeholder="Ej: Trujillo, La Libertad - Perú"
                            required>
                    </div>

                    <div>
                        <label for="mapa_url" class="block text-sm font-medium text-gray-700 mb-2">
                            URL del Mapa de Google Maps
                        </label>
                        <input type="url" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="mapa_url" 
                            name="mapa_url" 
                            value="{{ old('mapa_url', $config->mapa_url ?? 'https://www.google.com/maps?q=Trujillo,Peru&output=embed') }}"
                            placeholder="https://www.google.com/maps?q=...">
                        <p class="text-xs text-gray-500 mt-1">Copia la URL de Google Maps para mostrar la ubicación en el mapa</p>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                    <i class="fas fa-phone text-green-600 mr-2"></i>
                    Contacto
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="telefono" 
                            name="telefono" 
                            value="{{ old('telefono', $config->telefono ?? '+51 921456783') }}"
                            placeholder="+51 999 999 999"
                            required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $config->email ?? 'contacto@jeffacademy.pe') }}"
                            placeholder="contacto@jeffacademy.pe"
                            required>
                    </div>
                </div>
            </div>

            <!-- Horarios de Atención -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                    <i class="fas fa-clock text-purple-600 mr-2"></i>
                    Horarios de Atención
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="horario_semana" class="block text-sm font-medium text-gray-700 mb-2">
                            Lunes a Viernes <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="horario_semana" 
                            name="horario_semana" 
                            value="{{ old('horario_semana', $config->horario_semana ?? '8:00 AM - 8:00 PM') }}"
                            placeholder="8:00 AM - 8:00 PM"
                            required>
                    </div>

                    <div>
                        <label for="horario_sabado" class="block text-sm font-medium text-gray-700 mb-2">
                            Sábado <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="horario_sabado" 
                            name="horario_sabado" 
                            value="{{ old('horario_sabado', $config->horario_sabado ?? '8:00 am - 8:00 pm') }}"
                            placeholder="9:00 AM - 1:00 PM"
                            required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="horario_domingo" class="block text-sm font-medium text-gray-700 mb-2">
                            Domingo
                        </label>
                        <input type="text" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="horario_domingo" 
                            name="horario_domingo" 
                            value="{{ old('horario_domingo', $config->horario_domingo ?? 'Cerrado') }}"
                            placeholder="Cerrado">
                    </div>
                </div>
            </div>

            <!-- Redes Sociales -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center border-b pb-2">
                    <i class="fas fa-share-alt text-indigo-600 mr-2"></i>
                    Redes Sociales
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-facebook text-blue-600"></i> Facebook
                        </label>
                        <input type="url" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="facebook_url" 
                            name="facebook_url" 
                            value="{{ old('facebook_url', $config->facebook_url ?? 'https://facebook.com/jeffacademy') }}"
                            placeholder="https://facebook.com/jeffacademy">
                    </div>

                    <div>
                        <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-twitter text-blue-400"></i> Twitter
                        </label>
                        <input type="url" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="twitter_url" 
                            name="twitter_url" 
                            value="{{ old('twitter_url', $config->twitter_url ?? 'https://twitter.com/jeffacademy') }}"
                            placeholder="https://twitter.com/jeffacademy">
                    </div>

                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-instagram text-pink-600"></i> Instagram
                        </label>
                        <input type="url" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="instagram_url" 
                            name="instagram_url" 
                            value="{{ old('instagram_url', $config->instagram_url ?? 'https://instagram.com/jeffacademy') }}"
                            placeholder="https://instagram.com/jeffacademy">
                    </div>

                    <div>
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-youtube text-red-600"></i> YouTube
                        </label>
                        <input type="url" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            id="youtube_url" 
                            name="youtube_url" 
                            value="{{ old('youtube_url', $config->youtube_url ?? 'https://youtube.com/@jeffacademy') }}"
                            placeholder="https://youtube.com/@jeffacademy">
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="reset" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-undo mr-2"></i>Restablecer
                </button>
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Vista Previa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-eye text-orange-600 mr-2"></i>
            Vista Previa
        </h3>
        <p class="text-sm text-gray-600 mb-4">Esta información se mostrará en la página de contacto y en el footer del sitio web.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Dirección -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-map-marker-alt text-orange-600 mr-2"></i>
                    <h4 class="font-semibold">Dirección</h4>
                </div>
                <p class="text-sm text-gray-600">{{ $config->direccion ?? 'Trujillo, La Libertad - Perú' }}</p>
            </div>

            <!-- Teléfono -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-phone text-green-600 mr-2"></i>
                    <h4 class="font-semibold">Teléfono</h4>
                </div>
                <p class="text-sm text-gray-600">{{ $config->telefono ?? '+51 921456783' }}</p>
            </div>

            <!-- Email -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-envelope text-blue-600 mr-2"></i>
                    <h4 class="font-semibold">Email</h4>
                </div>
                <p class="text-sm text-gray-600">{{ $config->email ?? 'contacto@jeffacademy.pe' }}</p>
            </div>

            <!-- Horario -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-clock text-purple-600 mr-2"></i>
                    <h4 class="font-semibold">Horario</h4>
                </div>
                <p class="text-xs text-gray-600">Lun-Vie: {{ $config->horario_semana ?? '8:00 AM - 8:00 PM' }}</p>
                <p class="text-xs text-gray-600">Sáb: {{ $config->horario_sabado ?? '8:00 am - 8:00 pm' }}</p>
                <p class="text-xs text-gray-600">Dom: {{ $config->horario_domingo ?? 'Cerrado' }}</p>
            </div>
        </div>
    </div>
</div>