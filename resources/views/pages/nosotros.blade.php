@extends('layouts.app')
@section('title', 'Nosotros - Jeff Academy')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/nosotros.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')

<!-- ==================== SECCIÓN CTA SUPERIOR CON IMAGEN ====================-->
<section class="nosotros-cta-top" style="background-image: url('{{ asset('img/hero-nos.png') }}'); margin-top: 70px; min-height: 300px; height: 300px; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; position: relative;">
    <div class="cta-top-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5);"></div>
    <div class="cta-top-content" style="position: relative; z-index: 2; text-align: center; padding: 40px 20px; color: #fff;">
        <h2 class="cta-top-title" style="font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; margin: 0 0 16px 0; line-height: 1.2; text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">
            ¿QUIERES SER PARTE<br>DEL EQUIPO?
        </h2>
        <p class="cta-top-subtitle" style="font-size: clamp(1rem, 2vw, 1.2rem); margin: 0; max-width: 600px; margin: 0 auto; text-shadow: 1px 1px 4px rgba(0,0,0,0.3);">
            Únete a nuestra familia deportiva y alcanza tu máximo potencial
        </p>
    </div>
</section>

<!-- ==================== SECCIÓN PRINCIPAL ====================-->
<section class="nosotros-hero-section">
    <div class="nosotros-hero-left">
        <h1>JEFF ACADEMY<br><span>FÚTBOL</span></h1>

        <p class="nosotros-hero-intro">
            Somos una academia de fútbol con más de 5 años impulsando el talento deportivo, formando niños, jóvenes y adultos que viven con pasión el deporte rey.
        </p>
        
        <p class="nosotros-hero-text">
            Contamos con grupos formativos y competitivos diseñados para cada etapa de crecimiento, promoviendo el desarrollo técnico, físico y emocional de nuestros deportistas.
        </p>

        <p class="nosotros-hero-text">
            Nuestro modelo de enseñanza integra disciplina, respeto y trabajo en equipo, valores que fortalecen el carácter de nuestros alumnos dentro y fuera del campo.
        </p>

        <p class="nosotros-hero-text">
            A través de entrenamientos personalizados y metodologías modernas, potenciamos las habilidades de cada jugador para que alcance su máximo rendimiento.
        </p>

        <p class="nosotros-hero-text">
            Más que una academia, somos una familia deportiva comprometida en construir futuros profesionales que puedan destacar en clubes, torneos y competencias nacionales.
        </p>

        <div class="nosotros-hero-features">
            <div class="hero-feature">
                <i class="fas fa-medal"></i>
                <span>Entrenadores Certificados</span>
            </div>
            <div class="hero-feature">
                <i class="fas fa-users-cog"></i>
                <span>Grupos Personalizados</span>
            </div>
        </div>
    </div>
    
    <div class="nosotros-hero-right">
        <div class="nosotros-video-wrapper">
            <iframe
                src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F599993789382210%2F&show_text=true&width=267&t=0"
                width="267" height="591" style="border:none;overflow:hidden"
                scrolling="no" frameborder="0" allowfullscreen="true"
                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
            </iframe>
        </div>
    </div>
</section>

<!-- ==================== MISIÓN Y VISIÓN ====================-->
<section class="nosotros-mission-section">
    <div class="mission-header">
        <h2>NUESTRA ESENCIA</h2>
    </div>
    
    <div class="mission-grid">
        <div class="mission-card">
            <div class="mission-icon"><i class="fas fa-bullseye"></i></div>
            <h3>Misión</h3>
            <p>Formar futbolistas integrales con metodologías modernas, desarrollando habilidades técnicas y valores humanos.</p>
        </div>
        
        <div class="mission-card">
            <div class="mission-icon"><i class="fas fa-eye"></i></div>
            <h3>Visión</h3>
            <p>Ser la academia de fútbol líder, destacándose por excelencia en formación de talentos deportivos.</p>
        </div>

        <div class="mission-card">
            <div class="mission-icon"><i class="fas fa-flag-checkered"></i></div>
            <h3>Objetivo</h3>
            <p>Brinda educación deportiva de primer nivel para que nuestros alumnos alcancen su máximo potencial.</p>
        </div>
    </div>
</section>

<!-- ==================== FILOSOFÍA ====================-->
<section class="nosotros-philosophy-section">
    <div class="nosotros-philosophy-left">
        <img src="{{ asset('img/nosotros.jpg') }}" alt="Jeff Academy">
        <div class="philosophy-decoration"></div>
    </div>
    
    <div class="nosotros-philosophy-right">
        <h3>FILOSOFÍA DEPORTIVA</h3>
        
        <div class="philosophy-quote">
            EL DEPORTE TE ENTRENA PARA LA VIDA
        </div>
        
        <p>
            El fútbol es una herramienta educativa que brinda aprendizaje en valores fundamentales. Cada entrenamiento contribuye al crecimiento personal, enseñando que el esfuerzo y trabajo en equipo son claves del éxito.
        </p>
    </div>
