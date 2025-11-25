@extends('layouts.app')

@section('title', 'Pago Exitoso - Jeff Academy')

@section('content')
<section style="margin-top:100px; padding:40px 0; background:#f8f9fa; min-height:60vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg border-0" style="border-radius:16px;">
          <div class="card-body text-center p-5">
            <div class="mb-4">
              <div style="width:100px;height:100px;background:#28a745;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 25px;">
                <i class="fas fa-check fa-3x text-white"></i>
              </div>
              <h2 class="h2 mb-3" style="color:#28a745;">¡Pago Completado Exitosamente!</h2>
              
              <!-- Mensaje personalizado que solicitaste -->
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px; border-left: 4px solid #28a745;">
                <i class="fas fa-clock me-2"></i>
                <strong>¡Gracias por tu compra!</strong> Tu pago ha sido procesado correctamente. 
                <br>Espere sus credenciales de acceso en menos de 24 horas.
              </div>
              
              <p class="text-muted mb-4">Hemos recibido tu pago y estamos procesando tu suscripción.</p>
            </div>
            
            @if(isset($plan) && $plan)
            <div class="plan-details mb-4 p-4" style="background:#f8f9fa;border-radius:12px; border:1px solid #e9ecef;">
              <h4 class="h5 mb-3 text-primary">Detalles de tu Suscripción</h4>
              <div class="row text-start">
                <div class="col-md-6">
                  <p class="mb-2"><strong>Plan:</strong> {{ $plan->nombre }}</p>
                  <p class="mb-2"><strong>Precio:</strong> S/. {{ number_format($plan->precio, 2) }}</p>
                </div>
                <div class="col-md-6">
                  <p class="mb-2"><strong>Duración:</strong> {{ $plan->duracion }} meses</p>
                  <p class="mb-0"><strong>Tipo:</strong> {{ ucfirst($plan->tipo) }}</p>
                </div>
              </div>
            </div>
            @elseif(isset($plan_id))
            <div class="plan-details mb-4 p-4" style="background:#f8f9fa;border-radius:12px; border:1px solid #e9ecef;">
              <h4 class="h5 mb-3 text-primary">Detalles de tu Suscripción</h4>
              <p class="mb-2"><strong>ID de Plan:</strong> {{ $plan_id }}</p>
              <p class="mb-2"><strong>ID de Sesión:</strong> {{ $session_id ?? 'N/A' }}</p>
              <p class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Los detalles completos de tu plan llegarán con tus credenciales.</p>
            </div>
            @endif

            <!-- Información adicional -->
            <div class="additional-info mb-4 p-4" style="background:#e8f5e8;border-radius:12px; border-left:4px solid #28a745;">
              <h5 class="h6 mb-3" style="color:#1a531b;">
                <i class="fas fa-envelope me-2"></i>¿Qué esperar a continuación?
              </h5>
              <ul class="list-unstyled text-start" style="color:#2e7d32;">
                <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i>Recibirás un email de confirmación</li>
                <li class="mb-2"><i class="fas fa-check-circle me-2 text-success"></i>Tus credenciales llegarán en menos de 24 horas</li>
                <li class="mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Acceso completo a la plataforma</li>
              </ul>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
              <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                <i class="fas fa-home me-2"></i>Volver al Inicio
              </a>
              <a href="{{ route('platform') ?? url('/platform') }}" class="btn btn-outline-primary btn-lg px-4">
                <i class="fas fa-tachometer-alt me-2"></i>Ir a la Plataforma
              </a>
            </div>

            <!-- Soporte -->
            <div class="mt-4 pt-3 border-top">
              <p class="text-muted small mb-2">¿Tienes alguna pregunta?</p>
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#supportModal">
                <i class="fas fa-headset me-1"></i>Contactar Soporte
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Soporte -->
  <div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title fw-bold" id="supportModalLabel">
              <i class="fas fa-headset text-primary me-2"></i>Centro de Ayuda
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <p class="text-muted small mb-4">Estamos aquí para ayudarte. Contáctanos por cualquiera de estos medios:</p>
          
          <div class="row g-3">
              <!-- Email -->
              <div class="col-12">
                  <div class="p-3 rounded-3 bg-light border d-flex align-items-center">
                      <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-primary">
                          <i class="fas fa-envelope fa-lg"></i>
                      </div>
                      <div>
                          <small class="text-muted d-block">Correo Electrónico</small>
                          <a href="mailto:{{ $config->email ?? 'soporte@jeffacademy.com' }}" class="text-dark text-decoration-none fw-bold">
                              {{ $config->email ?? 'soporte@jeffacademy.com' }}
                          </a>
                      </div>
                  </div>
              </div>

              <!-- Teléfono -->
              <div class="col-12">
                  <div class="p-3 rounded-3 bg-light border d-flex align-items-center">
                      <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-success">
                          <i class="fas fa-phone fa-lg"></i>
                      </div>
                      <div>
                          <small class="text-muted d-block">Teléfono</small>
                          <a href="tel:{{ $config->telefono ?? '' }}" class="text-dark text-decoration-none fw-bold">
                              {{ $config->telefono ?? '+51 921456783' }}
                          </a>
                      </div>
                  </div>
              </div>

              <!-- Dirección -->
              <div class="col-12">
                  <div class="p-3 rounded-3 bg-light border d-flex align-items-center">
                      <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-danger">
                          <i class="fas fa-map-marker-alt fa-lg"></i>
                      </div>
                      <div>
                          <small class="text-muted d-block">Ubicación</small>
                          <span class="text-dark fw-bold">
                              {{ $config->direccion ?? 'Trujillo, Perú' }}
                          </span>
                      </div>
                  </div>
              </div>

              <!-- Horario -->
              <div class="col-12">
                  <div class="p-3 rounded-3 bg-light border d-flex align-items-center">
                      <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-warning">
                          <i class="fas fa-clock fa-lg"></i>
                      </div>
                      <div>
                          <small class="text-muted d-block">Horario de Atención</small>
                          <span class="text-dark fw-bold d-block" style="font-size: 0.9rem;">
                              Lun-Vie: {{ $config->horario_semana ?? '9am - 6pm' }}
                          </span>
                           <span class="text-muted d-block" style="font-size: 0.8rem;">
                              Sáb: {{ $config->horario_sabado ?? '9am - 1pm' }}
                          </span>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light w-100 rounded-pill" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.alert-success {
  background: linear-gradient(135deg, #d4edda, #c3e6cb);
  border: 1px solid #c3e6cb;
  color: #155724;
}

.btn-primary {
  background: linear-gradient(135deg, #007bff, #0056b3);
  border: none;
  border-radius: 10px;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Mostrar animación de confeti o efectos visuales
  const successIcon = document.querySelector('.fa-check');
  successIcon.style.animation = 'bounce 0.6s ease-in-out';
  
  setTimeout(() => {
    successIcon.style.animation = '';
  }, 600);
});

// Agregar animación CSS
const style = document.createElement('style');
style.textContent = `
  @keyframes bounce {
    0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
    40% {transform: translateY(-10px);}
    60% {transform: translateY(-5px);}
  }
  
  .card {
    animation: fadeInUp 0.8s ease-out;
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
`;
document.head.appendChild(style);
</script>
@endsection