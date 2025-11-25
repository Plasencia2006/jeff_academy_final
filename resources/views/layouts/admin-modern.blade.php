<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Administración - Jeff Academy')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js para interactividad -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Animaciones personalizadas */
        @keyframes slideIn {
            from { 
                transform: translateX(100%);
                opacity: 0;
            }
            to { 
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        
        /* Colores personalizados de Jeff Academy para administradores */
        .bg-jeff-admin { background-color: #035d4b; }
        .text-jeff-admin { color: #035d4b; }
        .border-jeff-admin { border-color: #035d4b; }
        .hover\:bg-jeff-admin:hover { background-color: #035d4b; }
        
        /* Scrollbar personalizado */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'jeff-admin': '#035d4b',
                        'jeff-admin-light': '#047857',
                        'jeff-admin-dark': '#001d16'
                    }
                }
            }
        }
    </script>
    
    @stack('styles')
</head>

<body class="h-full" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
    <div class="flex h-full">
        <!-- Sidebar -->
        @include('layouts.partials.admin-sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('layouts.partials.admin-header')
            
            <!-- Mensajes de sesión flotantes (toast) -->
            <div style="position: fixed; top: 80px; right: 20px; z-index: 1080; width: 360px; max-width: calc(100% - 40px);">
                @if($message = Session::get('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-lg animate-slide-in" role="alert" id="success-toast">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ $message }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.parentElement.remove()" class="ml-4 text-green-700 hover:text-green-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif

                @if($message = Session::get('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg shadow-lg animate-slide-in" role="alert" id="error-toast">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>{{ $message }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-700 hover:text-red-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 custom-scrollbar">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Auto-cerrar toasts después de 4 segundos -->
    <script>
        window.addEventListener('load', function() {
            const toasts = document.querySelectorAll('[id$="-toast"]');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    toast.style.transition = 'opacity 0.3s ease-out';
                    toast.style.opacity = '0';
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 4000);
            });
        });
    </script>
    
    <!-- Scripts adicionales -->
    @stack('scripts')
</body>
</html>
