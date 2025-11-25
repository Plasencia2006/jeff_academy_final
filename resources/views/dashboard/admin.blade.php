@extends('layouts.admin-modern')

@section('title', 'Panel Administrador - Jeff Academy')

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
        if (['dashboard', 'usuarios', 'entrenadores', 'jugadores', 'asignaciones', 'inscripciones', 'noticias', 'planes', 'disciplinas', 'reportes', 'perfil', 'comunicados', 'ubicacion'].includes(hash)) {
            currentSection = hash;
        }
        
        // Escuchar cambios de hash
        window.addEventListener('hashchange', () => {
            const newHash = window.location.hash.substring(1);
            if (['dashboard', 'usuarios', 'entrenadores', 'jugadores', 'asignaciones', 'inscripciones', 'noticias', 'planes', 'disciplinas', 'reportes', 'perfil', 'comunicados', 'ubicacion'].includes(newHash)) {
                currentSection = newHash;
            } else {
                currentSection = 'dashboard';
            }
        });
    ">

    <!-- SECCIÓN: DASHBOARD PRINCIPAL -->
    <div x-show="currentSection === 'dashboard'" x-transition>
        @include('dashboard.admin.index')
    </div>

    <!-- SECCIÓN: USUARIOS -->
    <div x-show="currentSection === 'usuarios'" x-transition x-cloak>
        @include('dashboard.admin.usuarios')
    </div>

    <!-- SECCIÓN: ENTRENADORES -->
    <div x-show="currentSection === 'entrenadores'" x-transition x-cloak>
        @include('dashboard.admin.entrenadores')
    </div>

    <!-- SECCIÓN: JUGADORES -->
    <div x-show="currentSection === 'jugadores'" x-transition x-cloak>
        @include('dashboard.admin.jugadores')
    </div>

    <!-- SECCIÓN: ASIGNACIONES -->
    <div x-show="currentSection === 'asignaciones'" x-transition x-cloak>
        @include('dashboard.admin.asignaciones')
    </div>

    <!-- SECCIÓN: INSCRIPCIONES -->
    <div x-show="currentSection === 'inscripciones'" x-transition x-cloak>
        @include('dashboard.admin.inscripciones')
    </div>

    <!-- SECCIÓN: NOTICIAS -->
    <div x-show="currentSection === 'noticias'" x-transition x-cloak>
        @include('dashboard.admin.noticias')
    </div>

    <!-- SECCIÓN: PLANES -->
    <div x-show="currentSection === 'planes'" x-transition x-cloak>
        @include('dashboard.admin.planes')
    </div>

    <!-- SECCIÓN: DISCIPLINAS -->
    <div x-show="currentSection === 'disciplinas'" x-transition x-cloak>
        @include('dashboard.admin.disciplinas')
    </div>

    <!-- SECCIÓN: REPORTES -->
    <div x-show="currentSection === 'reportes'" x-transition x-cloak>
        @include('dashboard.admin.reportes')
    </div>

    <!-- SECCIÓN: PERFIL -->
    <div x-show="currentSection === 'perfil'" x-transition x-cloak>
        @include('dashboard.admin.perfil')
    </div>

    <!-- SECCIÓN: COMUNICADOS -->
    <div x-show="currentSection === 'comunicados'" x-transition x-cloak>
        @include('dashboard.admin.comunicados')
    </div>

    <!-- SECCIÓN: UBICACIONES -->
    <div x-show="currentSection === 'ubicacion'" x-transition x-cloak>
        @include('dashboard.admin.ubicacion')
    </div>

</div>

@push('scripts')
<script src="{{ asset('js/admin.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SCRIPT DE SELECCIÓN (FUNCIONA Y SE QUEDA MARCADO) -->
<script>
function selectSection(id, element) {

    document.getElementById("tipoReporte").value = id;

    // Desmarcar todo
    document.querySelectorAll(".section-option").forEach(card => {
        card.style.borderColor = "#d1d5db";
        card.style.background = "#ffffff";

        let iconCircle = card.querySelector(".section-icon");
        iconCircle.style.background = "#dcfce7";

        let icon = card.querySelector("i");
        icon.style.color = "#16a34a";
    });

    // Marcar seleccionado (verde)
    element.style.borderColor = "#16a34a";
    element.style.background = "#ecfdf5";

    let iconCircle = element.querySelector(".section-icon");
    iconCircle.style.background = "#bbf7d0";

    let icon = element.querySelector("i");
    icon.style.color = "#065f46";
}

function submitForm(type) {
    if (!document.getElementById("tipoReporte").value) {
        document.getElementById("errorSeccion").style.display = "block";
        return;
    }
    document.getElementById("formatoInput").value = type;
    document.getElementById("formReporte").submit();
}

</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos pasados desde Laravel - con valores por defecto
    const rolesDistribution = @json($distribucionUsuarios ?? []);
    const planDistribution = @json($distribucionPlanes ?? []);
    const disciplineDistribution = @json($distribucionDisciplinas ?? []);
    
    // Colores para las gráficas
    const colors = {
        roles: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
        status: ['#1cc88a', '#f6c23e'],
        plans: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
        disciplines: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1']
    };

    // Función para formatear labels de roles
    function formatRoleLabel(role) {
        const roleLabels = {
            'admin': 'Administrador',
            'player': 'Jugador',
            'coach': 'Entrenador'
        };
        return roleLabels[role] || role;
    }

    // 1. Gráfica de Distribución de Roles
    if (Object.keys(rolesDistribution).length > 0) {
        const rolesChart = new Chart(document.getElementById('rolesChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(rolesDistribution).map(formatRoleLabel),
                datasets: [{
                    data: Object.values(rolesDistribution),
                    backgroundColor: colors.roles,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    } else {
        document.getElementById('rolesChart').parentElement.innerHTML = 
            '<div class="no-chart-data"><i class="fas fa-chart-pie"></i><p>No hay datos de usuarios</p></div>';
    }

    // 2. Gráfica de Estado de Usuarios
    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Activos', 'Inactivos'],
            datasets: [{
                data: [{{ $usuariosActivos ?? 0 }}, {{ $usuariosInactivos ?? 0 }}],
                backgroundColor: colors.status,
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // 3. Gráfica de Planes Activos
    if (Object.keys(planDistribution).length > 0) {
        const plansChart = new Chart(document.getElementById('plansChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(planDistribution),
                datasets: [{
                    label: 'Suscripciones Activas',
                    data: Object.values(planDistribution),
                    backgroundColor: '#4e73df',
                    borderColor: '#2e59d9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    } else {
        document.getElementById('plansChart').parentElement.innerHTML = 
            '<div class="no-chart-data"><i class="fas fa-chart-bar"></i><p>No hay suscripciones activas</p></div>';
    }

    // 4. Gráfica de Disciplinas Populares
    if (Object.keys(disciplineDistribution).length > 0) {
        const disciplinesChart = new Chart(document.getElementById('disciplinesChart'), {
            type: 'polarArea',
            data: {
                labels: Object.keys(disciplineDistribution),
                datasets: [{
                    data: Object.values(disciplineDistribution),
                    backgroundColor: colors.disciplines,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 15,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    } else {
        document.getElementById('disciplinesChart').parentElement.innerHTML = 
            '<div class="no-chart-data"><i class="fas fa-chart-pie"></i><p>No hay datos de disciplinas</p></div>';
    }
});
</script>

@endpush
@endsection