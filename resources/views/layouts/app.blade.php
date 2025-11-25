<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Jeff Academy - Formando Futuros Campeones')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CSS Específicos -->
    <link rel="stylesheet" href="{{ asset('css/footer-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/galery-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/preguntas-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/chat-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/testimonios-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/hero-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/diciplinas-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/nosotros-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/contacto-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/camino-ct-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/noticias-style.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    @include('components.navbar')

    <!-- Mensajes de sesión (toast fijo, no desplaza el contenido) -->
    <div style="position: fixed; top: 20px; right: 20px; z-index: 1080; width: 360px; max-width: calc(100% - 40px);">
        @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
    <!-- Contenido Principal -->
    @yield('content')
    <!-- Footer -->
    @include('components.footer')
    <!-- Bootstrap JS Bundle (Required for Modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // Auto-cerrar alerts después de 4 segundos
        window.addEventListener('load', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alertEl) {
                setTimeout(function() {
                    alertEl.classList.remove('show');
                    // Remover del DOM tras la transición
                    setTimeout(function() {
                        alertEl.remove();
                    }, 300);
                }, 4000);
            });
        });
    </script>
    @stack('scripts')

    <!-- BOTÓN WHATSAPP -->
    <a href="https://wa.me/{{ str_replace([' ', '+', '-', '(', ')'], '', $config->telefono) }}?text=¡Hola!%20Quiero%20más%20información%20sobre%20Jeff%20Academy."
        class="whatsapp-float"
        target="_blank"
        aria-label="Chat en WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- BOTÓN DEL CHATBOT -->
    <button class="chatbot-btn" id="openChatbot">
        <i class="fas fa-comment-dots"></i>
    </button>
    <!-- VENTANA DEL CHATBOT -->
    <div class="chatbot-window" id="chatbotWindow" style="display:none;">
        <div class="chatbot-header">
            <span><i class="fas fa-robot me-2"></i>Asistente JEFF Academy</span>
            <button id="closeChatbot"><i class="fas fa-times"></i></button>
        </div>
        <div class="chatbot-body" id="chatbotBody">
            <div class="bot-message intro">
                👋 ¡Hola! Soy el asistente virtual de Jeff Academy.<br>
                ¿En qué puedo ayudarte hoy?
            </div>
        </div>
        <div class="chatbot-footer">
            <input type="text" id="userInput" placeholder="Escribe tu pregunta..." />
            <button id="sendMessage"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <!-- ENLACES -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>


    <script>
        window.onload = function() {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>