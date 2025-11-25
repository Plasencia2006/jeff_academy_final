<!-- Overlay para móvil -->
<div x-show="sidebarOpen" 
     x-on:click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
     x-cloak></div>

<!-- Sidebar -->
<div x-bind:class="[$root.sidebarCollapsed ? 'w-16' : 'w-64', sidebarOpen ? 'translate-x-0' : '-translate-x-full']"
     class="fixed inset-y-0 left-0 z-50 bg-gradient-to-b from-gray-900 to-gray-800 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl flex flex-col h-screen"
     x-cloak>
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-900 border-b border-gray-700 flex-shrink-0">
        <img src="{{ asset('img/logo-blanco.png') }}" alt="Jeff Academy" class="h-10">
    </div>
    
    <!-- Perfil del Coach -->
    <div class="px-6 py-7 border-b border-gray-700 flex-shrink-0">
        <div class="flex items-center space-x-4">
            <img 
                src="{{ Auth::user()->foto_url ? Auth::user()->foto_url : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                alt="Coach" 
                class="h-12 w-12 rounded-full border-2 border-jeff-secondary object-cover shadow-md shadow-black/20">

            <div>
                <p class="text-white font-semibold text-base">{{ Auth::user()->name }}</p>
                <p class="text-gray-400 text-sm">Entrenador</p>
            </div>
        </div>
    </div>

    <!-- Navegación -->
    <nav class="flex-1 overflow-y-auto mt-6 px-3 space-y-1" x-data="{ activeSection: 'dashboard' }">
        <a href="{{ route('coach.dashboard') }}#dashboard" 
           x-on:click.prevent="activeSection = 'dashboard'; window.location.hash='dashboard'; $dispatch('section-changed', 'dashboard'); sidebarOpen = false"
           :class="activeSection === 'dashboard' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-tachometer-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Dashboard</span>
        </a>
        
        <a href="{{ route('coach.dashboard') }}#asistencia" 
           x-on:click.prevent="activeSection = 'asistencia'; window.location.hash='asistencia'; $dispatch('section-changed', 'asistencia'); sidebarOpen = false"
           :class="activeSection === 'asistencia' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-clipboard-check text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Asistencias</span>
        </a>
        
        <a href="{{ route('coach.dashboard') }}#estadisticas" 
           x-on:click.prevent="activeSection = 'estadisticas'; window.location.hash='estadisticas'; $dispatch('section-changed', 'estadisticas'); sidebarOpen = false"
           :class="activeSection === 'estadisticas' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-chart-line text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Estadísticas</span>
        </a>
        
        <a href="{{ route('coach.dashboard') }}#horarios" 
           x-on:click.prevent="activeSection = 'horarios'; window.location.hash='horarios'; $dispatch('section-changed', 'horarios'); sidebarOpen = false"
           :class="activeSection === 'horarios' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-calendar-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Entrenamientos</span>
        </a>
        
        <a href="{{ route('coach.dashboard') }}#observaciones" 
           x-on:click.prevent="activeSection = 'observaciones'; window.location.hash='observaciones'; $dispatch('section-changed', 'observaciones'); sidebarOpen = false"
           :class="activeSection === 'observaciones' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-sticky-note text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Observaciones</span>
        </a>
        
        <a href="{{ route('coach.dashboard') }}#gestion-entrenamientos" 
           x-on:click.prevent="activeSection = 'entrenamientos'; window.location.hash='gestion-entrenamientos'; $dispatch('section-changed', 'gestion-entrenamientos'); sidebarOpen = false"
           :class="activeSection === 'entrenamientos' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-edit text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Gestión Entrenamientos</span>
        </a>
        
        <a href="{{ route('coach.dashboard') }}#jugadores" 
           x-on:click.prevent="activeSection = 'jugadores'; window.location.hash='jugadores'; $dispatch('section-changed', 'jugadores'); sidebarOpen = false"
           :class="activeSection === 'jugadores' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-users text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Jugadores</span>
        </a>

        <a href="{{ route('coach.dashboard') }}#anuncios" 
           x-on:click.prevent="activeSection = 'anuncios'; window.location.hash='anuncios'; $dispatch('section-changed', 'anuncios'); sidebarOpen = false"
           :class="activeSection === 'anuncios' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-sticky-note text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Anuncios</span>
        </a>

        <a href="{{ route('coach.dashboard') }}#perfil" 
           x-on:click.prevent="activeSection = 'perfil'; window.location.hash='perfil'; $dispatch('section-changed', 'perfil'); sidebarOpen = false"
           :class="activeSection === 'perfil' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-user-circle text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Mi Perfil</span>
        </a>

        <a href="{{ route('coach.dashboard') }}#comunicados" 
           x-on:click.prevent="activeSection = 'comunicados'; window.location.hash='comunicados'; $dispatch('section-changed', 'comunicados'); sidebarOpen = false"
           :class="activeSection === 'comunicados' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-envelope text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Comunicados</span>
        </a>

        <a href="{{ route('coach.dashboard') }}#ayuda" 
           x-on:click.prevent="activeSection = 'ayuda'; window.location.hash='ayuda'; $dispatch('section-changed', 'ayuda'); sidebarOpen = false"
           :class="activeSection === 'ayuda' ? 'bg-jeff-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-question text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Ayuda</span>
        </a>
   
    </nav>
    
    <!-- Logout -->
    <div class="px-3 py-4 border-t border-gray-700 flex-shrink-0">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200">
                <i class="fas fa-sign-out-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
                <span x-show="!$root.sidebarCollapsed">Cerrar Sesión</span>
            </button>
        </form>
    </div>
</div>