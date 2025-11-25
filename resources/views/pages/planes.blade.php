@extends('layouts.app')

@section('title', 'Planes y Precios - Jeff Academy')

@section('content')
<style>
  /* Responsive para planes */
  @media (max-width: 768px) {
    .planes-list .container > div {
      grid-template-columns: 1fr !important;
      padding: 0 15px !important;
    }
  }
  
  @media (max-width: 480px) {
    .planes-list .container > div {
      padding: 0 10px !important;
      gap: 20px !important;
    }
  }
</style>

<section class="planes-hero" style="margin-top: 70px; color: #fff; background:
  linear-gradient(135deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)),
  url('https://images.pexels.com/photos/46798/the-ball-stadion-football-the-pitch-46798.jpeg?auto=compress&cs=tinysrgb&w=1600');
  background-size: cover; background-position: center; background-repeat: no-repeat; 
  min-height: 400px; display: flex; align-items: center;">
  <div class="container" style="padding: 60px 20px;">
    <h1 class="section-titlesss" style="color: #fff; margin: 0 0 12px; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; text-align: center; text-shadow: 2px 2px 8px rgba(0,0,0,0.3);">
      PLANES Y PRECIOS
    </h1>
    <p class="section-subtitlesss" style="margin: 0; color: #e9f5ec; font-size: clamp(1rem, 2.5vw, 1.3rem); text-align: center; max-width: 600px; margin: 0 auto; text-shadow: 1px 1px 4px rgba(0,0,0,0.3);">
      Elige el plan ideal para tu formación deportiva
    </p>
  </div>
</section>

<section class="planes-list" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 60px 0;">
  <div class="container">

    <!-- Grid de planes -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
      @foreach($planes as $plan)
      @php
        // Colores según tipo de plan
        $planColors = [
            'basico' => [
                'gradient' => 'linear-gradient(135deg, #64748b 0%, #475569 100%)', 
                'badge' => '#94a3b8', 
                'icon' => 'fa-star'
            ], // Gris azulado (neutral pero elegante)
            
            'premium' => [
                'gradient' => 'linear-gradient(135deg, #14b8a6 0%, #0d9488 100%)', 
                'badge' => '#2dd4bf', 
                'icon' => 'fa-gem'
            ], // Verde turquesa (IDÉNTICO al verde de tu header)
            
            'vip' => [
                'gradient' => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)', 
                'badge' => '#fbbf24', 
                'icon' => 'fa-crown'
            ] // Amarillo dorado (como tus botones "INSCRÍBETE AHORA")
        ];
        $colors = $planColors[$plan->tipo] ?? $planColors['basico'];
      @endphp
      
      <div style="background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; transition: all 0.3s ease; height: 100%; display: flex; flex-direction: column; position: relative;"
           onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)';">
        
        <!-- Badge de tipo -->
        <div style="position: absolute; top: 20px; right: 20px; z-index: 10;">
          <span style="background: {{ $colors['badge'] }}; color: #fff; padding: 6px 14px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <i class="fas {{ $colors['icon'] }}" style="margin-right: 4px;"></i>
            {{ ucfirst($plan->tipo) }}
          </span>
        </div>

        <!-- Header con gradiente -->
        <div style="background: {{ $colors['gradient'] }}; color: #fff; padding: 40px 30px 30px; position: relative;">
          <div style="text-align: center;">
            <h3 style="margin: 0 0 16px 0; font-size: 1.75rem; font-weight: 800; letter-spacing: -0.5px;">
              {{ $plan->nombre }}
            </h3>
            <div style="display: flex; align-items: baseline; justify-content: center; gap: 6px;">
              <span style="font-size: 1rem; opacity: 0.9;">S/.</span>
              <span style="font-size: 3rem; font-weight: 900; line-height: 1;">
                {{ number_format($plan->precio, 0) }}
              </span>
              <span style="font-size: 0.9rem; opacity: 0.9;">
                @if($plan->precio != floor($plan->precio))
                  .{{ str_pad(($plan->precio - floor($plan->precio)) * 100, 2, '0', STR_PAD_LEFT) }}
                @endif
              </span>
            </div>
            <p style="margin: 8px 0 0 0; font-size: 0.95rem; opacity: 0.95; font-weight: 500;">
              <i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>
              {{ $plan->duracion }} {{ $plan->duracion == 1 ? 'mes' : 'meses' }}
            </p>
          </div>
        </div>

        <!-- Contenido -->
        <div style="padding: 30px; flex: 1; display: flex; flex-direction: column;">
          
          <!-- Descripción -->
          @if($plan->descripcion)
          <div style="margin-bottom: 24px;">
            <p style="color: #4b5563; font-size: 0.95rem; line-height: 1.6; margin: 0;">
              {{ $plan->descripcion }}
            </p>
          </div>
          @endif

          <!-- Disciplinas -->
          @if($plan->disciplinas)
          @php
            $disciplinasIds = explode(',', $plan->disciplinas);
            $disciplinasNombres = \App\Models\Disciplina::whereIn('id', $disciplinasIds)->pluck('nombre')->toArray();
          @endphp
          <div style="margin-bottom: 24px;">
            <h4 style="font-size: 0.85rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px 0;">
              <i class="fas fa-running" style="margin-right: 6px;"></i>
              Disciplinas incluidas
            </h4>
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
              @foreach($disciplinasNombres as $disciplinaNombre)
              <span style="background: #e0f2fe; color: #0369a1; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600;">
                {{ $disciplinaNombre }}
              </span>
              @endforeach
            </div>
          </div>
          @endif

          <!-- Beneficios -->
          @if($plan->beneficios)
          <div style="margin-bottom: 24px;">
            <h4 style="font-size: 0.85rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px 0;">
              <i class="fas fa-check-circle" style="margin-right: 6px;"></i>
              Beneficios
            </h4>
            <p style="color: #4b5563; font-size: 0.9rem; line-height: 1.6; margin: 0;">
              {{ $plan->beneficios }}
            </p>
          </div>
          @endif

          <!-- Espaciador flexible -->
          <div style="flex: 1;"></div>

          <!-- Botón de acción -->
          <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid #f3f4f6;">
            @if($plan->estado == 'activo')
            <a href="{{ route('inscripcion') }}" 
               style="display: flex; align-items: center; justify-content: center; gap: 10px; background: {{ $colors['gradient'] }}; color: #fff; padding: 16px 24px; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
               onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.2)';"
               onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';">
              <i class="fas fa-user-plus" style="font-size: 1.1rem;"></i>
              <span>Inscribirme Ahora</span>
            </a>
            @else
            <button disabled 
                    style="display: flex; align-items: center; justify-content: center; gap: 10px; background: #e5e7eb; color: #9ca3af; padding: 16px 24px; border-radius: 12px; font-weight: 700; font-size: 1rem; border: none; cursor: not-allowed;">
              <i class="fas fa-ban"></i>
              <span>No Disponible</span>
            </button>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Mensaje si no hay planes -->
    @if($planes->count() == 0)
    <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
      <i class="fas fa-credit-card" style="font-size: 4rem; color: #d1d5db; margin-bottom: 20px;"></i>
      <h3 style="font-size: 1.5rem; color: #6b7280; margin: 0 0 10px 0;">No hay planes disponibles</h3>
      <p style="color: #9ca3af; margin: 0;">Pronto tendremos nuevos planes para ti</p>
    </div>
    @endif
  </div>
</section>
@endsection