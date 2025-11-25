@extends('layouts.coach-modern')

@section('title', 'Panel del Entrenador - Jeff Academy')

@section('content')

<!-- Contenedor Principal -->
<div x-data="{ 
    currentSection: 'dashboard',
    showModal: false,
    modalType: ''
}" 
    x-on:section-changed.window="currentSection = $event.detail"
    x-init="
        // Detectar hash inicial al cargar
        const hash = window.location.hash.substring(1);
        if (['asistencia', 'estadisticas', 'horarios', 'observaciones', 'gestion-entrenamientos', 'jugadores', 'anuncios', 'perfil', 'comunicados', 'ayuda'].includes(hash)) {
            currentSection = hash;
        }
        
        // Escuchar cambios de hash
        window.addEventListener('hashchange', () => {
            const newHash = window.location.hash.substring(1);
            if (['asistencia', 'estadisticas', 'horarios', 'observaciones', 'gestion-entrenamientos', 'jugadores', 'anuncios', 'perfil', 'comunicados', 'ayuda'].includes(newHash)) {
                currentSection = newHash;
            } else {
                currentSection = 'dashboard';
            }
        });
    ">
    <!-- Header -->
    
    <!--SECCIÓN: DASHBOARD PRINCIPAL -->
    <div x-show="currentSection === 'dashboard'" x-transition>
        @include('dashboard.coach.index')
    </div>

    <!-- SECCIÓN: ASISTENCIAS -->
    <div x-show="currentSection === 'asistencia'" x-transition x-cloak>
        @include('dashboard.coach.asistencias')
    </div>

    <!-- SECCIÓN: ESTADÍSTICAS -->
    <div x-show="currentSection === 'estadisticas'" x-transition x-cloak>
        @include('dashboard.coach.estadisticas')
    </div>

    <!-- SECCIÓN: HORARIOS -->
    <div x-show="currentSection === 'horarios'" x-transition x-cloak>
        @include('dashboard.coach.horarios')
    </div>

    <!-- SECCIÓN: OBSERVACIONES -->
    <div x-show="currentSection === 'observaciones'" x-transition x-cloak>
        @include('dashboard.coach.observaciones')
    </div>

    <!-- SECCIÓN: GESTIÓN ENTRENAMIENTOS -->
    <div x-show="currentSection === 'gestion-entrenamientos'" x-transition x-cloak>
        @include('dashboard.coach.gestion-entrenamientos')
    </div>

    <!-- SECCIÓN: JUGADORES -->
    <div x-show="currentSection === 'jugadores'" x-transition x-cloak>
        @include('dashboard.coach.jugadores')
    </div>

    <!-- SECCIÓN: AVISOS -->
    <div x-show="currentSection === 'anuncios'" x-transition x-cloak>
        @include('dashboard.coach.avisos')
    </div>

    <!-- SECCIÓN: PERFIL -->
    <div x-show="currentSection === 'perfil'" x-transition x-cloak>
        @include('dashboard.coach.perfil')
    </div>

    <!-- SECCIÓN: COMUNICADOS -->
    <div x-show="currentSection === 'comunicados'" x-transition x-cloak>
        @include('dashboard.coach.comunicados')
    </div>

    <!-- SECCIÓN: AYUDA -->
    <div x-show="currentSection === 'ayuda'" x-transition x-cloak>
        @include('dashboard.coach.ayuda')
    </div>

</div>

@push('scripts')
@php
    $last7 = collect(range(6,0))->map(fn($i) => \Carbon\Carbon::today()->subDays($i));
    $labels = $last7->map(fn($d) => $d->format('d/m'));
    $data = $last7->map(function($d) use ($asistenciasHistorial) {
        return isset($asistenciasHistorial)
            ? $asistenciasHistorial->where('fecha', $d->toDateString())->count()
            : 0;
    });
@endphp
<script>
// Script para gráfico de asistencias
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartAsistencias');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Asistencias',
                    data: @json($data),
                    borderColor: 'rgb(147, 51, 234)',
                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});

// Modal de perfil
function openEditProfileModal() {
    window.dispatchEvent(new CustomEvent('open-edit-profile'));
}

function previewProfileImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Funciones para asistencias (vistas internas)
function mostrarRegistroAsistencia() {
    document.getElementById('asistenciaMain').style.display = 'none';
    document.getElementById('asistenciaRegistro').style.display = 'block';
    document.getElementById('asistenciaHistorial').style.display = 'none';
}

