<!-- Gestión de Entrenamientos - Estilo TailPanel -->
<div class="space-y-6" x-data="{ currentView: 'main', editingId: null, editingData: {} }">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                <i class="fas fa-calendar-alt text-blue-600 mr-2 sm:mr-3"></i>
                Programar Entrenamientos
            </h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Programa y gestiona los entrenamientos de tus equipos</p>
        </div>
        <div class="flex items-center flex-wrap gap-3">
            @php
                $proximosEntrenamientos = $entrenamientos->where('fecha', '>=', now()->toDateString())->sortBy('fecha')->sortBy('hora');
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <i class="fas fa-calendar-check mr-1"></i>
                {{ $proximosEntrenamientos->count() }} próximos
            </span>
            <button @click="currentView = 'crear'" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Entrenamiento
            </button>
        </div>
    </div>

    <!-- Vista Principal -->
    <div x-show="currentView === 'main'" class="space-y-6">
        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-calendar-week text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Esta Semana</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $entrenamientos->whereBetween('fecha', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-clock text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Próximos</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $proximosEntrenamientos->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-dumbbell text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Mes</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $entrenamientos->whereBetween('fecha', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-users text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Categorías</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $entrenamientos->pluck('categoria')->unique()->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximos entrenamientos -->
        @if($proximosEntrenamientos->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-calendar-day text-green-600 mr-2"></i>
                    Próximos Entrenamientos
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($proximosEntrenamientos->take(5) as $entrenamiento)
                        @php
                            $horaFin = \Carbon\Carbon::parse($entrenamiento->hora)->addMinutes($entrenamiento->duracion ?? 90)->format('H:i');
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                    @if($entrenamiento->tipo === 'tecnica') bg-blue-100 text-blue-600
                                    @elseif($entrenamiento->tipo === 'tactica') bg-green-100 text-green-600
                                    @elseif($entrenamiento->tipo === 'fisico') bg-red-100 text-red-600
                                    @else bg-purple-100 text-purple-600 @endif">
                                    <i class="fas fa-dumbbell"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">
                                        {{ ucfirst($entrenamiento->tipo) }} - {{ ucfirst($entrenamiento->categoria) }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($entrenamiento->fecha)->format('d M Y') }} • 
                                        {{ \Carbon\Carbon::parse($entrenamiento->hora)->format('H:i') }} - {{ $horaFin }} • 
                                        {{ ucfirst($entrenamiento->ubicacion) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'gestion-entrenamientos' }))" 
                                        class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($proximosEntrenamientos->count() > 5)
                <div class="mt-4 text-center">
                    <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'gestion-entrenamientos' }))"
                            class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Ver todos los entrenamientos →
                    </button>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Acceso directo a crear -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-8 text-center border border-blue-200">
            <i class="fas fa-calendar-plus text-blue-600 text-4xl mb-3"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">¿Listo para programar?</h3>
            <p class="text-gray-600 mb-4">Crea un nuevo entrenamiento para tu equipo</p>
            <button @click="currentView = 'crear'" 
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Programar Entrenamiento
            </button>
        </div>
    </div>

    <!-- Vista de Crear -->
    <div x-show="currentView === 'crear'" class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button @click="currentView = 'main'" 
                                class="mr-4 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </button>
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-calendar-plus text-blue-600 mr-2"></i>
                            Programar Entrenamiento
                        </h3>
                    </div>
                    <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
            
            <div class="p-6">
                <form id="formProgramarEntrenamiento" method="POST" action="{{ route('coach.horarios.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Información básica -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <select name="categoria" id="categoria" required
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione categoría...</option>
                                <option value="sub8">Sub-8</option>
                                <option value="sub12">Sub-12</option>
                                <option value="sub14">Sub-14</option>
                                <option value="sub16">Sub-16</option>
                                <option value="avanzado">Avanzado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Entrenamiento</label>
                            <select name="tipo" id="tipo" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione tipo...</option>
                                <option value="tecnica">Técnica</option>
                                <option value="tactica">Táctica</option>
                                <option value="fisico">Físico</option>
                                <option value="partido">Partido Práctica</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fecha y horarios -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                            <input type="date" name="fecha" id="fecha" required
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hora Inicio</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hora Fin</label>
                            <input type="time" name="hora_fin" id="hora_fin" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Ubicación y entrenador -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubicación</label>
                            <select name="ubicacion" id="ubicacion" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione ubicación...</option>
                                <option value="principal">Cancha Principal</option>
                                <option value="auxiliar">Cancha Auxiliar</option>
                                <option value="gimnasio">Gimnasio</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Entrenador</label>
                            <input type="text" value="{{ Auth::user()->name }}" readonly
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                            <input type="hidden" name="entrenador_id" value="{{ Auth::id() }}">
                        </div>
                    </div>

                    <!-- Objetivos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Objetivos del Entrenamiento</label>
                        <textarea name="objetivos" id="objetivos" rows="4" 
                                  placeholder="Describa los objetivos y actividades planificadas..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="flex justify-center gap-6 pt-6 border-t border-gray-200">
                        <button type="button" @click="currentView = 'main'" 
                                class="px-6 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                        <button type="submit" 
                                class="px-8 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Programar Entrenamiento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] {
    display: none !important;
}

/* Mejora visual de selects */
select {
    appearance: auto;
    line-height: 1.5;
    min-height: 38px;
}

/* Opciones más compactas */
select option {
    padding: 6px 10px !important;
    font-size: 14px !important;
    line-height: 1.3 !important;
    min-height: 32px !important;
}

/* Hover en las opciones (solo webkit) */
select option:hover {
    background-color: #DBEAFE !important;
    color: #1E40AF !important;
}

/* Opciones seleccionadas */
select option:checked {
    background-color: #3B82F6 !important;
    color: white !important;
}
</style>
