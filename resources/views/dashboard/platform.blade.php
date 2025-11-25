<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma - Jeff Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        a:hover,
        a:focus,
        a:active,
        a:visited {
            text-decoration: none;
        }

        body {
            font-family: 'Poppins', 'Arial', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4)),
                        url('/img/campo.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
        }

        .logo-container img {
            height: 80px;
            width: auto;
        }

        .logout-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff4757, #ff6b81);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4);
        }

        .logout-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.6);
        }

        .logout-btn i {
            font-size: 24px;
            color: white;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .buttons-container {
            display: flex;
            gap: 40px;
            margin-bottom: 80px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .platform-btn {
            width: 280px;
            height: 120px;
            background: rgba(200, 200, 200, 0.9);
            border: none;
            border-radius: 15px;
            font-size: 1.4rem;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .platform-btn:hover {
            transform: translateY(-5px);
            background: rgba(220, 220, 220, 1);
            box-shadow: 0 8px 25px rgba(229, 241, 1, 0.6);
            color: #709306ff;
            transition: all 0.3s ease;
        }

        .social-title {
            text-align: center;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .social-icons {
            display: flex;
            gap: 50px;
        }

        .social-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .social-icon.whatsapp {
            background: #25d366;
        }

        .social-icon.telegram {
            background: #0088cc;
        }

        .social-icon:hover {
            transform: scale(1.15);
        }

        .social-icon i {
            font-size: 35px;
            color: white;
        }

        footer {
            background-color: #333;
            padding: 20px;
            text-align: center;
            opacity: 0.5;
        }

        footer p {
            color: #fff;
            opacity: 4;
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }

            .logo-container img {
                height: 60px;
            }

            .logout-btn {
                width: 50px;
                height: 50px;
            }

            .logout-btn i {
                font-size: 20px;
            }

            .buttons-container {
                flex-direction: column;
                gap: 20px;
                margin-bottom: 60px;
            }

            .platform-btn {
                width: 100%;
                max-width: 300px;
            }

            .social-icons {
                gap: 20px;
            }

            .social-icon {
                width: 60px;
                height: 60px;
            }

            .social-icon i {
                font-size: 30px;
            }
        }

        /* ========== MEDIA QUERIES RESPONSIVE ========== */

        /* ESTILOS BASE - Asegurar que funcionen en todos los dispositivos */
        .buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 60px;
            justify-content: center;
            width: 100%;
            max-width: 1200px;
            padding: 0 15px;
        }

        .platform-btn {
            width: 280px;
            height: 120px;
            background: rgba(200, 200, 200, 0.9);
            border: none;
            border-radius: 15px;
            font-size: 1.4rem;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* MÓVILES PEQUEÑOS (hasta 480px) */
        @media (max-width: 480px) {
            body {
                background-attachment: scroll;
            }
            
            .header {
                padding: 12px 15px;
            }
            
            .logo-container img {
                height: 50px;
            }
            
            .logout-btn {
                width: 45px;
                height: 45px;
            }
            
            .logout-btn i {
                font-size: 18px;
            }
            
            .main-content {
                padding: 20px 10px;
            }
            
            .buttons-container {
                flex-direction: column;
                gap: 15px;
                margin-bottom: 40px;
                padding: 0 15px;
            }
            
            .platform-btn {
                width: 100%;
                max-width: 100%;
                height: 100px;
                font-size: 1.1rem;
                gap: 8px;
            }
            
            .platform-btn i {
                font-size: 1.3rem;
            }
            
            .social-title {
                font-size: 0.9rem;
                margin-bottom: 20px;
                padding: 0 10px;
            }
            
            .social-title h3 {
                line-height: 1.4;
            }
            
            .social-icons {
                gap: 20px;
                flex-wrap: wrap;
            }
            
            .social-icon {
                width: 55px;
                height: 55px;
            }
            
            .social-icon i {
                font-size: 26px;
            }
            
            footer {
                padding: 15px 10px;
            }
            
            footer p {
                font-size: 0.75rem;
            }
        }

        /* MÓVILES MEDIANOS (481px - 767px) */
        @media (min-width: 481px) and (max-width: 767px) {
            .header {
                padding: 15px 20px;
            }
            
            .logo-container img {
                height: 60px;
            }
            
            .logout-btn {
                width: 50px;
                height: 50px;
            }
            
            .logout-btn i {
                font-size: 20px;
            }
            
            .main-content {
                padding: 30px 20px;
            }
            
            .buttons-container {
                flex-direction: column;
                gap: 20px;
                margin-bottom: 50px;
                align-items: center;
            }
            
            .platform-btn {
                width: 100%;
                max-width: 350px;
                height: 110px;
                font-size: 1.25rem;
            }
            
            .social-icons {
                gap: 30px;
            }
            
            .social-icon {
                width: 60px;
                height: 60px;
            }
            
            .social-icon i {
                font-size: 30px;
            }
        }

        /* TABLETS (768px - 1024px) */
        @media (min-width: 768px) and (max-width: 1024px) {
            .header {
                padding: 18px 30px;
            }
            
            .logo-container img {
                height: 70px;
            }
            
            .logout-btn {
                width: 55px;
                height: 55px;
            }
            
            .logout-btn i {
                font-size: 22px;
            }
            
            .main-content {
                padding: 35px 25px;
            }
            
            .buttons-container {
                flex-direction: row;
                gap: 25px;
                margin-bottom: 60px;
                max-width: 800px;
            }
            
            .platform-btn {
                width: calc(50% - 15px);
                min-width: 240px;
                height: 115px;
                font-size: 1.3rem;
            }
            
            .social-icons {
                gap: 40px;
            }
        }

        /* DESKTOP (1025px en adelante) */
        @media (min-width: 1025px) {
            .header {
                padding: 20px 40px;
            }
            
            .logo-container img {
                height: 80px;
            }
            
            .logout-btn {
                width: 60px;
                height: 60px;
            }
            
            .logout-btn i {
                font-size: 24px;
            }
            
            .main-content {
                padding: 40px 20px;
            }
            
            .buttons-container {
                flex-direction: row;
                gap: 40px;
                margin-bottom: 80px;
                max-width: 1000px;
            }
            
            .platform-btn {
                width: 280px;
                height: 120px;
                font-size: 1.4rem;
            }
            
            .social-icons {
                gap: 50px;
            }
            
            .social-icon {
                width: 70px;
                height: 70px;
            }
            
            .social-icon i {
                font-size: 35px;
            }
        }

        /* PANTALLAS MUY GRANDES (1400px+) */
        @media (min-width: 1400px) {
            .buttons-container {
                gap: 50px;
                max-width: 1200px;
            }
            
            .platform-btn {
                width: 300px;
                height: 130px;
                font-size: 1.5rem;
            }
        }

        /* LANDSCAPE EN MÓVILES */
        @media (max-height: 500px) and (orientation: landscape) {
            .main-content {
                padding: 15px;
            }
            
            .buttons-container {
                margin-bottom: 20px;
                gap: 15px;
            }
            
            .platform-btn {
                height: 80px;
                font-size: 1rem;
            }
        }

        /* OPTIMIZACIÓN TÁCTIL */
        @media (hover: none) and (pointer: coarse) {
            .platform-btn {
                min-height: 100px;
            }
        }

        /* ACCESIBILIDAD */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="/img/logo-blanco.png" alt="Jeff Academy Logo">
        </div>
        <form action="{{ route('registro.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn" title="Cerrar Sesión">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>

    <div class="main-content">
        <div class="buttons-container">
            <a href="{{ route('registro.mis-datos') }}">
                <button class="platform-btn"><i class="fas fa-user"></i> Mis Datos</button>
            </a>
            <a href="{{ route('registro.elegir-plan') }}">
                <button class="platform-btn"><i class="fas fa-weight"></i> Elegir plan</button>
            </a>
            <a href="{{ route('player.dashboard') }}">
                <button class="platform-btn"><i class="fas fa-laptop"></i> Ir a mi intranet</button>
            </a>
        </div>

        <div class="social-title">
            <h3>Si tienes alguna duda puedes hacer click en uno de estos íconos</h3>
        </div>

        <div class="social-icons">
            <a href="https://wa.me/51999999999" target="_blank" class="social-icon whatsapp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://t.me/jeffacademy" target="_blank" class="social-icon telegram">
                <i class="fab fa-telegram"></i>
            </a>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <div class="footer-info">
                <p>Copyright © 2025 Jeff Academy. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
