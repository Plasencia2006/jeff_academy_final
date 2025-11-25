<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Credenciales de Acceso</title>
</head>
<body>
    <h2>Credenciales de Acceso - {{ config('app.name') }}</h2>
    
    <p>Hola <strong>{{ $usuario->name }}</strong>,</p>
    
    <p>Aquí tienes tus credenciales de acceso al sistema:</p>
    
    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #007bff;">
        <h4 style="margin-top: 0;">Tus Credenciales:</h4>
        <p><strong>Nombre de Usuario:</strong> {{ $usuario->name }}</p>
        <p><strong>Email:</strong> {{ $usuario->email }}</p>
        <p><strong>Contraseña:</strong> {{ $password_enviar }}</p>
    </div>

    @if(!empty($mensaje_personalizado))
    <div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0; border-left: 4px solid #17a2b8;">
        <p><strong>Mensaje Personalizado:</strong><br>{{ $mensaje_personalizado }}</p>
    </div>
    @endif

    <p style="color: #6c757d; font-size: 14px;">
        Saludos,<br>
        <strong>Equipo de {{ config('app.name') }}</strong>
    </p>
</body>
</html>