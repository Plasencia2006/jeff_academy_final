@extends('layouts.app')

@section('title', 'Contacto - Jeff Academy')

@section('content')

<style>
  /* Fix responsive overflow */
  html, body {
    overflow-x: hidden !important;
    max-width: 100vw !important;
  }
  
  .contacto-hero,
  .contacto-info,
  .contacto-form-section,
  .contacto-mapa {
    overflow-x: hidden !important;
    max-width: 100vw !important;
  }
  
  .container {
    max-width: 1200px !important;
    width: 100% !important;
    padding: 0 20px !important;
    margin: 0 auto !important;
  }
  
  .info-grid {
    max-width: 100% !important;
    width: 100% !important;
    padding: 0 !important;
  }
  
  .info-card {
    width: 100% !important;
    max-width: 100% !important;
  }
  
  /* Hero section responsive */
  .contacto-hero {
    margin-top: 70px !important;
  }
  
  .section-titles {
    font-size: clamp(2rem, 6vw, 3rem) !important;
    word-wrap: break-word !important;
    line-height: 1.2 !important;
  }
  
  .section-subtitle {
    font-size: clamp(0.95rem, 3vw, 1.2rem) !important;
    word-wrap: break-word !important;
  }
  
  .cta-buttons {
    width: 100% !important;
    max-width: 100% !important;
  }
  
  .btn {
    font-size: clamp(0.9rem, 2.5vw, 1rem) !important;
    padding: 12px 24px !important;
    white-space: nowrap !important;
  }
  
  @media (max-width: 768px) {
    .container {
      padding: 0 15px !important;
    }
    
    .info-grid {
      grid-template-columns: 1fr !important;
      gap: 16px !important;
    }
    
    .contacto-hero {
      padding: 50px 15px !important;
      margin-top: 70px !important;
    }
    
    .section-titles {
      font-size: 2.2rem !important;
      margin-bottom: 12px !important;
    }
    
    .section-subtitle {
      font-size: 1rem !important;
      padding: 0 10px !important;
    }
    
    .cta-buttons {
      gap: 12px !important;
      flex-direction: column !important;
      align-items: center !important;
    }
    
    .btn {
      width: 100% !important;
      max-width: 300px !important;
      justify-content: center !important;
    }
  }
  
  @media (max-width: 480px) {
    .container {
      padding: 0 10px !important;
    }
    
    .info-card {
      padding: 20px !important;
    }
    
    .contacto-hero {
      padding: 40px 10px !important;
      margin-top: 60px !important;
    }
    
    .section-titles {
      font-size: 1.8rem !important;
      letter-spacing: 1px !important;
    }
    
    .section-subtitle {
      font-size: 0.9rem !important;
    }
    
    .btn {
      font-size: 0.9rem !important;
      padding: 12px 20px !important;
    }
  }
</style>

<!-- ========================================
     HERO SECTION - CONTACTO
     ======================================== -->
<section class="contacto-hero">
  <div class="container">
    <h1 class="section-titles">CONTÁCTANOS</h1>
    <p class="section-subtitle">Estamos listos para ayudarte a empezar tu camino deportivo</p>
    <div class="cta-buttons">
      <a href="{{ route('inscripcion') }}" class="btn btn-cta-primary">
        <i class="fas fa-user-plus"></i> Suscríbete
      </a>
      <a href="{{ route('planes') }}" class="btn btn-cta-secondary">
        <i class="fas fa-tags"></i> Ver Planes
      </a>
    </div>
  </div>
</section>

<!-- ========================================
     INFORMACIÓN DE CONTACTO
     ======================================== -->
<section class="contacto-info">
  <div class="container">
    <div class="info-grid">
      
      <!-- Dirección -->
      <div class="info-card" data-aos="fade-up">
        <div class="info-icon">
          <i class="fas fa-map-marker-alt"></i>
        </div>
        <h3>Dirección</h3>
        <p>{{ $config->direccion }}</p>
      </div>
      
      <!-- Teléfono -->
      <div class="info-card" data-aos="fade-up" data-aos-delay="100">
        <div class="info-icon">
          <i class="fas fa-phone"></i>
        </div>
        <h3>Teléfono</h3>
        <p>{{ $config->telefono }}</p>
        <a href="tel:{{ str_replace([' ', '+', '-', '(', ')'], '', $config->telefono) }}" class="info-link">
          <i class="fas fa-phone-volume"></i> Llamar ahora
        </a>
      </div>
      
      <!-- Correo -->
      <div class="info-card" data-aos="fade-up" data-aos-delay="200">
        <div class="info-icon">
          <i class="fas fa-envelope"></i>
        </div>
        <h3>Correo</h3>
        <p>{{ $config->email }}</p>
        <a href="mailto:{{ $config->email }}" class="info-link">
          <i class="fas fa-paper-plane"></i> Enviar correo
        </a>
      </div>
      
      <!-- Horario -->
      <div class="info-card" data-aos="fade-up" data-aos-delay="300">
        <div class="info-icon">
          <i class="fas fa-clock"></i>
        </div>
        <h3>Horario</h3>
        <p>Lun - Vie: {{ $config->horario_semana }}</p>
        <p>Sáb: {{ $config->horario_sabado }}</p>
        @if($config->horario_domingo)
        <p class="horario-secundario">Dom: {{ $config->horario_domingo }}</p>
        @endif
      </div>
      
    </div>
  </div>
</section>

<!-- ========================================
     FORMULARIO DE CONTACTO
     ======================================== -->
<section class="contacto-form-section">
  <div class="container">
    <div class="form-container">
      <div class="form-box" data-aos="fade-up">
        
        <!-- Header del formulario -->
        <div class="form-header">
          <div class="form-header-iconn">
            <i class="fas fa-paper-plane"></i>
          </div>
          <h3>Envíanos un mensaje</h3>
          <p>Responderemos lo antes posible</p>
        </div>
        
        <!-- Formulario -->
        <form id="contactForm"
              action="https://formsubmit.co/edinsonjimenezvega2@gmail.com"
              method="POST">
          <input type="hidden" name="_captcha" value="false">
          
          <!-- Nombre -->
          <div class="form-group">
            <label>
              <i class="fas fa-user"></i> Nombre completo
            </label>
            <input type="text" 
                   name="nombre" 
                   class="form-control" 
                   placeholder="Ej: Juan Pérez" 
                   required>
          </div>
          
          <!-- Email -->
          <div class="form-group">
            <label>
              <i class="fas fa-envelope"></i> Correo electrónico
            </label>
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   placeholder="tu@email.com" 
                   required>
          </div>
          
          <!-- Teléfono -->
          <div class="form-group">
            <label>
              <i class="fas fa-phone"></i> Teléfono 
              <span class="label-opcional">(opcional)</span>
            </label>
            <input type="tel" 
                   name="telefono" 
                   class="form-control" 
                   placeholder="+51 999 999 999">
          </div>
          
          <!-- Mensaje -->
          <div class="form-group">
            <label>
              <i class="fas fa-comment-dots"></i> Mensaje
            </label>
            <textarea name="mensaje" 
                      class="form-control" 
                      placeholder="Escribe tu mensaje aquí..." 
                      rows="4" 
                      required></textarea>
          </div>
          
          <!-- Botón de envío -->
          <button type="submit" class="btn-form" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%) !important; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35) !important;">
            <i class="fas fa-paper-plane"></i> Enviar Mensaje
          </button>
          
          <!-- Mensaje de seguridad -->
          <p class="form-security">
            <i class="fas fa-lock"></i> Tus datos están protegidos
          </p>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ========================================
     MAPA Y UBICACIÓN
     ======================================== -->
<section class="contacto-mapa">
  <div class="container">
    <h2 class="section-title">
      <i class="fas fa-map-marked-alt"></i> Encuéntranos
    </h2>
    
    <!-- Cards informativos -->
    <div class="mapa-info-grid">
      
      <!-- Ubicación Principal -->
      <div class="content-card" data-aos="fade-up">
        <div class="content-icon">
          <i class="fas fa-map-marker-alt"></i>
        </div>
        <h4>Ubicación Principal</h4>
        <p>{{ $config->direccion }}</p>
      </div>
      
      <!-- Cómo Llegar -->
      <div class="content-card" data-aos="fade-up" data-aos-delay="100">
        <div class="content-icon">
          <i class="fas fa-route"></i>
        </div>
        <h4>Cómo Llegar</h4>
        <p>Acceso por transporte público<br>Estacionamiento disponible</p>
      </div>
      
      <!-- Zonas de Entrenamiento -->
      <div class="content-card" data-aos="fade-up" data-aos-delay="200">
        <div class="content-icon">
          <i class="fas fa-running"></i>
        </div>
        <h4>Zonas de Entrenamiento</h4>
        <p>Canchas profesionales<br>Espacios al aire libre</p>
      </div>
      
    </div>
    
    <!-- Mapa embebido -->
    <div class="map-wrap" data-aos="fade-up">
      <iframe src="{{ $config->mapa_url }}" 
              width="100%" 
              height="450" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    
  </div>
</section>

@endsection
<!-- ========================================
     SCRIPTS
     ======================================== -->
@push('scripts')
<script>
document.getElementById('contactForm').onsubmit = async function(e) {
  e.preventDefault();
  
  const form = this;
  const formData = new FormData(form);
  
  try {
    await fetch(form.action, { 
      method: 'POST', 
      body: formData 
    });
    
    form.reset();
    
    const toast = document.getElementById('toast-exito');
    toast.style.display = 'block';
    
    setTimeout(() => { 
      toast.style.display = 'none'; 
    }, 3500);
    
  } catch (error) {
    console.error('Error al enviar el formulario:', error);
    alert('Hubo un error al enviar tu mensaje. Por favor, intenta nuevamente.');
  }
};
</script>
@endpush