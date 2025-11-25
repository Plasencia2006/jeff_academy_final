<!-- Centro de Ayuda -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-question-circle text-blue-600 mr-3"></i>
            Centro de Ayuda
        </h1>
        <div class="flex items-center space-x-3">
            <div class="text-sm text-gray-500">
                ¿Necesitas asistencia? Estamos aquí para ayudarte
            </div>
        </div>
    </div>

    <!-- Contacto de Soporte -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Email de Soporte -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-envelope text-green-600 mr-2"></i>
                    Contacto por Email
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-paper-plane text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Envíanos un correo</h4>
                        <p class="text-gray-600 text-sm mb-3">
                            Responderemos tu consulta en un máximo de 24 horas
                        </p>
                        <a href="mailto:{{ $config->email }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                            {{ $config->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teléfono de Soporte -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-phone text-blue-600 mr-2"></i>
                    Contacto Telefónico
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-headset text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Llámanos</h4>
                        <p class="text-gray-600 text-sm mb-3">
                            Estamos disponibles para atenderte
                        </p>
                        <a href="tel:{{ $config->telefono }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                            {{ $config->telefono }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dirección -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-map-marker-alt text-orange-600 mr-2"></i>
                    Ubicación
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-building text-orange-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Visítanos</h4>
                        <p class="text-gray-600 text-sm">
                            {{ $config->direccion }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horario de Atención -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-clock text-purple-600 mr-2"></i>
                    Horario de Atención
                </h3>
            </div>
            <div class="p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Nuestros Horarios</h4>
                        <div class="space-y-1 text-sm text-gray-600">
                            <p><span class="font-medium text-gray-700">Lun-Vie:</span> {{ $config->horario_semana }}</p>
                            <p><span class="font-medium text-gray-700">Sáb:</span> {{ $config->horario_sabado }}</p>
                            <p><span class="font-medium text-gray-700">Dom:</span> {{ $config->horario_domingo }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
