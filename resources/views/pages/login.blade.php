<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Jeff Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4)),
                        url('/img/sintetico.jpg');
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

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-container {
            background: transparent;
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        .logo-form {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-form img {
            height: 90px;
            width: auto;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.5));
        }

        .form-title {
            text-align: center;
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px;
            border: none;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: #fff;
            border-radius: 0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            border-bottom-color: #4caf50;
        }

        .form-control option {
            background: #2e7d32;
            color: #fff;
        }

        /* Mensajes de error */
        .form-control.is-invalid {
            border-bottom-color: rgba(220, 53, 69, 0.8);
        }

        .invalid-feedback {
            display: block;
            color: #ffcdd2;
            font-size: 0.875rem;
            margin-top: 5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .btn-login {
            padding: 15px 50px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 0;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-container {
            text-align: left;
        }

        /* Mensajes de alerta */
        .alert {
            padding: 15px 20px;
            border-radius: 0;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.3);
            color: #fff;
            border-left: 4px solid #4caf50;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.3);
            color: #fff;
            border-left: 4px solid #dc3545;
        }

        footer {
            background-color: rgba(59, 133, 23, 0.5);
            backdrop-filter: blur(10px);
            padding: 20px;
            text-align: center;
        }

        footer p {
            color: #fff;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }

            .logo-container img {
                height: 60px;
            }

            .login-container {
                padding: 30px 20px;
            }

            .logo-form img {
                height: 70px;
            }

            .form-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="login-container">
            <div class="logo-form">
                <a href="{{ route('home') }}" title="Volver al Inicio"><img src="/img/logo-blanco.png" alt="Jeff Academy"></a>
            </div>
            <h2 class="form-title">Acceso al Intranet</h2>

            @if($message = Session::get('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ $message }}
                </div>
            @endif

            @if($message = Session::get('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </div>
            @endif
            
            <form action="{{ route('do.login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <input type="email" 
                           name="email" 
                           id="email"
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}"
                           placeholder="Correo*" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Clave*" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <select name="role" 
                            id="role"
                            class="form-control @error('role') is-invalid @enderror" 
                            required>
                        <option value="">Rol*</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="coach" {{ old('role') == 'coach' ? 'selected' : '' }}>Entrenador</option>
                        <option value="player" {{ old('role') == 'player' ? 'selected' : '' }}>Jugador</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Ingresar
                    </button>
                </div>
            </form>
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