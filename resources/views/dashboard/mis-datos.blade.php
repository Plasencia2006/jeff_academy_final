<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Datos - Jeff Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --verde-oscuro: #0d3b2e;
            --verde-medio: #1a5c3a;
            --verde-mendio: #2e7d32;
            --verde-claro: #4caf50;
            --verde-brillante: #5FDB68;
            --amarillo-brillante: #FFD700;
            --amarillo-hover: #FFC700;
            --negro: #000000;
            --negro-suave: #1a1a1a;
            --blanco: #ffffff;
            --primary-blue: var(--verde-oscuro);
            --dark-blue: var(--verde-medio);
            --light-blue: var(--verde-claro);
            --primary-red: var(--amarillo-brillante);
            --gold: var(--amarillo-brillante);
            --primary-white: #ffffff;
            --gray-light: #f8fafc;
            --gray-dark: #1f2937;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --gris-light: var(--gray-light);
            --gris-dark: var(--gray-dark);
            --fondo-suave: linear-gradient(135deg, #f8fdf9 0%, #f0f7f1 50%, #e8f2e9 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: var(--fondo-suave);
            padding: 40px 20px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            background: var(--verde-oscuro);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
            border: 2px solid var(--verde-oscuro);
        }

        .back-btn:hover {
            background: white;
            color: var(--verde-oscuro);
            transform: translateX(-5px);
        }

        .user-welcome {
            color: var(--verde-oscuro);
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 12px 20px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            margin-bottom: 40px;
        }

        .datos-card {
            background: white;
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 40px;
            animation: fadeInUp 0.6s ease;
            border: 1px solid rgba(76, 175, 80, 0.1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .datos-title {
            color: var(--verde-oscuro);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .datos-title i {
            background: linear-gradient(135deg, var(--verde-medio) 0%, var(--verde-claro) 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .datos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .dato-item {
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border-left: 4px solid var(--verde-claro);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .dato-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(46, 125, 50, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dato-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.2);
        }

        .dato-item:hover::before {
            opacity: 1;
        }

        .dato-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 700;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .dato-label i {
            color: var(--verde-claro);
            font-size: 1rem;
        }

        .dato-value {
            font-size: 1.1rem;
            color: #212529;
            font-weight: 600;
            position: relative;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .profile-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow);
            animation: fadeInRight 0.6s ease;
            border: 1px solid rgba(76, 175, 80, 0.1);
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--verde-medio) 0%, var(--verde-claro) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            font-weight: bold;
            box-shadow: 0 10px 30px rgba(46, 125, 50, 0.4);
        }

        .profile-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 5px;
        }

        .profile-email {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--verde-claro);
            display: block;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 5px;
        }

        /* Action Buttons */
        .action-buttons {
            background: white;
            border-radius: 24px;
            padding: 25px;
            box-shadow: var(--shadow);
            animation: fadeInRight 0.7s ease;
            border: 1px solid rgba(76, 175, 80, 0.1);
        }

        .action-buttons-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--verde-oscuro);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-buttons-title i {
            color: var(--verde-claro);
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            margin-bottom: 12px;
        }

        .btn-action:last-child {
            margin-bottom: 0;
        }

        .btn-logout {
            background: linear-gradient(135deg, var(--amarillo-brillante) 0%, var(--amarillo-hover) 100%);
            color: var(--negro-suave);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.4);
        }

        /* Plan Card - MEJORADO */
        .plan-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            box-shadow: var(--shadow);
            animation: fadeInRight 0.8s ease;
            border: 1px solid rgba(76, 175, 80, 0.1);
        }

        .plan-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .plan-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--amarillo-brillante) 0%, var(--amarillo-hover) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--negro-suave);
            font-size: 1.5rem;
        }

        .plan-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #212529;
        }

        .planes-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .plan-active {
            background: linear-gradient(135deg, var(--verde-medio) 0%, var(--verde-claro) 100%);
            color: white;
            padding: 20px;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }

        .plan-active::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0 0 0 60px;
        }

        .plan-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .plan-name i {
            font-size: 1.2rem;
        }

        .plan-price {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .plan-duration {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .plan-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .plan-status.active {
            background: rgba(255, 255, 255, 0.3);
        }

        .plan-status.inactive {
            background: rgba(255, 255, 255, 0.15);
        }

        .plan-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--amarillo-brillante) 0%, var(--amarillo-hover) 100%);
            color: var(--negro-suave);
            text-align: center;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
            margin-top: 15px;
        }

        .plan-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
        }

        .no-plan {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            border: 2px dashed #dee2e6;
        }

        .no-plan i {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 15px;
            display: block;
        }

        .no-plan-text {
            color: #6c757d;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .choose-plan-btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, var(--verde-medio) 0%, var(--verde-claro) 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: var(--transition);
        }

        .choose-plan-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(46, 125, 50, 0.4);
        }

        /* Scrollbar personalizado */
        .planes-container::-webkit-scrollbar {
            width: 6px;
        }

        .planes-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .planes-container::-webkit-scrollbar-thumb {
            background: var(--verde-claro);
            border-radius: 10px;
        }

        .planes-container::-webkit-scrollbar-thumb:hover {
            background: var(--verde-medio);
        }

        /* NUEVO: Tabla de Planes Adquiridos */
        .planes-table-container {
            background: white;
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 40px;
            border: 1px solid rgba(76, 175, 80, 0.1);
            margin-top: 30px;
        }

        .planes-table-title {
            color: var(--verde-oscuro);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .planes-table-title i {
            background: linear-gradient(135deg, var(--verde-medio) 0%, var(--verde-claro) 100%);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .planes-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .planes-table thead {
            background: linear-gradient(135deg, var(--verde-medio) 0%, var(--verde-claro) 100%);
            color: white;
        }

        .planes-table th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .planes-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.95rem;
        }

        .planes-table tbody tr {
            transition: var(--transition);
        }

        .planes-table tbody tr:hover {
            background: #f8fdf9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.1);
        }

        .planes-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(76, 175, 80, 0.15);
            color: #2e7d32;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        .status-inactive {
            background: rgba(158, 158, 158, 0.15);
            color: #616161;
            border: 1px solid rgba(158, 158, 158, 0.3);
        }

        .status-canceled {
            background: rgba(244, 67, 54, 0.15);
            color: #c62828;
            border: 1px solid rgba(244, 67, 54, 0.3);
        }

        .plan-name-cell {
            font-weight: 600;
            color: var(--verde-oscuro);
        }

        .plan-price-cell {
            font-weight: 600;
            color: var(--verde-medio);
        }

        .no-planes-message {
            text-align: center;
            padding: 50px 30px;
            color: #6c757d;
        }

        .no-planes-message i {
            font-size: 4rem;
            color: #adb5bd;
            margin-bottom: 20px;
            display: block;
        }

        .no-planes-message h3 {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: #495057;
        }

        .no-planes-message p {
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .sidebar {
                order: -1;
            }

            .datos-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .planes-table-container {
                overflow-x: auto;
            }

            .planes-table {
                min-width: 700px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-welcome {
                font-size: 1rem;
            }

            .datos-card, .profile-card, .plan-card, .action-buttons, .planes-table-container {
                padding: 25px;
            }

            .datos-title, .planes-table-title {
                font-size: 1.5rem;
            }

            .datos-grid {
                grid-template-columns: 1fr;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }

            .planes-table th, .planes-table td {
                padding: 12px 15px;
            }
        }

        @media (max-width: 480px) {
            .back-btn {
                padding: 10px 15px;
                font-size: 0.9rem;
            }

            .user-welcome {
                font-size: 0.9rem;
            }

            .datos-title, .planes-table-title {
                font-size: 1.3rem;
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('platform') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Volver al Dashboard
            </a>
            <div class="user-welcome">
                <i class="fas fa-user-circle"></i>
                Bienvenido, {{ $registro->nombres }}
            </div>
        </div>

        <div class="main-content">
            <!-- Datos Personales -->
            <div class="datos-card">
                <h1 class="datos-title">
                    <i class="fas fa-id-card"></i>
                    Mis Datos Personales
                </h1>
                
                <div class="datos-grid">
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-id-badge"></i>
                            Tipo de Documento
                        </div>
                        <div class="dato-value">{{ $registro->tipo_documento }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-hashtag"></i>
                            Nro. de Documento
                        </div>
                        <div class="dato-value">{{ $registro->nro_documento }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-venus-mars"></i>
                            Género
                        </div>
                        <div class="dato-value">{{ $registro->genero }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-user"></i>
                            Nombres
                        </div>
                        <div class="dato-value">{{ $registro->nombres }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-user-tag"></i>
                            Apellido Paterno
                        </div>
                        <div class="dato-value">{{ $registro->apellido_paterno }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-user-tag"></i>
                            Apellido Materno
                        </div>
                        <div class="dato-value">{{ $registro->apellido_materno }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-calendar-alt"></i>
                            Fecha de Nacimiento
                        </div>
                        <div class="dato-value">{{ \Carbon\Carbon::parse($registro->fecha_nacimiento)->format('d/m/Y') }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-mobile-alt"></i>
                            Nro. de Celular
                        </div>
                        <div class="dato-value">{{ $registro->nro_celular }}</div>
                    </div>
                    
                    <div class="dato-item">
                        <div class="dato-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </div>
                        <div class="dato-value">{{ $registro->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($registro->nombres, 0, 1)) }}{{ strtoupper(substr($registro->apellido_paterno, 0, 1)) }}
                    </div>
                    <div class="profile-name">
                        {{ $registro->nombres }} {{ $registro->apellido_paterno }}
                    </div>
                    <div class="profile-email">
                        {{ $registro->email }}
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-value">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            <span class="stat-label">Activo</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ \Carbon\Carbon::parse($registro->created_at)->format('Y') }}</span>
                            <span class="stat-label">Miembro desde</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <div class="action-buttons-title">
                        <i class="fas fa-cog"></i>
                        Acciones de Cuenta
                    </div>
                    
                    <form action="{{ route('registro.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-action btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>

                <!-- Plan Card - Resumen -->
                <div class="plan-card">
                    <div class="plan-header">
                        <div class="plan-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <div class="plan-title">Resumen de Planes</div>
                    </div>

                    @if(isset($planesAdquiridos) && $planesAdquiridos->count() > 0)
                        <div class="planes-container">
                            @php
                                $planesActivos = $planesAdquiridos->where('status', 'active')->count();
                                $totalPlanes = $planesAdquiridos->count();
                            @endphp
                            
                            <div class="plan-active">
                                <div class="plan-name">
                                    <i class="fas fa-chart-pie"></i>
                                    Resumen
                                </div>
                                <div class="plan-duration">
                                    <strong>{{ $planesActivos }}</strong> planes activos de <strong>{{ $totalPlanes }}</strong> total
                                </div>
                                <div class="plan-status active">
                                    <i class="fas fa-percentage"></i>
                                    {{ $totalPlanes > 0 ? round(($planesActivos / $totalPlanes) * 100, 0) : 0 }}% Activos
                                </div>
                            </div>
                        </div>
                        
                    @else
                        <div class="no-plan">
                            <i class="fas fa-inbox"></i>
                            <p class="no-plan-text">
                                Aún no has adquirido ningún plan.
                            </p>
                            <a href="{{ route('registro.elegir-plan') }}" class="choose-plan-btn">
                                <i class="fas fa-shopping-cart"></i>
                                Elegir Plan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- NUEVA SECCIÓN: Tabla de Planes Adquiridos -->
        <div class="planes-table-container" id="planes-table">
            <h2 class="planes-table-title">
                <i class="fas fa-table"></i>
                Mis Planes Adquiridos
            </h2>

            @if(isset($planesAdquiridos) && $planesAdquiridos->count() > 0)
                <table class="planes-table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Precio</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($planesAdquiridos as $suscripcion)
                            <tr>
                                <td class="plan-name-cell">
                                    <i class="fas fa-{{ $suscripcion->plan->tipo == 'vip' ? 'crown' : ($suscripcion->plan->tipo == 'premium' ? 'gem' : 'star') }}"></i>
                                    {{ $suscripcion->plan->nombre ?? ($suscripcion->plan_nombre ?? 'Plan no disponible') }}
                                    @if(($suscripcion->plan->descripcion ?? ($suscripcion->plan_descripcion ?? false)))
                                    <br><small style="color: #6c757d; font-size: 0.85rem;">{{ $suscripcion->plan->descripcion ?? $suscripcion->plan_descripcion }}</small>
                                    @endif
                                </td>
                                <td class="plan-price-cell">
                                    ${{ number_format($suscripcion->plan->precio ?? ($suscripcion->plan_precio ?? 0), 2) }}
                                </td>
                                <td>
                                    {{ $suscripcion->plan->duracion ?? ($suscripcion->plan_duracion ?? 1) }} meses
                                </td>
            
                    <td>
                                    @php
                                        $statusClass = 'status-inactive';
                                        if (($suscripcion->status ?? 'inactive') == 'active') {
                                            $statusClass = 'status-active';
                                        } elseif (($suscripcion->status ?? 'inactive') == 'canceled') {
                                            $statusClass = 'status-canceled';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="fas fa-{{ ($suscripcion->status ?? 'inactive') == 'active' ? 'check-circle' : (($suscripcion->status ?? 'inactive') == 'canceled' ? 'times-circle' : 'clock') }}"></i>
                                        {{ ucfirst($suscripcion->status ?? 'inactivo') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $suscripcion->start_date ? \Carbon\Carbon::parse($suscripcion->start_date)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td>
                                    {{ $suscripcion->end_date ? \Carbon\Carbon::parse($suscripcion->end_date)->format('d/m/Y') : 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-planes-message">
                    <i class="fas fa-inbox"></i>
                    <h3>No has adquirido ningún plan</h3>
                    <p>Explora nuestros planes disponibles y comienza tu entrenamiento con Jeff Academy.</p>
                    <a href="{{ route('registro.elegir-plan') }}" class="choose-plan-btn">
                        <i class="fas fa-shopping-cart"></i>
                        Explorar Planes Disponibles
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Script para suavizar el scroll al hacer clic en el enlace de la tabla
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>