<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegir Plan - Jeff Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --verde-oscuro: #1a3a2a;
            --verde-medio: #2e7d32;
            --verde-claro: #4caf50;
            --azul-stripe: #635bff;
            --azul-stripe-hover: #544fe7;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-premium: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
            --border-radius: 20px;
        }

        body {
            font-family: 'Inter', 'Arial', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4efe9 100%);
            padding: 40px 20px;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 28px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            color: #333;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .back-btn:hover {
            background: white;
            transform: translateX(-5px);
            box-shadow: var(--shadow-hover);
        }

        .planes-title {
            text-align: center;
            background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-medio));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .planes-subtitle {
            text-align: center;
            color: #666;
            font-size: 1.2rem;
            font-weight: 400;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .planes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 35px;
        }

        .plan-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
        }

        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .plan-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: var(--shadow-hover);
        }

        .plan-card:hover::before {
            opacity: 1;
        }

        .plan-popular {
            border: 2px solid transparent;
            background: linear-gradient(white, white), var(--gradient-success);
            background-origin: border-box;
            background-clip: padding-box, border-box;
            transform: scale(1.05);
        }

        .plan-popular:hover {
            transform: translateY(-12px) scale(1.07);
        }

        .plan-header {
            background: var(--gradient-primary);
            color: #fff;
            padding: 30px 25px;
            text-align: center;
            position: relative;
        }

        .plan-popular .plan-header {
            background: var(--gradient-success);
        }

        .plan-header h3 {
            font-size: 1.5rem;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .plan-header p {
            font-weight: 800;
            font-size: 2.2rem;
            margin: 8px 0;
        }

        .plan-header small {
            font-size: 0.9rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .plan-features {
            list-style: none;
            padding: 30px 25px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            color: #555;
            flex: 1;
        }

        .plan-features li {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            transition: transform 0.2s ease;
        }

        .plan-features li:hover {
            transform: translateX(5px);
        }

        .plan-features i {
            color: var(--verde-medio);
            margin-top: 3px;
            font-size: 1.1rem;
        }

        .plan-footer {
            padding: 0 25px 30px;
        }

        .btn-stripe {
            width: 100%;
            padding: 18px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn-stripe::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-stripe:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(99, 91, 255, 0.4);
        }

        .btn-stripe:hover::before {
            left: 100%;
        }

        .plan-popular .btn-stripe {
            background: var(--gradient-success);
        }

        .popular-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gradient-success);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .price-period {
            display: block;
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.9;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .planes-title {
                font-size: 2.2rem;
            }
            
            .planes-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .plan-popular {
                transform: none;
            }
            
            .plan-popular:hover {
                transform: translateY(-8px);
            }
            
            .container {
                padding: 0 10px;
            }
            
            body {
                padding: 20px 10px;
            }
        }

        @media (max-width: 480px) {
            .planes-title {
                font-size: 1.8rem;
            }
            
            .plan-header {
                padding: 25px 20px;
            }
            
            .plan-features {
                padding: 25px 20px;
            }
        }

        /* Animación de aparición */
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

        .plan-card {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .plan-card:nth-child(1) { animation-delay: 0.1s; }
        .plan-card:nth-child(2) { animation-delay: 0.2s; }
        .plan-card:nth-child(3) { animation-delay: 0.3s; }
        .plan-card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('platform') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Volver a la Plataforma
            </a>
        </div>

        <h1 class="planes-title">Elige tu Plan de Suscripción</h1>
        <p class="planes-subtitle">Selecciona el plan que mejor se adapte a tus necesidades de formación deportiva</p>

        @if($planes && $planes->count() > 0)
            <div class="planes-grid">
                @foreach($planes as $index => $plan)
                <div class="plan-card {{ $index === 0 ? 'plan-popular' : '' }}">
                    @if($index === 0)
                        <div class="popular-badge">
                            <i class="fas fa-crown"></i> Más Popular
                        </div>
                    @endif
                    
                    <div class="plan-header">
                        <h3>{{ $plan->nombre }}</h3>
                        <p>S/. {{ number_format($plan->precio, 2) }}</p>
                        <small>por mes</small>
                        <span class="price-period">Facturación mensual</span>
                    </div>
                    
                    <ul class="plan-features">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span><strong>Duración:</strong> {{ $plan->duracion ?? 1 }} mes(es)</span>
                        </li>
                        <li>
                            <i class="fas fa-star"></i>
                            <span><strong>Tipo:</strong> {{ ucfirst($plan->tipo ?? 'Básico') }}</span>
                        </li>
                        <li>
                            <i class="fas fa-bolt"></i>
                            <span><strong>Estado:</strong> {{ ucfirst($plan->estado ?? 'Activo') }}</span>
                        </li>
                        @if(!empty($plan->descripcion))
                        <li>
                            <i class="fas fa-info-circle"></i>
                            <span>{{ $plan->descripcion }}</span>
                        </li>
                        @endif
                        @if(!empty($plan->beneficios))
                        <li>
                            <i class="fas fa-gift"></i>
                            <span>{{ $plan->beneficios }}</span>
                        </li>
                        @endif
                        <li>
                            <i class="fas fa-shield-alt"></i>
                            <span>Acceso completo a todas las disciplinas</span>
                        </li>
                        <li>
                            <i class="fas fa-headset"></i>
                            <span>Soporte prioritario 24/7 incluido</span>
                        </li>
                    </ul>
                    
                    <div class="plan-footer">
                        <form action="{{ route('payment.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button type="submit" class="btn-stripe">
                                <i class="fas fa-credit-card"></i>
                                Comenzar por S/. {{ number_format($plan->precio, 2) }}
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px;">
                <div style="font-size: 4rem; color: #ddd; margin-bottom: 20px;">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 style="color: #666; margin-bottom: 15px; font-weight: 600;">No hay planes disponibles</h3>
                <p style="color: #888; max-width: 400px; margin: 0 auto;">Actualmente no tenemos planes activos. Vuelve pronto para conocer nuestras opciones.</p>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const planName = this.closest('.plan-card').querySelector('.plan-header h3').textContent;
                    const planPrice = this.closest('.plan-card').querySelector('.plan-header p').textContent;
                    
                    if (confirm(`¿Confirmas que deseas suscribirte al plan "${planName.trim()}" por ${planPrice.trim()} mensuales?`)) {
                        const button = this.querySelector('.btn-stripe');
                        const originalText = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                        button.disabled = true;
                        
                        // Pequeña pausa para mostrar el estado de carga
                        setTimeout(() => {
                            this.submit();
                        }, 800);
                    }
                });
            });
        });
    </script>
</body>
</html>