</section>

<!-- ==================== VALORES ====================-->
<section class="nosotros-values-section">
    <div class="values-header">
        <h2>NUESTROS <span>VALORES</span></h2>
    </div>
    
    <div class="values-grid">
        <div class="value-card">
            <div class="value-icon"><i class="fas fa-handshake"></i></div>
            <h4>Respeto</h4>
            <p>Base de toda convivencia deportiva.</p>
        </div>
        
        <div class="value-card">
            <div class="value-icon"><i class="fas fa-clock"></i></div>
            <h4>Disciplina</h4>
            <p>Forja el carácter de campeones.</p>
        </div>
        
        <div class="value-card">
            <div class="value-icon"><i class="fas fa-people-carry"></i></div>
            <h4>Trabajo en Equipo</h4>
            <p>Logros conseguidos juntos.</p>
        </div>
        
        <div class="value-card">
            <div class="value-icon"><i class="fas fa-mountain"></i></div>
            <h4>Perseverancia</h4>
            <p>Nunca rendirse, celebrar progreso.</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// ==================== SCROLL AL INICIO ====================
(function() {
    window.scrollTo(0, 0);
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;
})();

// ==================== INTERSECTION OBSERVER ====================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

function createAnimationObserver(selector, animationClass, delayBetween = 150) {
    const elements = document.querySelectorAll(selector);
    
    if (elements.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                setTimeout(() => {
                    entry.target.classList.add('animated', animationClass);
                    entry.target.style.opacity = '1';
                }, index * delayBetween);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    elements.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
}

// ==================== INICIALIZAR ANIMACIONES ====================
function initAnimations() {
    createAnimationObserver('.cta-top-content', 'fade-in-up', 0);
    createAnimationObserver('.nosotros-header-content', 'fade-in-up', 0);
    createAnimationObserver('.nosotros-hero-badge', 'scale-in', 0);
    createAnimationObserver('.nosotros-hero-left h1', 'fade-in-left', 100);
    createAnimationObserver('.nosotros-hero-intro', 'fade-in-left', 200);
    createAnimationObserver('.nosotros-hero-text', 'fade-in-left', 100);
    createAnimationObserver('.hero-feature', 'fade-in-up', 150);
    createAnimationObserver('.nosotros-hero-right', 'fade-in-right', 0);
    createAnimationObserver('.mission-header h2', 'slide-down', 0);
    createAnimationObserver('.mission-card', 'fade-in-up', 200);
    createAnimationObserver('.nosotros-philosophy-left', 'fade-in-left', 0);
    createAnimationObserver('.nosotros-philosophy-right h3', 'fade-in-right', 100);
    createAnimationObserver('.philosophy-quote', 'fade-in-right', 200);
    createAnimationObserver('.nosotros-philosophy-right p', 'fade-in-right', 100);
    createAnimationObserver('.values-header h2', 'slide-down', 0);
    createAnimationObserver('.value-card', 'fade-in-up', 150);
}

// ==================== EFECTO PARALLAX ====================
function initParallax() {
    const hero = document.querySelector('.nosotros-header-hero');
    
    let ticking = false;
    
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const scrollPosition = window.pageYOffset;
                if (hero) {
                    hero.style.backgroundPosition = center ${scrollPosition * 0.5}px;
                }
                ticking = false;
            });
            ticking = true;
        }
    });
}

// ==================== HOVER EFFECTS ====================
function initCardHovers() {
    const cards = document.querySelectorAll('.mission-card, .value-card, .hero-feature');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
        });
    });
}

// ==================== PREVENIR SCROLL DURANTE CARGA ====================
function preventScrollOnLoad() {
    const style = document.createElement('style');
    style.textContent = `
        html.loading {
            overflow: hidden !important;
            height: 100vh !important;
        }
        body.loading {
            overflow: hidden !important;
            height: 100vh !important;
        }
    `;
    document.head.appendChild(style);
    
    document.documentElement.classList.add('loading');
    document.body.classList.add('loading');
    
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.documentElement.classList.remove('loading');
            document.body.classList.remove('loading');
            window.scrollTo(0, 0);
        }, 100);
    });
}

// ==================== INICIALIZACIÓN ====================
preventScrollOnLoad();

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.scrollTo(0, 0);
        initAnimations();
        initParallax();
        initCardHovers();
    });
} else {
    window.scrollTo(0, 0);
    initAnimations();
    initParallax();
    initCardHovers();
}

window.addEventListener('beforeunload', () => {
    window.scrollTo(0, 0);
});

window.addEventListener('load', () => {
    setTimeout(() => {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'instant'
        });
    }, 50);
});
</script>
@endpush