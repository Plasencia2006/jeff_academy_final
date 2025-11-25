<header class="bg-white shadow-sm z-10">
    <div class="flex items-center justify-between px-4 sm:px-6 py-4">
        <!-- Botón menú móvil -->
        <button x-on:click="sidebarOpen = !sidebarOpen" 
                class="text-gray-500 focus:outline-none focus:text-gray-700 lg:hidden">
            <i class="fas fa-bars text-2xl"></i>
        </button>
        
        <!-- Título de la página -->
        <div class="flex items-center flex-1 lg:ml-0 ml-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Panel del Entrenador</h1>
        </div>


        
        <!-- Stats rápidas -->
        <div class="hidden md:flex items-center space-x-6 mr-6">
            @php
                $proximosEntrenamientos = isset($entrenamientos) ? $entrenamientos->where('fecha', '>=', now())->sortBy('fecha')->take(1)->first() : null;
                $totalJugadores = isset($inscripciones) ? $inscripciones->count() : 0;
                $asistenciasHoy = isset($asistenciasHistorial) ? $asistenciasHistorial->where('fecha', \Carbon\Carbon::today()->toDateString())->count() : 0;
            @endphp
            
            <div class="text-center">
                <p class="text-xs text-gray-500">Próximo Entrenamiento</p>
                <p class="text-sm font-bold text-gray-800">
                    @if($proximosEntrenamientos)
                        {{ \Carbon\Carbon::parse($proximosEntrenamientos->fecha)->format('d/m') }}
                    @else
                        Sin programar
                    @endif
                </p>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-gray-500">Jugadores</p>
                <p class="text-sm font-bold text-gray-800">{{ $totalJugadores }}</p>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-gray-500">Asistencias Hoy</p>
                <p class="text-sm font-bold text-gray-800">{{ $asistenciasHoy }}</p>
            </div>
        </div>
        
        <!-- Notificaciones y perfil -->
        <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Notificaciones -->
            <div x-data="{ open: false }" class="relative">
                <button x-on:click="open = !open" class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full transition">
                    <i class="fas fa-bell text-xl"></i>
                    @if($proximosEntrenamientos)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">1</span>
                    @endif
                </button>
                
                <!-- Dropdown notificaciones -->
                <div x-show="open" 
                    x-on:click.away="open=false" 
                    x-transition
                    class="fixed sm:absolute left-4 right-4 sm:left-auto sm:right-0 mt-2 sm:w-80 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden z-50"
                    x-cloak>
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700">Notificaciones</h3>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @if($proximosEntrenamientos)
                        <div class="px-4 py-3 hover:bg-gray-50 transition">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-calendar-check text-blue-500"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-800">Próximo entrenamiento</p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        {{ ucfirst($proximosEntrenamientos->categoria) }} - {{ \Carbon\Carbon::parse($proximosEntrenamientos->fecha)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="px-4 py-8 text-center text-gray-500 text-sm">
                            No hay notificaciones nuevas
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Perfil dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button x-on:click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                    <img 
                        src="{{ Auth::user()->foto_url ? Auth::user()->foto_url : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                        alt="Profile" 
                        class="h-10 w-10 rounded-full border-2 border-gray-300 object-cover shadow-md shadow-black/20">
                        
                    <i class="fas fa-chevron-down text-gray-600 text-sm"></i>
                </button>
                
                <!-- Dropdown menu -->
                <div x-show="open" 
                    x-on:click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden"
                    x-cloak>
                    
                    <!-- Información del usuario -->
                    <div class="px-4 py-3 border-b border-gray-200">
                        <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <!-- Editar Perfil -->
                    <a href="#" @click="$dispatch('section-changed', 'perfil'); open = false" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i>Mi Perfil
                    </a>
                    
                    <!-- Separador -->
                    <div class="border-t border-gray-100"></div>
                    
                    <!-- Cerrar Sesión -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>