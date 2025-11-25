// Admin Dashboard JavaScript - Versión Final

document.addEventListener('DOMContentLoaded', function () {
    // ============================================
    // ELEMENTOS DEL DOM
    // ============================================
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    const sectionContents = document.querySelectorAll('.section-content');
    const quickActionCards = document.querySelectorAll('.quick-action-card');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');

    // ============================================
    // FUNCIÓN: Cambiar de Sección
    // ============================================
    function showSection(sectionId) {
        // Remover clase active de todos los enlaces
        navLinks.forEach(navLink => {
            navLink.classList.remove('active');
        });

        // Agregar clase active al enlace correspondiente
        const targetLink = document.querySelector(`.sidebar .nav-link[data-section="${sectionId}"]`);
        if (targetLink) {
            targetLink.classList.add('active');
        }

        // Ocultar todas las secciones
        sectionContents.forEach(section => {
            section.classList.remove('active-section');
        });

        // Mostrar la sección correspondiente
        const targetSection = document.getElementById(sectionId);
        if (targetSection) {
            targetSection.classList.add('active-section');
        }

        // Cerrar el menú móvil
        if (window.innerWidth <= 992) {
            sidebar.classList.remove('mobile-open');
        }

        // Scroll a la parte superior
        window.scrollTo(0, 0);
    }

    // ============================================
    // EVENTOS: Navegación
    // ============================================
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') {
                e.preventDefault();
            }
            const targetSection = this.getAttribute('data-section');
            if (targetSection) {
                e.preventDefault();
                showSection(targetSection);
            }
        });
    });

    // ============================================
    // EVENTOS: Tarjetas de Acciones Rápidas
    // ============================================
    quickActionCards.forEach(card => {
        card.addEventListener('click', function () {
            const targetSection = this.getAttribute('data-section');
            if (targetSection) {
                showSection(targetSection);
            }
        });
    });

    // ============================================
    // EVENTOS: Toggle del Menú Móvil
    // ============================================
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
        });
    }

    // Cerrar menú móvil al hacer clic fuera
    document.addEventListener('click', function (e) {
        if (window.innerWidth <= 992 &&
            !sidebar.contains(e.target) &&
            !mobileMenuToggle.contains(e.target) &&
            sidebar.classList.contains('mobile-open')) {
            sidebar.classList.remove('mobile-open');
        }
    });

    // ============================================
    // EVENTOS: Mostrar/Ocultar Fechas Personalizadas
    // ============================================
    const rangoFecha = document.getElementById('rangoFecha');
    const fechasPersonalizadas = document.getElementById('fechasPersonalizadas');

    if (rangoFecha && fechasPersonalizadas) {
        rangoFecha.addEventListener('change', function () {
            if (this.value === 'personalizado') {
                fechasPersonalizadas.style.display = 'flex';
            } else {
                fechasPersonalizadas.style.display = 'none';
            }
        });
    }

    // ============================================
    // EVENTOS: Formularios con Validación
    // ============================================
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            // Laravel manejará la validación en el servidor
            // Aquí solo validamos el cliente
            console.log('Formulario enviado:', this.id);
        });
    });

    // ============================================
    // MOSTRAR NOTIFICACIONES (Laravel Flash Messages)
    // ============================================
    function mostrarNotificaciones() {
        const alertas = document.querySelectorAll('.alert');
        alertas.forEach(alerta => {
            setTimeout(() => {
                alerta.style.display = 'none';
            }, 4000);
        });
    }

    mostrarNotificaciones();

    // ============================================
    // MOSTRAR/Ocultar FORMULARIOS
    // ============================================
    function mostrarFormulario(id) {
        const fila = document.getElementById('formulario-' + id);
        if (fila.style.display === 'none') {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    }

    // ============================================
    // ANIMACIÓN DE CONTADORES EN DASHBOARD
    // ============================================
    function animarContadores() {
        const dashboardCards = document.querySelectorAll('.dashboard-card h3');
        
        dashboardCards.forEach(card => {
            const texto = card.textContent.trim();
            // Obtener solo números
            const numero = parseInt(texto.replace(/\D/g, ''));
            
            if (!isNaN(numero) && numero > 0) {
                let actual = 0;
                const incremento = Math.ceil(numero / 20);
                const interval = setInterval(() => {
                    actual += incremento;
                    if (actual >= numero) {
                        card.textContent = numero;
                        clearInterval(interval);
                    } else {
                        card.textContent = actual;
                    }
                }, 50);
            }
        });
    }

    // Animar contadores después de un pequeño delay
    setTimeout(animarContadores, 300);

    // ============================================
    // EFECTO DE CARGA EN BOTONES
    // ============================================
    const buttons = document.querySelectorAll('.btn-jeff, .btn-jeff-secondary, .btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            // No interferir con formularios o links especiales
            if (this.type === 'submit' || this.getAttribute('href')) {
                return;
            }

            // Crear efecto ripple
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple-effect');

            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // ============================================
    // FILTROS EN TABLA DE PAGOS
    // ============================================
    const btnBuscar = document.querySelector('[id="btnBuscar"]');
    if (btnBuscar) {
        btnBuscar.addEventListener('click', function (e) {
            e.preventDefault();
            const disciplina = document.getElementById('filtroDisciplina').value;
            const estado = document.getElementById('filtroEstado').value;
            
            console.log('Filtros aplicados:', { disciplina, estado });
        });
    }

    // ============================================
    // ESTILOS DINÁMICOS PARA RIPPLE
    // ============================================
    const styleRipple = document.createElement('style');
    styleRipple.textContent = `
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(styleRipple);

    // ============================================
    // VERIFICAR CONEXIÓN Y CARGAR DATOS
    // ============================================
    console.log('%cAdmin Dashboard Iniciado', 'color: #4caf50; font-size: 16px; font-weight: bold;');
    console.log('%cSistema listo para usar', 'color: #2e7d32; font-size: 12px;');

    // Mostrar dashboard por defecto
    showSection('inicio');
});


function mostrarFormulario(id) {
    const fila = document.getElementById('formulario-' + id);

    // Si ya está visible, lo oculta
    if (fila.style.display === 'table-row') {
        fila.style.display = 'none';
    } else {
        // Oculta los demás
        document.querySelectorAll('[id^="formulario-"]').forEach(f => f.style.display = 'none');
        // Muestra el actual
        fila.style.display = 'table-row';
        fila.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}



// Auto compretado páara crear un usuario 
document.addEventListener('DOMContentLoaded', function () {
    const tipoUsuario = document.getElementById('tipoUsuario');
    const grupoJugador = document.getElementById('grupoSeleccionarJugador');
    const seleccionarRegistro = document.getElementById('seleccionarRegistro');
    const buscadorJugador = document.getElementById('buscadorJugador');
    const alertInfo = document.getElementById('alertInfo');
    const alertText = document.getElementById('alertText');
    const btnRegistrar = document.getElementById('btnRegistrar');

    // Guardar todas las opciones originales para el filtrado
    const opcionesOriginales = Array.from(seleccionarRegistro.querySelectorAll('option'));

    // Campos que se autocompletan/deshabilitan
    const campos = {
        nombres: document.getElementById('nombres'),
        apellido_paterno: document.getElementById('apellido_paterno'),
        apellido_materno: document.getElementById('apellido_materno'),
        documentoUsuario: document.getElementById('documentoUsuario'),
        emailUsuario: document.getElementById('emailUsuario'),
        telefonoUsuario: document.getElementById('telefonoUsuario'),
        generoUsuario: document.getElementById('generoUsuario'),
        fechaNacimiento: document.getElementById('fechaNacimiento')
    };

    // Función para filtrar jugadores
    function filtrarJugadores(termino) {
        const terminoLower = termino.toLowerCase().trim();

        // Limpiar select excepto la primera opción
        while (seleccionarRegistro.options.length > 1) {
            seleccionarRegistro.remove(1);
        }

        // Si no hay término, mostrar todas las opciones
        if (!terminoLower) {
            opcionesOriginales.forEach((opcion, index) => {
                if (index > 0) { // Saltar la primera opción (placeholder)
                    seleccionarRegistro.appendChild(opcion.cloneNode(true));
                }
            });
            return;
        }

        // Filtrar opciones que coincidan con el término
        opcionesOriginales.forEach((opcion, index) => {
            if (index > 0) { // Saltar la primera opción
                const searchText = opcion.getAttribute('data-search') || '';
                if (searchText.includes(terminoLower)) {
                    seleccionarRegistro.appendChild(opcion.cloneNode(true));
                }
            }
        });
    }

    // Función para autocompletar campos desde el registro seleccionado
    function autocompletarDesdeRegistro(option) {
        if (!option || option.value === '') return;

        campos.nombres.value = option.getAttribute('data-nombres') || '';
        campos.apellido_paterno.value = option.getAttribute('data-apellido-paterno') || '';
        campos.apellido_materno.value = option.getAttribute('data-apellido-materno') || '';
        campos.documentoUsuario.value = option.getAttribute('data-documento') || '';
        campos.emailUsuario.value = option.getAttribute('data-email') || '';
        campos.telefonoUsuario.value = option.getAttribute('data-telefono') || '';

        // CORREGIDO: Ahora sí autocompleta el género
        const genero = option.getAttribute('data-genero') || '';
        if (genero) {
            // Buscar la opción que coincida con el género
            const opcionesGenero = campos.generoUsuario.options;
            for (let i = 0; i < opcionesGenero.length; i++) {
                if (opcionesGenero[i].value === genero.toLowerCase()) {
                    campos.generoUsuario.value = genero.toLowerCase();
                    break;
                }
            }
        }

        campos.fechaNacimiento.value = option.getAttribute('data-fecha-nacimiento') || '';
    }

    // Función para cambiar el estado de los campos según el tipo de usuario
    function actualizarEstadoCampos(esJugador) {
        if (esJugador) {
            // Modo JUGADOR: mostrar grupo de jugadores, habilitar búsqueda
            grupoJugador.style.display = 'block';
            seleccionarRegistro.required = true;

            // Hacer campos de solo lectura (excepto email y teléfono)
            campos.nombres.readOnly = true;
            campos.apellido_paterno.readOnly = true;
            campos.apellido_materno.readOnly = true;
            campos.documentoUsuario.readOnly = true;
            campos.fechaNacimiento.readOnly = true;

            // Agregar estilo de fondo para indicar que son de solo lectura
            Object.values(campos).forEach(campo => {
                if (campo.readOnly) {
                    campo.classList.add('bg-light');
                }
            });

            alertText.textContent = 'Selecciona un registro para autocompletar los datos';
            btnRegistrar.innerHTML = '<i class="fas fa-user-plus me-2"></i>Registrar Jugador';

        } else {
            // Modo ENTRENADOR: ocultar grupo de jugadores, habilitar todos los campos
            grupoJugador.style.display = 'none';
            seleccionarRegistro.required = false;
            seleccionarRegistro.value = '';
            buscadorJugador.value = '';

            // Habilitar todos los campos para edición
            Object.values(campos).forEach(campo => {
                campo.readOnly = false;
                campo.classList.remove('bg-light');
                if (campo.type === 'text' && campo !== campos.emailUsuario && campo !== campos.telefonoUsuario) {
                    campo.value = '';
                }
            });

            // Limpiar campos específicos
            campos.generoUsuario.value = '';
            campos.fechaNacimiento.value = '';

            alertText.textContent = 'Completa manualmente los datos del entrenador';
            btnRegistrar.innerHTML = '<i class="fas fa-user-plus me-2"></i>Registrar Entrenador';
        }
    }

    // Eventos
    tipoUsuario.addEventListener('change', function () {
        const esJugador = this.value === 'jugador';
        actualizarEstadoCampos(esJugador);

        // Si se cambia a entrenador, restaurar el filtro
        if (!esJugador) {
            filtrarJugadores('');
        }
    });

    // Búsqueda en tiempo real
    buscadorJugador.addEventListener('input', function () {
        filtrarJugadores(this.value);
    });

    // Cuando se selecciona un jugador
    seleccionarRegistro.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        if (tipoUsuario.value === 'jugador') {
            autocompletarDesdeRegistro(selectedOption);
        }
    });

    // Estado inicial
    if (tipoUsuario.value === 'jugador') {
        actualizarEstadoCampos(true);
    } else {
        actualizarEstadoCampos(false);
    }

    // Inicializar el filtro al cargar la página
    filtrarJugadores('');
});



//<</-----------------------------------Para enviar el Gmail----------------------------------------------////>>>>
// Función para enviar credenciales - VERSIÓN CORREGIDA
// Versión alternativa más simple
function enviarCredenciales(usuarioId) {
    const boton = event.target;
    const originalText = boton.innerHTML;

    // Mostrar loading
    boton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Enviando...';
    boton.disabled = true;

    // Obtener datos del formulario
    const password = document.getElementById('passwordParaEnviar' + usuarioId).value;
    const mensaje = document.getElementById('mensajePersonalizado' + usuarioId).value;

    // Crear form data
    const formData = new FormData();
    formData.append('password', password);
    formData.append('mensaje', mensaje);
    formData.append('usuario_id', usuarioId);

    // Hacer la petición - USAR RUTA CON NOMBRE
    fetch("/enviar-credenciales", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Credenciales enviadas correctamente a ' + data.email);
                // Cerrar modal
                const modalElement = document.getElementById('compartirCredencialesModal' + usuarioId);
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
            } else {
                alert('❌ Error: ' + (data.message || 'No se pudo enviar el correo'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error de conexión: ' + error.message);
        })
        .finally(() => {
            // Restaurar botón
            boton.innerHTML = originalText;
            boton.disabled = false;
        });
}


// <-------Animaciones Graficas-------
document.addEventListener('DOMContentLoaded', function () {
    // Colores modernos para las gráficas
    const colors = {
        primary: '#3498db',
        secondary: '#2ecc71',
        success: '#27ae60',
        warning: '#f39c12',
        danger: '#e74c3c',
        info: '#9b59b6',
        dark: '#34495e',
        light: '#ecf0f1'
    };

    const gradientColors = [
        ['#3498db', '#2980b9'],
        ['#2ecc71', '#27ae60'],
        ['#e74c3c', '#c0392b'],
        ['#9b59b6', '#8e44ad'],
        ['#f39c12', '#d35400'],
        ['#1abc9c', '#16a085']
    ];

    // 1. Gráfica de Distribución de Usuarios (Doughnut mejorado)
    const usersCtx = document.getElementById('usersChart').getContext('2d');

    // Datos de ejemplo - reemplazar con datos reales
    const usersData = {
        labels: ['Jugadores', 'Entrenadores', 'Administradores', 'Invitados'],
        datasets: [{
            data: [65, 15, 10, 10],
            backgroundColor: [
                colors.primary,
                colors.success,
                colors.warning,
                colors.info
            ],
            borderColor: '#fff',
            borderWidth: 3,
            hoverBorderWidth: 4,
            hoverOffset: 10
        }]
    };

    const usersChart = new Chart(usersCtx, {
        type: 'doughnut',
        data: usersData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });

    // Actualizar leyenda
    updateUsersLegend(usersData);

    // 2. Gráfica de Estados de Usuarios (Barra horizontal mejorada)
    const statusCtx = document.getElementById('statusChart').getContext('2d');

    const statusData = {
        labels: ['Activos', 'Inactivos'],
        datasets: [{
            data: [75, 25],
            backgroundColor: [
                colors.success,
                colors.warning
            ],
            borderColor: '#fff',
            borderWidth: 2,
            borderRadius: 10,
            borderSkipped: false,
        }]
    };

    const statusChart = new Chart(statusCtx, {
        type: 'bar',
        data: statusData,
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `${context.parsed.x}%`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        display: false
                    },
                    ticks: {
                        callback: function (value) {
                            return value + '%';
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Actualizar contadores y progress bars
    updateStatusStats(statusData);

    // 3. Gráfica de Planes (Polar Area mejorada)
    const plansCtx = document.getElementById('plansChart').getContext('2d');

    const plansData = {
        labels: ['Básico', 'Premium', 'VIP', 'Empresarial', 'Estudiante'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
                colors.primary,
                colors.success,
                colors.warning,
                colors.info,
                colors.danger
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    };

    const plansChart = new Chart(plansCtx, {
        type: 'polarArea',
        data: plansData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                r: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)'
                    },
                    ticks: {
                        display: false
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });

    // Actualizar resumen de planes
    updatePlansSummary(plansData);

    // 4. Gráfica de Disciplinas (Line con área mejorada)
    const disciplinesCtx = document.getElementById('disciplinesChart').getContext('2d');

    // Crear gradiente para el área
    const gradient = disciplinesCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(52, 152, 219, 0.6)');
    gradient.addColorStop(1, 'rgba(52, 152, 219, 0.1)');

    const disciplinesData = {
        labels: ['Fútbol', 'Básquet', 'Vóley', 'Tenis', 'Natación', 'Atletismo', 'Gimnasia'],
        datasets: [{
            label: 'Participantes',
            data: [45, 30, 25, 20, 15, 10, 8],
            backgroundColor: gradient,
            borderColor: colors.primary,
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: colors.primary,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    };

    const disciplinesChart = new Chart(disciplinesCtx, {
        type: 'line',
        data: disciplinesData,
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
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#6c757d'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Actualizar lista de deportes
    updateSportsList(disciplinesData);

    // Funciones auxiliares
    function updateUsersLegend(data) {
        const legendContainer = document.getElementById('usersLegend');
        let legendHTML = '';

        data.labels.forEach((label, index) => {
            const value = data.datasets[0].data[index];
            const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
            const percentage = Math.round((value / total) * 100);

            legendHTML += `
                <div class="legend-item">
                    <span class="legend-color" style="background-color: ${data.datasets[0].backgroundColor[index]}"></span>
                    <span class="legend-label">${label}</span>
                    <span class="legend-value">${value} (${percentage}%)</span>
                </div>
            `;
        });

        legendContainer.innerHTML = legendHTML;
    }

    function updateStatusStats(data) {
        const activeCount = data.datasets[0].data[0];
        const inactiveCount = data.datasets[0].data[1];
        const total = activeCount + inactiveCount;

        document.getElementById('activeUsersCount').textContent = activeCount + '%';
        document.getElementById('inactiveUsersCount').textContent = inactiveCount + '%';

        document.getElementById('activeProgress').style.width = activeCount + '%';
        document.getElementById('inactiveProgress').style.width = inactiveCount + '%';
    }

    function updatePlansSummary(data) {
        const summaryContainer = document.getElementById('plansSummary');
        const maxValue = Math.max(...data.datasets[0].data);
        const popularPlanIndex = data.datasets[0].data.indexOf(maxValue);
        const popularPlan = data.labels[popularPlanIndex];

        summaryContainer.innerHTML = `
            <div class="summary-item">
                <i class="fas fa-crown"></i>
                <span>Plan más popular: <strong>${popularPlan}</strong></span>
            </div>
            <div class="summary-item">
                <i class="fas fa-chart-bar"></i>
                <span>Total de tipos: <strong>${data.labels.length}</strong></span>
            </div>
        `;
    }

    function updateSportsList(data) {
        const sportsContainer = document.getElementById('sportsList');
        let sportsHTML = '';

        data.labels.forEach((sport, index) => {
            const participants = data.datasets[0].data[index];
            sportsHTML += `
                <div class="sport-item">
                    <span class="sport-name">${sport}</span>
                    <span class="sport-count">${participants}</span>
                </div>
            `;
        });

        sportsContainer.innerHTML = sportsHTML;
    }

    // Efectos de hover en las tarjetas
    document.querySelectorAll('.chart-card').forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });
});


// Reportes
// Variables globales
let selectedSection = null;

// Función para seleccionar sección
function selectSection(sectionId, element) {
    console.log('Seleccionando sección:', sectionId);

    // Remover selección anterior
    document.querySelectorAll('.section-option').forEach(opt => {
        opt.classList.remove('border-blue-500', 'bg-blue-50');
        opt.classList.add('border-gray-300');
    });

    // Seleccionar actual
    element.classList.remove('border-gray-300');
    element.classList.add('border-blue-500', 'bg-blue-50');

    // Actualizar hidden input
    document.getElementById('tipoReporte').value = sectionId;
    selectedSection = sectionId;

    // Ocultar error
    document.getElementById('errorSeccion').classList.add('hidden');

    console.log('Sección seleccionada:', selectedSection);
}

// Función para enviar formulario
function submitForm(formato) {
    console.log('Intentando enviar formulario con formato:', formato);
    console.log('Sección seleccionada:', selectedSection);

    // Validar que hay una sección seleccionada
    if (!selectedSection) {
        console.error('No se ha seleccionado ninguna sección');
        document.getElementById('errorSeccion').classList.remove('hidden');
        return;
    }

    // Establecer el formato
    document.getElementById('formatoInput').value = formato;
    console.log('Formato establecido:', formato);

    // Mostrar loading en los botones
    const buttons = document.querySelectorAll('button[type="button"]');
    buttons.forEach(btn => {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generando...';
        btn.disabled = true;
    });

    console.log('Enviando formulario...');

    // Enviar formulario después de un pequeño delay para que se vea el loading
    setTimeout(() => {
        document.getElementById('formReporte').submit();
    }, 500);
}

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function () {
    console.log('Página de reportes cargada');

    // Asignar event listeners a los botones
    document.getElementById('btnPdf').addEventListener('click', function () {
        submitForm('pdf');
    });

    document.getElementById('btnExcel').addEventListener('click', function () {
        submitForm('excel');
    });

    // También mantener los onclick por compatibilidad
    document.getElementById('btnPdf').onclick = function () { submitForm('pdf'); };
    document.getElementById('btnExcel').onclick = function () { submitForm('excel'); };

    // Verificar que el formulario existe
    const form = document.getElementById('formReporte');
    if (!form) {
        console.error('❌ NO SE ENCONTRÓ EL FORMULARIO');
    } else {
        console.log('✅ Formulario encontrado');
    }
});
