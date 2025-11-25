// Inicializar AOS (Animate On Scroll)
AOS.init({
    duration: 800,
    easing: 'ease-in-out-cubic',
    offset: 100,
    once: true
});

// Funcionalidad del menú hamburguesa
/*
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');

hamburger.addEventListener('click', () => {
    navMenu.classList.toggle('active');
});*/

// Cerrar menú al hacer clic en un enlace
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
    });
});

// Efecto de estrellas en el hero
function createStars() {
    const starsContainer = document.querySelector('.stars');
    for (let i = 0; i < 50; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.width = Math.random() * 2 + 1 + 'px';
        star.style.height = star.style.width;
        star.style.animationDelay = Math.random() * 3 + 's';
        starsContainer.appendChild(star);
    }
}

createStars();

// Smooth scrolling mejorado
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href === '#') return;
        
        e.preventDefault();
        const target = document.querySelector(href);
        
        if (target) {
            const offsetTop = target.offsetTop - 70;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// Función de Login
function doLogin(event) {
    event.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;

    // Validación básica
    if (!email || !password || !role) {
        showNotification('Por favor completa todos los campos', 'error');
        return false;
    }

    // Simulación de login con animación
    showNotification(`Iniciando sesión como ${role}...`, 'info');
    
    setTimeout(() => {
        switch (role) {
            case 'admin':
                window.location.href = 'admin.html';
                break;
            case 'coach':
                window.location.href = 'entrenador.html';
                break;
            case 'player':
                window.location.href = 'player.html';
                break;
            case 'parent':
                window.location.href = 'parent.html';
                break;
            default:
                showNotification('Rol no válido', 'error');
        }
    }, 1000);

    return false;
}

// Función de Registro
function doRegister(event) {
    event.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('regEmail').value;
    const password = document.getElementById('regPass').value;
    const role = document.getElementById('regRole').value;

    // Validaciones
    if (!name || !email || !password || !role) {
        showNotification('Por favor completa todos los campos', 'error');
        return false;
    }

    if (password.length < 4) {
        showNotification('La contraseña debe tener al menos 4 caracteres', 'error');
        return false;
    }

    if (!email.includes('@gmail.com')) {
        showNotification('Por favor usa un correo Gmail válido', 'error');
        return false;
    }

    // Simulación de registro
    showNotification(`¡Registro exitoso! Bienvenido ${name}`, 'success');
    
    setTimeout(() => {
        event.target.reset();
        showNotification('Redirigiendo...', 'info');
    }, 1500);

    return false;
}

// Función para mostrar notificaciones mejorada
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${getIcon(type)}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Mostrar con animación
    setTimeout(() => notification.classList.add('show'), 10);
    
    // Eliminar después de 3 segundos
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Función auxiliar para obtener icono según tipo
function getIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'info': 'info-circle',
        'warning': 'exclamation-triangle'
    };
    return icons[type] || 'info-circle';
}

// Agregar estilos para notificaciones
const notificationStyles = `
    .notification {
        position: fixed;
        top: 20px;
        right: -400px;
        background: white;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        transition: right 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 300px;
    }

    .notification.show {
        right: 20px;
    }

    .notification-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notification-success {
        border-left: 4px solid #4caf50;
    }

    .notification-success i {
        color: #4caf50;
    }

    .notification-error {
        border-left: 4px solid #f44336;
    }

    .notification-error i {
        color: #f44336;
    }

    .notification-info {
        border-left: 4px solid #2196f3;
    }

    .notification-info i {
        color: #2196f3;
    }

    .notification-warning {
        border-left: 4px solid #ff9800;
    }

    .notification-warning i {
        color: #ff9800;
    }

    @media (max-width: 576px) {
        .notification {
            min-width: auto;
            width: calc(100% - 40px);
            right: -100vw;
            left: 20px;
        }

        .notification.show {
            right: auto;
            left: 20px;
        }
    }
`;

const styleSheet = document.createElement('style');
styleSheet.textContent = notificationStyles;
document.head.appendChild(styleSheet);

// Datos de noticias
const noticias = [
    {
        titulo: "Jeff Academy Gana Torneo Regional Sub-14",
        categoria: "Logros",
        fecha: "15 Sept 2025",
        imagen: "https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80",
        resumen: "Nuestro equipo de fútbol Sub-14 se coronó campeón del torneo regional tras una emocionante final."
    },
    {
        titulo: "Nuevo Programa de Entrenamiento Personalizado",
        categoria: "Servicios",
        fecha: "10 Sept 2025",
        imagen: "https://images.unsplash.com/photo-1536922246289-88c42f957773?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80",
        resumen: "Implementamos un innovador sistema de entrenamiento personalizado para todos nuestros deportistas."
    },
    {
        titulo: "Inscripciones Abiertas para Temporada 2025",
        categoria: "Inscripciones",
        fecha: "5 Sept 2025",
        imagen: "https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80",
        resumen: "Ya están abiertas las inscripciones para la nueva temporada 2025 en todas las disciplinas."
    },
    {
        titulo: "Charla con Ex-Futbolista Profesional",
        categoria: "Eventos",
        fecha: "1 Sept 2025",
        imagen: "https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80",
        resumen: "Próxima charla motivacional con un ex-futbolista profesional para nuestros jóvenes talentos."
    }
];