function mostrarAsistenciasRegistradas() {
    document.getElementById('asistenciaMain').style.display = 'none';
    document.getElementById('asistenciaRegistro').style.display = 'none';
    document.getElementById('asistenciaHistorial').style.display = 'block';
}

function volverAsistenciaMain() {
    document.getElementById('asistenciaMain').style.display = 'block';
    document.getElementById('asistenciaRegistro').style.display = 'none';
    document.getElementById('asistenciaHistorial').style.display = 'none';
}

// Funciones para observaciones (vistas internas)
function mostrarFormularioObservacion() {
    document.getElementById('observacionesMain').style.display = 'none';
    document.getElementById('observacionesFormulario').style.display = 'block';
    document.getElementById('observacionesHistorial').style.display = 'none';
}

function mostrarObservacionesRegistradas() {
    document.getElementById('observacionesMain').style.display = 'none';
    document.getElementById('observacionesFormulario').style.display = 'none';
    document.getElementById('observacionesHistorial').style.display = 'block';
}

function volverObservacionesMain() {
    document.getElementById('observacionesMain').style.display = 'block';
    document.getElementById('observacionesFormulario').style.display = 'none';
    document.getElementById('observacionesHistorial').style.display = 'none';
}

// Función para filtrar por categoría en asistencias
function filtrarPorCategoria(categoria) {
    const filas = document.querySelectorAll('#tablaAsistencia tbody tr');
    filas.forEach(fila => {
        if (!categoria || fila.dataset.categoria === categoria) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    });
}

// Función para filtrar historial de asistencias
function filtrarHistorialAsistencias() {
    const categoria = document.getElementById('filtroHistorialCategoria')?.value.toLowerCase() || '';
    const estado = document.getElementById('filtroHistorialEstado')?.value.toLowerCase() || '';
    const jugador = document.getElementById('filtroHistorialJugador')?.value.toLowerCase() || '';
    const desde = document.getElementById('filtroHistorialDesde')?.value || '';
    const hasta = document.getElementById('filtroHistorialHasta')?.value || '';
    
    const filas = document.querySelectorAll('.fila-asistencia-historial');
    let contador = 0;
    
    filas.forEach(fila => {
        const filaCat = fila.dataset.categoria || '';
        const filaEst = fila.dataset.estado || '';
        const filaJug = fila.dataset.jugador || '';
        
        const okCat = !categoria || filaCat === categoria;
        const okEst = !estado || filaEst === estado;
        const okJug = !jugador || filaJug.includes(jugador);
        
        if (okCat && okEst && okJug) {
            fila.style.display = '';
            contador++;
        } else {
            fila.style.display = 'none';
        }
    });
    
    const contadorEl = document.getElementById('contadorAsistencias');
    if (contadorEl) contadorEl.textContent = contador;
}

// Función para filtrar observaciones
function filtrarObservaciones() {
    const jugador = document.getElementById('filtroJugadorObs')?.value || '';
    const aspecto = document.getElementById('filtroAspectoObs')?.value || '';
    const desde = document.getElementById('filtroFechaDesdeObs')?.value || '';
    const hasta = document.getElementById('filtroFechaHastaObs')?.value || '';
    
    const items = document.querySelectorAll('.observacion-item');
    
    items.forEach(item => {
        const itemJugador = item.dataset.jugador || '';
        const itemAspecto = item.dataset.aspecto || '';
        
        const okJugador = !jugador || itemJugador === jugador;
        const okAspecto = !aspecto || itemAspecto === aspecto;
        
        if (okJugador && okAspecto) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

// Función para filtrar campos de estadísticas por posición
function filtrarCamposPorPosicion(posicion) {
    const mensaje = document.getElementById('mensajeSeleccionPosicion');
    const contenedor = document.getElementById('contenedorEstadisticas');
    const campos = document.querySelectorAll('.campo-estadistica');
    
    if (!posicion) {
        mensaje.style.display = 'block';
        contenedor.style.display = 'none';
        return;
    }
    
    mensaje.style.display = 'none';
    contenedor.style.display = 'block';
    
    campos.forEach(campo => {
        const posiciones = campo.dataset.posiciones?.split(',') || [];
        if (posiciones.includes(posicion)) {
            campo.style.display = 'block';
        } else {
            campo.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection