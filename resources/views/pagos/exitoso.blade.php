<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso - Jeff Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .success-container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .success-icon {
            color: #2e7d32;
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1>¡Inscripción Exitosa!</h1>
        <p>Te has inscrito al plan <strong>{{ $plan_nombre }}</strong></p>
        <p>Monto: <strong>S/. {{ number_format($amount_total, 2) }}</strong></p>
        <p>ID de transacción: <code>{{ $session_id }}</code></p>
        <a href="{{ route('platform') }}" class="btn-primary">
            <i class="fas fa-rocket"></i> Ir a la Plataforma
        </a>
    </div>
</body>
</html>