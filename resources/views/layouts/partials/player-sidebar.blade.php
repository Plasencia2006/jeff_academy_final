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
    class="fixed inset-y-0 left-0 z-50 bg-gradient-to-b from-[#093b25] to-[#12613d] transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl flex flex-col h-screen"
    x-cloak>
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-[#093b25] border-b border-[#0d4d30] flex-shrink-0">
        <img src="{{ asset('img/logo-blanco.png') }}" alt="Jeff Academy" class="h-10">
    </div>
    
    <!-- Perfil -->
    <div class="px-5 py-6 border-b border-[#0d4d30] flex-shrink-0">
        <div class="flex items-center space-x-4" :class="{ 'justify-center': $root.sidebarCollapsed }">
            <img 
                src="{{ Auth::user()->foto_url ? Auth::user()->foto_url : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                alt="Foto"
                class="h-12 w-12 rounded-full border-2 border-[#4ac98e]/60 object-cover shadow-md shadow-black/20">
            
            <div x-show="!$root.sidebarCollapsed" class="flex-1 min-w-0">
                <p class="text-white font-semibold text-base">{{ Auth::user()->name }}</p>
                <p class="text-[#b0dec8] text-sm">Jugador</p>
            </div>
        </div>
    </div>

    
    <!-- Navegación -->
    <nav class="flex-1 overflow-y-auto mt-6 px-3 space-y-1" x-data="{ activeSection: 'dashboard' }">
        <a href="{{ route('player.dashboard') }}#dashboard" 
            x-on:click.prevent="activeSection = 'dashboard'; window.location.hash='dashboard'; $dispatch('section-changed', 'dashboard'); sidebarOpen = false"
            :class="activeSection === 'dashboard' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-tachometer-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Dashboard</span>
        </a>
        
        <a href="{{ route('player.dashboard') }}#entrenamientos" 
            x-on:click.prevent="activeSection = 'entrenamientos'; window.location.hash='entrenamientos'; $dispatch('section-changed', 'entrenamientos'); sidebarOpen = false"
            :class="activeSection === 'entrenamientos' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-calendar-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Entrenamientos</span>
        </a>
        
        <a href="{{ route('player.dashboard') }}#rendimiento" 
            x-on:click.prevent="activeSection = 'rendimiento'; window.location.hash='rendimiento'; $dispatch('section-changed', 'rendimiento'); sidebarOpen = false"
            :class="activeSection === 'rendimiento' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-chart-line text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Rendimiento</span>
        </a>
        
        <a href="{{ route('player.dashboard') }}#evaluaciones" 
            x-on:click.prevent="activeSection = 'evaluaciones'; window.location.hash='evaluaciones'; $dispatch('section-changed', 'evaluaciones'); sidebarOpen = false"
            :class="activeSection === 'evaluaciones' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-clipboard-check text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Evaluaciones</span>
        </a>
        
        <a href="{{ route('player.dashboard') }}#asistencia" 
            x-on:click.prevent="activeSection = 'asistencia'; window.location.hash='asistencia'; $dispatch('section-changed', 'asistencia'); sidebarOpen = false"
            :class="activeSection === 'asistencia' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-check-circle text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Asistencia</span>
        </a>
        
        <a href="{{ route('player.dashboard') }}#pagos" 
            x-on:click.prevent="activeSection = 'pagos'; window.location.hash='pagos'; $dispatch('section-changed', 'pagos'); sidebarOpen = false"
            :class="activeSection === 'pagos' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-credit-card text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Pagos</span>
        </a>
        
        <a href="{{ route('player.dashboard') }}#anuncios" 
            x-on:click.prevent="activeSection = 'anuncios'; window.location.hash='anuncios'; $dispatch('section-changed', 'anuncios'); sidebarOpen = false"
            :class="activeSection === 'anuncios' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-bullhorn text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Anuncios</span>
        </a>

        <a href="{{ route('player.dashboard') }}#perfil" 
            x-on:click.prevent="activeSection = 'perfil'; window.location.hash='perfil'; $dispatch('section-changed', 'perfil'); sidebarOpen = false"
            :class="activeSection === 'perfil' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-user text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Perfil</span>
        </a>

        <a href="{{ route('player.dashboard') }}#entrenador" 
            x-on:click.prevent="activeSection = 'entrenador'; window.location.hash='entrenador'; $dispatch('section-changed', 'entrenador'); sidebarOpen = false"
            :class="activeSection === 'entrenador' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-chalkboard-teacher text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Entrenador</span>
        </a>
        
        <a href="{{ route('player.dashboard') }}#ayuda" 
            x-on:click.prevent="activeSection = 'ayuda'; window.location.hash='ayuda'; $dispatch('section-changed', 'ayuda'); sidebarOpen = false"
            :class="activeSection === 'ayuda' ? 'bg-[#12613d] text-white' : 'text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-question-circle text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Ayuda</span>
        </a>
    </nav>
    
    <!-- Footer del Sidebar -->
    <div class="p-4 border-t border-[#0d4d30] flex-shrink-0">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center px-3 py-2 text-sm font-medium text-[#b0dec8] hover:bg-[#0d4d30] hover:text-white rounded-lg transition-colors duration-200"
                    :class="{ 'justify-center': $root.sidebarCollapsed }">
                <i class="fas fa-sign-out-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
                <span x-show="!$root.sidebarCollapsed">Cerrar Sesión</span>
            </button>
        </form>
    </div>
</div>