@extends('layouts.player-modern')

@section('title', 'Panel del Jugador - Jeff Academy')

@section('content')

<!-- Contenedor Principal con Alpine.js -->
<div x-data="{ 
    currentSection: 'dashboard',
    showModal: false,
    modalType: ''
}" 
    x-on:section-changed.window="currentSection = $event.detail"
    x-init="
        // Detectar hash inicial al cargar
        const hash = window.location.hash.substring(1);
        if (['perfil', 'entrenamientos', 'rendimiento', 'evaluaciones', 'asistencia', 'pagos', 'anuncios', 'entrenador', 'ayuda'].includes(hash)) {
            currentSection = hash;
        }
        
        // Escuchar cambios de hash
        window.addEventListener('hashchange', () => {
            const newHash = window.location.hash.substring(1);
            if (['perfil', 'entrenamientos', 'rendimiento', 'evaluaciones', 'asistencia', 'pagos', 'anuncios', 'entrenador', 'ayuda'].includes(newHash)) {
                currentSection = newHash;
            } else {
                currentSection = 'dashboard';
            }
        });
    ">
    
    <!-- SECCIÓN: DASHBOARD PRINCIPAL -->
    <div x-show="currentSection === 'dashboard'" x-transition>
        @include('dashboard.player.index')
    </div>

    <!-- SECCIÓN: ENTRENAMIENTOS -->
    <div x-show="currentSection === 'entrenamientos'" x-transition x-cloak>
        @include('dashboard.player.entrenamientos')
    </div>

    <!-- SECCIÓN: RENDIMIENTO -->
    <div x-show="currentSection === 'rendimiento'" x-transition x-cloak>
        @include('dashboard.player.rendimiento')
    </div>

    <!-- SECCIÓN: EVALUACIONES -->
    <div x-show="currentSection === 'evaluaciones'" x-transition x-cloak>
        @include('dashboard.player.evaluaciones')
    </div>

    <!-- SECCIÓN: ASISTENCIA -->
    <div x-show="currentSection === 'asistencia'" x-transition x-cloak>
        @include('dashboard.player.asistencia')
    </div>

    <!-- SECCIÓN: PAGOS -->
    <div x-show="currentSection === 'pagos'" x-transition x-cloak>
        @include('dashboard.player.pagos')
    </div>

    <!-- SECCIÓN: ANUNCIOS -->
    <div x-show="currentSection === 'anuncios'" x-transition x-cloak>
        @include('dashboard.player.anuncios')
    </div>

    
    <!-- SECCIÓN: PERFIL -->
    <div x-show="currentSection === 'perfil'" x-transition x-cloak>
        @include('dashboard.player.perfil')
    </div>

    <!-- SECCIÓN: ENTRENADOR -->
    <div x-show="currentSection === 'entrenador'" x-transition x-cloak>
        @include('dashboard.player.entrenador')
    </div>

    <!-- SECCIÓN: AYUDA -->
    <div x-show="currentSection === 'ayuda'" x-transition x-cloak>
        @include('dashboard.player.ayuda')
    </div>

    <!-- Modales -->
    @include('dashboard.player.modals')

</div>

@endsection