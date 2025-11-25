<!-- Dashboard Admin Principal -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-tachometer-alt text-orange-600 mr-3"></i>
            Dashboard de Administración
        </h1>
        <div class="text-sm text-gray-500">
            {{ now()->format('l, d \d\e F \d\e Y') }}
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Jugadores Registrados -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100">
                    <i class="fas fa-users text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jugadores</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalJugadores ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Registrados</p>
                </div>
            </div>
        </div>

        <!-- Entrenadores Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-user-tie text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Entrenadores</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEntrenadores ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Activos</p>
                </div>
            </div>
        </div>

        <!-- Noticias Publicadas -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100">
                    <i class="fas fa-newspaper text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Noticias</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $noticias->count() ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Publicadas</p>
                </div>
            </div>
        </div>

        <!-- Disciplinas -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-running text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disciplinas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $disciplinas->count() ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Disponibles</p>
                </div>
            </div>
        </div>

        <!-- Planes Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-cyan-100">
                    <i class="fas fa-clipboard-list text-cyan-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Planes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $planes->count() ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Activos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-bolt text-orange-600 mr-2"></i>
            Acciones Rápidas
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Agregar Usuario -->
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'usuarios' }))" 
                class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl hover:from-orange-100 hover:to-orange-200 transition-all duration-200 cursor-pointer border-2 border-transparent hover:border-orange-300">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h5 class="font-semibold text-gray-900 mb-1">Agregar Usuario</h5>
                <p class="text-sm text-gray-600">Registrar nuevo usuario</p>
            </button>

            <!-- Asignar Jugadores -->
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'asignaciones' }))" 
                class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 cursor-pointer border-2 border-transparent hover:border-blue-300">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-clipboard-list text-white text-2xl"></i>
                </div>
                <h5 class="font-semibold text-gray-900 mb-1">Asignar Jugadores</h5>
                <p class="text-sm text-gray-600">Gestionar asignaciones</p>
            </button>

            <!-- Inscripciones -->
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'inscripciones' }))" 
                class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200 cursor-pointer border-2 border-transparent hover:border-green-300">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-clipboard-check text-white text-2xl"></i>
                </div>
                <h5 class="font-semibold text-gray-900 mb-1">Inscripciones</h5>
                <p class="text-sm text-gray-600">Gestionar solicitudes</p>
            </button>

            <!-- Publicar Noticia -->
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'noticias' }))" 
                class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200 cursor-pointer border-2 border-transparent hover:border-red-300">
                <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-bullhorn text-white text-2xl"></i>
                </div>
                <h5 class="font-semibold text-gray-900 mb-1">Publicar Noticia</h5>
                <p class="text-sm text-gray-600">Compartir información</p>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
            <!-- Gestionar Planes -->
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'planes' }))" 
                class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 cursor-pointer border-2 border-transparent hover:border-purple-300">
                <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-clipboard-list text-white text-2xl"></i>
                </div>
                <h5 class="font-semibold text-gray-900 mb-1">Gestionar Planes</h5>
                <p class="text-sm text-gray-600">Crear y editar planes</p>
            </button>

            <!-- Disciplinas -->
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'disciplinas' }))" 
                class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-200 cursor-pointer border-2 border-transparent hover:border-yellow-300">
                <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-trophy text-white text-2xl"></i>
                </div>
                <h5 class="font-semibold text-gray-900 mb-1">Disciplinas</h5>
                <p class="text-sm text-gray-600">Gestionar disciplinas</p>
            </button>

            <!-- Generar Reportes -->
            <button onclick="window.dispatchEvent(new CustomEvent('section-changed', { detail: 'reportes' }))" 
                class="group flex flex-col items-center justify-center p-6 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl hover:from-indigo-100 hover:to-indigo-200 transition-all duration-200 cursor-pointer border-2 border-transparent hover:border-indigo-300">
                <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-folder-open text-white text-2xl"></i>
                </div>
                <h5 class="font-semibold text-gray-900 mb-1">Generar Reportes</h5>
                <p class="text-sm text-gray-600">Gestionar reportes</p>
            </button>
        </div>
    </div>

    <!-- Gráficos y estadísticas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Distribución de Roles -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg mr-3">
                        <i class="fas fa-users text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Distribución de Roles</h3>
                        <p class="text-sm text-gray-500">Por tipo de usuario</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">
                    <i class="fas fa-user-circle mr-1"></i>
                    Total: {{ $totalUsuarios }}
                </span>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="rolesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Inscripciones por Disciplina -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg mr-3">
                        <i class="fas fa-clipboard-list text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Inscripciones por Disciplina</h3>
                        <p class="text-sm text-gray-500">Distribución de alumnos por deporte</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @php
                    $inscripcionesPorDisciplina = \App\Models\Inscripcion::select('disciplina', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
                        ->groupBy('disciplina')
                        ->get()
                        ->pluck('total', 'disciplina');
                    
                    $totalInscripciones = $inscripcionesPorDisciplina->sum();
                    $colores = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1'];
                    $colorIndex = 0;
                @endphp
                
                @if($inscripcionesPorDisciplina->count() > 0)
                    <div class="space-y-4">
                        @foreach($inscripcionesPorDisciplina as $disciplina => $total)
                        @php
                            $porcentaje = $totalInscripciones > 0 ? round(($total / $totalInscripciones) * 100, 2) : 0;
                            $color = $colores[$colorIndex % count($colores)];
                            $colorIndex++;
                        @endphp
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $color }}"></span>
                                    <span class="text-sm font-medium text-gray-700">{{ $disciplina }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600">{{ $total }} alumnos</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $porcentaje }}%</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all duration-500" style="width: {{ $porcentaje }}%; background-color: {{ $color }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-users text-orange-600 text-2xl mr-3"></i>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-gray-900">{{ $totalInscripciones }}</p>
                                <p class="text-sm text-gray-600">Total de Inscripciones</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-info-circle text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">No hay inscripciones registradas</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Suscripciones Activas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <i class="fas fa-money-bill-wave text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Suscripciones Activas</h3>
                        <p class="text-sm text-gray-500">Por tipo de plan</p>
                    </div>
                </div>
                @php
                    $totalPlanes = $distribucionPlanes->sum();
                @endphp
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Total: {{ $totalPlanes }}
                </span>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="plansChart"></canvas>
                </div>
                @if($distribucionPlanes->count() > 0)
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        @foreach($distribucionPlanes as $plan => $count)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-700">{{ $plan }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Disciplinas Populares -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                        <i class="fas fa-futbol text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Disciplinas Populares</h3>
                        <p class="text-sm text-gray-500">Inscripciones por deporte</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">
                    <i class="fas fa-trophy mr-1"></i>
                    Total: {{ $distribucionDisciplinas->sum() }}
                </span>
            </div>
            <div class="p-6">
                <div class="h-64">
                    <canvas id="disciplinesChart"></canvas>
                </div>
                @if($distribucionDisciplinas->count() > 0)
                    <div class="mt-4 space-y-2">
                        @foreach($distribucionDisciplinas as $disciplina => $count)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm text-gray-700">{{ $disciplina }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $count }} inscritos</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>