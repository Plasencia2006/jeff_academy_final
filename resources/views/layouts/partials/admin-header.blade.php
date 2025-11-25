<header class="bg-white shadow-sm z-10">
    <div class="flex items-center justify-between px-4 sm:px-6 py-4">
        <!-- Botón menú móvil -->
        <button x-on:click="sidebarOpen = !sidebarOpen" 
                class="text-gray-500 focus:outline-none focus:text-gray-700 lg:hidden">
            <i class="fas fa-bars text-2xl"></i>
        </button>
        
        <!-- Título de la página -->
        <div class="flex items-center flex-1 lg:ml-0 ml-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Panel de Administración</h1>
        </div>

        
        <!-- Stats rápidas -->
        <div class="hidden md:flex items-center space-x-6 mr-6">
            <div class="text-center">
                <p class="text-xs text-gray-500">Total Usuarios</p>
                <p class="text-sm font-bold text-gray-800">{{ $totalUsuariosHeader ?? 0 }}</p>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-gray-500">Inscripciones Activas</p>
                <p class="text-sm font-bold text-gray-800">{{ $inscripcionesActivas ?? 0 }}</p>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-gray-500">Pagos Pendientes</p>
                <p class="text-sm font-bold text-orange-600">{{ $pagosPendientes ?? 0 }}</p>
            </div>
        </div>
        
        <!-- Acciones del header -->
        <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Notificaciones -->
            <div x-data="{ open:false }" class="relative">
                <button x-on:click="open = !open" class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full transition">
                    <i class="fas fa-bell text-xl"></i>
                    @if(($contadorNotificaciones ?? 0) > 0)
                        <span class="absolute -top-0.5 -right-0.5 min-w-[18px] h-4 px-1 bg-red-500 text-white text-[10px] leading-4 rounded-full text-center">{{ $contadorNotificaciones }}</span>
                    @endif
                </button>
                <div x-show="open" x-on:click.away="open=false" x-transition
                    class="fixed sm:absolute left-4 right-4 sm:left-auto sm:right-0 mt-2 sm:w-80 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-700">Notificaciones</h3>
                        <a href="{{ route('admin.dashboard') }}#noticias" class="text-xs text-orange-600 hover:underline">Ver todo</a>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @if(($contadorNotificaciones ?? 0) > 0)
                            @foreach(($notificacionesAdmin ?? collect([])) as $n)
                                <div class="px-4 py-3 hover:bg-gray-50 transition">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-orange-600"></i>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-800">{{ $n->titulo ?? 'Sin título' }}</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($n->mensaje ?? '', 80) }}</p>
                                            <p class="text-[11px] text-gray-400 mt-1">{{ $n->created_at ? $n->created_at->diffForHumans() : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="px-4 py-8 text-center text-gray-500 text-sm">No hay notificaciones nuevas</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Perfil dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                    class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">

                    <img src="{{ Auth::user()->foto_url ? Auth::user()->foto_url : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                        alt="Foto" 
                        class="h-8 w-8 rounded-full object-cover">

                    <i class="fas fa-chevron-down text-sm"></i>
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
                    
                    <!-- Perfil -->
                    <a href="#perfil" @click="open = false" 
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i>Mi Perfil
                    </a>
                    
                    <!-- Separador -->
                    <div class="border-t border-gray-100"></div>
                    
                    <!-- Cerrar Sesión -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
