<!-- REPORTES -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-chart-bar text-orange-600 mr-3"></i>
            Generador de Reportes
        </h1>
    </div>

    <!-- Selector de Sección -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Selecciona una sección para generar el reporte</h2>
        
        <form id="formReporte" method="POST" action="{{ route('admin.reportes.generar') }}">
            @csrf
            <input type="hidden" name="tipo_reporte" id="tipoReporte" value="">
            <input type="hidden" name="formato" id="formatoInput" value="">

            <!-- Mensaje de error -->
            <div id="errorSeccion" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4 hidden">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Por favor, selecciona una sección antes de generar el reporte.
            </div>

            <!-- Grid de opciones -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <!-- Usuarios -->
                <div class="section-option cursor-pointer border-2 border-gray-200 rounded-xl p-6 hover:border-blue-500 hover:bg-blue-50 transition-all duration-200"
                    onclick="selectSection('usuarios', this)">
                    <div class="flex flex-col items-center text-center">
                        <div class="section-icon w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Usuarios</h3>
                        <p class="text-sm text-gray-600">Reporte de todos los usuarios de la plataforma</p>
                    </div>
                </div>

                <!-- Jugadores -->
                <div class="section-option cursor-pointer border-2 border-gray-200 rounded-xl p-6 hover:border-green-500 hover:bg-green-50 transition-all duration-200"
                    onclick="selectSection('asignar_jugadores', this)">
                    <div class="flex flex-col items-center text-center">
                        <div class="section-icon w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-user-plus text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Jugadores</h3>
                        <p class="text-sm text-gray-600">Reporte de jugadores asignados</p>
                    </div>
                </div>

                <!-- Entrenadores -->
                <div class="section-option cursor-pointer border-2 border-gray-200 rounded-xl p-6 hover:border-teal-500 hover:bg-teal-50 transition-all duration-200"
                    onclick="selectSection('entrenadores', this)">
                    <div class="flex flex-col items-center text-center">
                        <div class="section-icon w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-chalkboard-teacher text-teal-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Entrenadores</h3>
                        <p class="text-sm text-gray-600">Reporte de todos los entrenadores</p>
                    </div>
                </div>

                <!-- Noticias -->
                <div class="section-option cursor-pointer border-2 border-gray-200 rounded-xl p-6 hover:border-yellow-500 hover:bg-yellow-50 transition-all duration-200"
                    onclick="selectSection('noticias', this)">
                    <div class="flex flex-col items-center text-center">
                        <div class="section-icon w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-newspaper text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Noticias</h3>
                        <p class="text-sm text-gray-600">Reporte de noticias publicadas</p>
                    </div>
                </div>

                <!-- Planes -->
                <div class="section-option cursor-pointer border-2 border-gray-200 rounded-xl p-6 hover:border-red-500 hover:bg-red-50 transition-all duration-200"
                    onclick="selectSection('planes', this)">
                    <div class="flex flex-col items-center text-center">
                        <div class="section-icon w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-credit-card text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Planes</h3>
                        <p class="text-sm text-gray-600">Reporte de planes activos</p>
                    </div>
                </div>

                <!-- Disciplinas -->
                <div class="section-option cursor-pointer border-2 border-gray-200 rounded-xl p-6 hover:border-indigo-500 hover:bg-indigo-50 transition-all duration-200"
                    onclick="selectSection('disciplinas', this)">
                    <div class="flex flex-col items-center text-center">
                        <div class="section-icon w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-futbol text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Disciplinas</h3>
                        <p class="text-sm text-gray-600">Reporte de disciplinas</p>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-wrap gap-3 justify-center">
                <button type="button" 
                    onclick="submitForm('pdf')"
                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Generar PDF
                </button>
                <button type="button" 
                    onclick="submitForm('excel')"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-file-excel mr-2"></i>
                    Generar Excel/CSV
                </button>
            </div>
        </form>
    </div>

    <!-- Información adicional -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
            <div>
                <h4 class="font-semibold text-blue-900 mb-2">Información sobre los reportes</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Selecciona la sección que deseas reportar</li>
                    <li>• Elige el formato de descarga (PDF o Excel)</li>
                    <li>• El reporte se generará con los datos más recientes</li>
                    <li>• Los archivos se descargarán automáticamente</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedSection = null;

    function selectSection(section, element) {
        // Remover selección previa
        document.querySelectorAll('.section-option').forEach(opt => {
            opt.classList.remove('border-orange-500', 'bg-orange-50', 'ring-2', 'ring-orange-500');
            opt.classList.add('border-gray-200');
        });

        // Agregar selección actual
        element.classList.remove('border-gray-200');
        element.classList.add('border-orange-500', 'bg-orange-50', 'ring-2', 'ring-orange-500');

        // Guardar sección seleccionada
        selectedSection = section;
        document.getElementById('tipoReporte').value = section;

        // Ocultar mensaje de error
        document.getElementById('errorSeccion').classList.add('hidden');
    }

    function submitForm(formato) {
        // Validar que se haya seleccionado una sección
        if (!selectedSection) {
            document.getElementById('errorSeccion').classList.remove('hidden');
            // Scroll al mensaje de error
            document.getElementById('errorSeccion').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        // Establecer el formato
        document.getElementById('formatoInput').value = formato;

        // Enviar el formulario
        document.getElementById('formReporte').submit();
    }
</script>

<style>
    .section-option {
        transition: all 0.2s ease-in-out;
    }

    .section-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .section-option.border-orange-500 {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
    }
</style>