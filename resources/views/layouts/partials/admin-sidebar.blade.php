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
    class="fixed inset-y-0 left-0 z-50 bg-[#013028] transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl flex flex-col h-screen"
    x-cloak>
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-[#001d16ff] border-b border-[#014436] flex-shrink-0">
        <img src="{{ asset('img/logo-blanco.png') }}" alt="Jeff Academy" class="h-10">
    </div>
    
    <!-- Perfil -->
    <div class="px-5 py-6 border-b border-[#014436] flex-shrink-0">
        <div class="flex items-center space-x-4" :class="{ 'justify-center': $root.sidebarCollapsed }">
            <img 
                src="{{ Auth::user()->foto_url ? Auth::user()->foto_url : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
                alt="Foto"
                class="h-12 w-12 rounded-full border-2 border-teal-300/60 object-cover shadow-md shadow-black/20">
            
            <div x-show="!$root.sidebarCollapsed" class="flex-1 min-w-0">
                <p class="text-white font-semibold text-base">{{ Auth::user()->name }}</p>
                <p class="text-teal-200 text-sm">Administrador</p>
            </div>
        </div>
    </div>

    
    <!-- Navegación -->
    <nav class="flex-1 overflow-y-auto mt-6 px-3 space-y-1" x-data="{ activeSection: 'dashboard' }">
        <a href="{{ route('admin.dashboard') }}#dashboard" 
            x-on:click.prevent="activeSection = 'dashboard'; window.location.hash='dashboard'; $dispatch('section-changed', 'dashboard'); sidebarOpen = false"
            :class="activeSection === 'dashboard' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-tachometer-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.dashboard') }}#usuarios" 
            x-on:click.prevent="activeSection = 'usuarios'; window.location.hash='usuarios'; $dispatch('section-changed', 'usuarios'); sidebarOpen = false"
            :class="activeSection === 'usuarios' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-users text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Gestión Usuarios</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#entrenadores" 
            x-on:click.prevent="activeSection = 'entrenadores'; window.location.hash='entrenadores'; $dispatch('section-changed', 'entrenadores'); sidebarOpen = false"
            :class="activeSection === 'entrenadores' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-chalkboard-teacher text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Entrenadores</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#jugadores" 
            x-on:click.prevent="activeSection = 'jugadores'; window.location.hash='jugadores'; $dispatch('section-changed', 'jugadores'); sidebarOpen = false"
            :class="activeSection === 'jugadores' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-users text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Jugadores</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#asignaciones" 
            x-on:click.prevent="activeSection = 'asignaciones'; window.location.hash='asignaciones'; $dispatch('section-changed', 'asignaciones'); sidebarOpen = false"
            :class="activeSection === 'asignaciones' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-users" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Asignaciones</span>
        </a>
        
        <a href="{{ route('admin.dashboard') }}#inscripciones" 
            x-on:click.prevent="activeSection = 'inscripciones'; window.location.hash='inscripciones'; $dispatch('section-changed', 'inscripciones'); sidebarOpen = false"
            :class="activeSection === 'inscripciones' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-user-plus text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Inscripciones</span>
        </a>


        <a href="{{ route('admin.dashboard') }}#noticias" 
            x-on:click.prevent="activeSection = 'noticias'; window.location.hash='noticias'; $dispatch('section-changed', 'noticias'); sidebarOpen = false"
            :class="activeSection === 'noticias' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-newspaper text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Noticias</span>
        </a>
        
        <a href="{{ route('admin.dashboard') }}#planes" 
            x-on:click.prevent="activeSection = 'planes'; window.location.hash='planes'; $dispatch('section-changed', 'planes'); sidebarOpen = false"
            :class="activeSection === 'planes' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-clipboard-list text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Planes</span>
        </a>


        <a href="{{ route('admin.dashboard') }}#disciplinas" 
            x-on:click.prevent="activeSection = 'disciplinas'; window.location.hash='disciplinas'; $dispatch('section-changed', 'disciplinas'); sidebarOpen = false"
            :class="activeSection === 'disciplinas' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-futbol text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Disciplinas</span>
        </a>


        <a href="{{ route('admin.dashboard') }}#reportes" 
            x-on:click.prevent="activeSection = 'reportes'; window.location.hash='reportes'; $dispatch('section-changed', 'reportes'); sidebarOpen = false"
            :class="activeSection === 'reportes' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-file-invoice text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Reportes</span>
        </a>


        <a href="{{ route('admin.dashboard') }}#perfil" 
            x-on:click.prevent="activeSection = 'perfil'; window.location.hash='perfil'; $dispatch('section-changed', 'perfil'); sidebarOpen = false"
            :class="activeSection === 'perfil' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-user text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Perfil</span>
        </a>


        <a href="{{ route('admin.dashboard') }}#comunicados" 
            x-on:click.prevent="activeSection = 'comunicados'; window.location.hash='comunicados'; $dispatch('section-changed', 'comunicados'); sidebarOpen = false"
            :class="activeSection === 'comunicados' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-bell text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Comunicados</span>
        </a>

        <a href="{{ route('admin.dashboard') }}#ubicacion" 
            x-on:click.prevent="activeSection = 'ubicacion'; window.location.hash='ubicacion'; $dispatch('section-changed', 'ubicacion'); sidebarOpen = false"
            :class="activeSection === 'ubicacion' ? 'bg-[#014436] text-white' : 'text-teal-100 hover:bg-[#014436] hover:text-white'"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-map-marker-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
            <span x-show="!$root.sidebarCollapsed">Ubicaciones</span>
        </a>
    </nav>
    
    <!-- Footer del Sidebar -->
    <div class="p-4 border-t border-[#014436] flex-shrink-0">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center px-3 py-2 text-sm font-medium text-teal-100 hover:bg-[#014436] hover:text-white rounded-lg transition-colors duration-200"
                    :class="{ 'justify-center': $root.sidebarCollapsed }">
                <i class="fas fa-sign-out-alt text-lg" :class="$root.sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
                <span x-show="!$root.sidebarCollapsed">Cerrar Sesión</span>
            </button>
        </form>
    </div>
</div>
