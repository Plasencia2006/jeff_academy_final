<!-- Gestión de Jugadores - Estilo TailPanel Mejorado -->
<div class="space-y-6" x-data="{ search: '', selectedPlayer: null }">
    <!-- Encabezado -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-users text-blue-600 mr-3"></i>
                Mis Jugadores
            </h1>
            <p class="text-gray-600 mt-1">Consulta el rendimiento y estadísticas de tus jugadores</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-users mr-1"></i>
                {{ ($jugadoresData ?? collect())->count() }} jugadores
            </span>
        </div>
    </div>

    <!-- Filtro de Búsqueda -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center space-x-4">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input 
                    type="text" 
                    x-model="search" 
                    placeholder="Buscar por nombre, categoría, posición..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
            </div>
            <button 
                @click="search = ''" 
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
            >
                <i class="fas fa-times mr-2"></i>Limpiar
            </button>
        </div>
    </div>

    <!-- Lista de jugadores -->
    @if(($jugadoresData ?? collect())->count() === 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-12 text-center">
                <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tienes jugadores asignados aún</h3>
                <p class="text-gray-500">Los jugadores aparecerán aquí cuando sean asignados a tu equipo.</p>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-list text-blue-600 mr-2"></i>
                    Lista de Jugadores
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jugadoresData as $data)
                        @php
                            $jugador = $data['jugador'];
                            $inscripcion = $data['inscripciones']->first();
                            $searchTerms = strtolower($jugador->name . ' ' . ($inscripcion->categoria ?? '') . ' ' . ($jugador->posicion ?? '') . ' ' . ($inscripcion->disciplina ?? ''));
                        @endphp
                        
                        <div 
                            class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow duration-200 border border-gray-200"
                            x-show="'{{ $searchTerms }}'.includes(search.toLowerCase()) || search === ''"
                            x-transition
                        >
                            <!-- Header del jugador -->
                            <div class="flex items-center mb-4">
                                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 flex-shrink-0 ring-2 ring-blue-500/20">
                                    @if($jugador->foto_url)
                                        <img src="{{ $jugador->foto_url }}" 
                                             alt="{{ $jugador->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-blue-100">
                                            <i class="fas fa-user text-blue-600 text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $jugador->name }}</h4>
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($inscripcion->categoria ?? 'N/A') }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($inscripcion->disciplina ?? 'Fútbol') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Información del jugador -->
                            <div class="space-y-2 mb-4 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope w-5 mr-3 text-blue-500"></i>
                                    <span class="truncate">{{ $jugador->email ?? 'Sin correo' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-user-tag w-5 mr-3 text-green-500"></i>
                                    <span>{{ ucfirst($jugador->posicion ?? 'N/A') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt w-5 mr-3 text-purple-500"></i>
                                    <span>{{ $jugador->edad ?? 'N/D' }} años</span>
                                </div>
                            </div>
                            
                            <!-- Estadísticas -->
                            <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-200">
                                <div class="text-center">
                                    <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-2 ring-1 ring-green-100">
                                        <i class="fas fa-futbol text-green-600 text-base"></i>
                                    </div>
                                    <div class="text-xl font-bold text-gray-900">{{ $data['total_goles'] }}</div>
                                    <div class="text-xs text-gray-500 uppercase">Goles</div>
                                </div>
                                <div class="text-center">
                                    <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-2 ring-1 ring-blue-100">
                                        <i class="fas fa-hands-helping text-blue-600 text-base"></i>
                                    </div>
                                    <div class="text-xl font-bold text-gray-900">{{ $data['total_asistencias'] }}</div>
                                    <div class="text-xs text-gray-500 uppercase">Asist.</div>
                                </div>
                                <div class="text-center">
                                    <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-2 ring-1 ring-yellow-100">
                                        <i class="fas fa-chart-line text-yellow-600 text-base"></i>
                                    </div>
                                    <div class="text-xl font-bold text-gray-900">{{ $data['total_partidos'] }}</div>
                                    <div class="text-xs text-gray-500 uppercase">Partidos</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
