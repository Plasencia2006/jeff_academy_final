<!-- NAVBAR COMPLETO Y FUNCIONAL -->
<nav class="main-nav">
  <div class="nav-container">

    <a href="{{ route('home') }}" class="logo">
      <img src="/img/logo-Jeff.png" 
           alt="Logo Jeff Academy" 
           class="logo-img">
    </a>

    <!-- HAMBURGUESA -->
    <button class="hamburger" id="hamburger" type="button" aria-label="Abrir menú" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- MENÚ NAVEGACIÓN -->
    <ul class="nav-menu" id="navMenu">
      <li><a href="{{ route('home') }}" class="nav-link">Inicio</a></li>
      <li><a href="{{ route('nosotros') }}" class="nav-link">Nosotros</a></li>
      <li><a href="{{ route('home') }}#disciplinas" class="nav-link">Disciplinas</a></li>
      <li><a href="{{ route('home') }}#instalaciones" class="nav-link">Instalaciones</a></li>
      <li><a href="{{ route('noticias.index') }}" class="nav-link">Noticias</a></li>
      <li><a href="{{ route('planes') }}" class="nav-link">Planes</a></li>
      <li><a href="{{ route('contacto') }}" class="nav-link">Contacto</a></li>

      @auth
        <li class="dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu" style="background-color: rgba(255, 255, 255, 0.98) !important;">
            <li><a class="dropdown-item" href="{{ route('dashboard') }}" target="_blank" style="color: #1f2937 !important;">Ir a mi Intranet</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="dropdown-item" style="color: #1f2937 !important;">Cerrar Sesión</button>
              </form>
            </li>
          </ul>
        </li>
      @else
        <li>
          <a href="{{ route('login') }}" target="_blank" class="btn-nav-primary">
            <span class="icon"><i class="fas fa-user"></i></span>
            <span class="text">Ingresa</span>
          </a>
        </li>
      @endauth
    </ul>
  </div>
</nav>

<!-- ============================
     🍔 SCRIPT HAMBURGUESA FUNCIONAL
     ============================ -->
<script>
  // ============================================
  // INICIALIZAR HAMBURGUESA
  // ============================================
  function initHamburgerMenu() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');

    if (!hamburger || !navMenu) {
        console.warn('Elementos del menú no encontrados');
        return;
    }

    // Click en hamburguesa
    hamburger.addEventListener('click', function(e) {
        e.stopPropagation();
        const isActive = navMenu.classList.toggle('active');
        hamburger.classList.toggle('active');
        hamburger.setAttribute('aria-expanded', isActive);
        document.body.classList.toggle('menu-open');
    });

    // Cerrar menú al hacer clic en un link
    navMenu.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (!this.classList.contains('dropdown-toggle')) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', false);
                document.body.classList.remove('menu-open');
            }
        });
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', function(event) {
        const isClickInsideNav = navMenu.contains(event.target);
        const isClickOnHamburger = hamburger.contains(event.target);
        
        if (!isClickInsideNav && !isClickOnHamburger && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            hamburger.classList.remove('active');
            hamburger.setAttribute('aria-expanded', false);
            document.body.classList.remove('menu-open');
        }
    });

    // Cerrar menú con ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            hamburger.classList.remove('active');
            hamburger.setAttribute('aria-expanded', false);
            document.body.classList.remove('menu-open');
        }
    });
    // ============================================
    // DROPDOWN CLICK HANDLER
    // ============================================
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Cerrar otros dropdowns abiertos
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                if (menu.previousElementSibling !== this) {
                    menu.classList.remove('show');
                }
            });

            // Toggle del actual
            const menu = this.nextElementSibling;
            if (menu && menu.classList.contains('dropdown-menu')) {
                menu.classList.toggle('show');
            }
        });
    });

    // Cerrar dropdowns al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

  }

  // Ejecutar cuando DOM esté listo
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHamburgerMenu);
  } else {
    initHamburgerMenu();
  }

  // ============================================
  // CAMBIO DE COLOR AL SCROLL
  // ============================================
  document.addEventListener("scroll", function() {
    const navbar = document.querySelector(".main-nav");
    
    const heroSection = 
        document.querySelector("#hero") ||
        document.querySelector(".hero-section") ||
        document.querySelector(".contacto-hero") ||
        document.querySelector(".nosotros-header") ||
        document.querySelector(".login-section") ||
        document.querySelector(".registro-section");

    if (heroSection) {
        const heroHeight = heroSection.offsetHeight;
        if (window.scrollY > heroHeight - 80) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    } else {
        if (window.scrollY > 100) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    }
  });
</script>