// Cargar noticias en la página
function cargarNoticias() {
    const noticiasGrid = document.getElementById('noticias-grid');
    
    if (!noticiasGrid) return;

    noticias.forEach((noticia, index) => {
        const noticiaHTML = `
            <div class="noticia-card" data-aos="fade-up" data-aos-delay="${index * 100}">
                <div class="noticia-imagen">
                    <img src="${noticia.imagen}" alt="${noticia.titulo}">
                </div>
                <div class="noticia-contenido">
                    <span class="noticia-categoria">${noticia.categoria}</span>
                    <h3 class="noticia-titulo">${noticia.titulo}</h3>
                    <p class="noticia-fecha">${noticia.fecha}</p>
                    <p class="noticia-resumen">${noticia.resumen}</p>
                    <a href="#" class="btn-noticia">Leer más</a>
                </div>
            </div>
        `;
        noticiasGrid.innerHTML += noticiaHTML;
    });
}

// Cargar noticias cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', cargarNoticias);

// Agregar efecto parallax al hero
window.addEventListener('scroll', () => {
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        const scrollPosition = window.scrollY;
        heroSection.style.backgroundPosition = `center ${scrollPosition * 0.5}px`;
    }
});

// Animar números de estadísticas al entrar en vista
const observerOptions = {
    threshold: 0.5
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const stats = entry.target.querySelectorAll('.stat-item h3');
            stats.forEach(stat => {
                animateCounter(stat);
            });
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

const statsSection = document.querySelector('.stats');
if (statsSection) {
    observer.observe(statsSection);
}

function animateCounter(element) {
    const target = parseInt(element.textContent);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target + '+';
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Efectos adicionales de interactividad
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transition = 'all 0.3s ease';
    });
});

// FAQ Toggle
document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        if (question) {
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                
                // Cerrar todos los FAQs
                faqItems.forEach(faq => faq.classList.remove('active'));
                
                // Abrir el clickeado si no estaba activo
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        }
    });

    // Animación de contadores en el hero
    const heroCounters = document.querySelectorAll('.stat-number');
    if (heroCounters.length > 0) {
        const speed = 200;

        heroCounters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target + '+';
                }
            };

            // Iniciar animación cuando el elemento es visible
            const observerCounter = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCount();
                        observerCounter.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            observerCounter.observe(counter);
        });
    }
});

// Modal de Contacto
document.addEventListener('DOMContentLoaded', function() {
    const contactBtn = document.getElementById('contacto-btn');
    const contactModal = document.getElementById('contactModal');
    const closeModal = document.getElementById('closeModal');
    const contactForm = document.getElementById('contactForm');

    // Abrir modal
    if (contactBtn) {
        contactBtn.addEventListener('click', function(e) {
            e.preventDefault();
            contactModal.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    }

    // Cerrar modal
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            contactModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        });
    }

    // Cerrar modal al hacer clic fuera
    if (contactModal) {
        contactModal.addEventListener('click', function(e) {
            if (e.target === contactModal) {
                contactModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    }

    // Manejar envío del formulario
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            const nombre = formData.get('nombre');
            const email = formData.get('email');
            const mensaje = formData.get('mensaje');

            // Validación básica
            if (!nombre || !email || !mensaje) {
                showNotification('Por favor completa todos los campos requeridos', 'error');
                return;
            }

            // Simular envío exitoso
            showNotification('¡Mensaje enviado exitosamente! Te contactaremos pronto.', 'success');
            
            // Limpiar formulario y cerrar modal
            contactForm.reset();
            setTimeout(() => {
                contactModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }, 2000);
        });
    }

    // Dropdown menus para móvil: usar clase 'open'
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                const dropdown = this.closest('.dropdown');
                const isOpen = dropdown.classList.contains('open');
                // Cerrar todos
                document.querySelectorAll('.dropdown.open').forEach(d => d.classList.remove('open'));
                // Abrir el actual si no estaba abierto
                if (!isOpen) dropdown.classList.add('open');
            }
        });
    });
});

// Log de inicialización
console.log('%cJeff Academy - Sistema Iniciado', 'color: #1e3a8a; font-size: 16px; font-weight: bold;');
console.log('%cVersión 4.0 - Diseño Cantolao con Modal de Contacto', 'color: #dc2626; font-size: 12px;');