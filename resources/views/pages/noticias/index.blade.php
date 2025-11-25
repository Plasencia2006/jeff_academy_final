@extends('layouts.app')

@section('title', 'Noticias - Jeff Academy')

@section('content')
<section class="noticias-archive-section" style="margin-top:90px; padding: 60px 0;">
  <div class="container">
    <div class="archive-header" data-aos="fade-down" style="text-align: center; margin-bottom: 50px;">
      <h1 class="section-title" style="margin-bottom: 10px; font-size: 3rem; color: var(--verde-oscuro); font-weight: 800;">Noticias</h1>
      <p class="section-subtitle" style="margin: 0 0 30px; font-size: 1.1rem; color: #666;">Últimas novedades, comunicados y cobertura de eventos</p>
    </div>

    @if($noticias->count() === 0)
      <div class="noticias-empty">
        No se encontraron noticias.
      </div>
    @else
    <div class="noticias-grid">
      @foreach($noticias as $noticia)
      <article class="noticia-card" data-aos="fade-up">
        <a href="{{ route('noticias.show', $noticia->id) }}" class="noticia-imagen">
          @if($noticia->imagen)
            @if(strpos($noticia->imagen, 'http') === 0)
              <img src="{{ $noticia->imagen }}" alt="{{ $noticia->titulo }}">
            @else
              <img src="{{ asset('storage/'.$noticia->imagen) }}" alt="{{ $noticia->titulo }}">
            @endif
          @else
            <img src="https://images.unsplash.com/photo-1575361204480-aadea25e6e68?auto=format&fit=crop&w=1350&q=80" alt="{{ $noticia->titulo }}">
          @endif
          <span class="noticia-overlay">Ver más</span>
        </a>
        <div class="noticia-contenido">
          @if($noticia->categoria)
          <span class="noticia-categoria">{{ ucfirst($noticia->categoria) }}</span>
          @endif
          <h3 class="noticia-titulo">
            <a href="{{ route('noticias.show', $noticia->id) }}">{{ $noticia->titulo }}</a>
          </h3>
          <p class="noticia-fecha">{{ optional($noticia->fecha ?? $noticia->created_at)->format('d/m/Y') }}</p>
          <p class="noticia-descripcion">{{ Str::limit($noticia->descripcion, 150) }}</p>
          <a href="{{ route('noticias.show', $noticia->id) }}" class="btn-noticia">
            Leer más
          </a>
        </div>
      </article>
      @endforeach
    </div>

    <div class="pagination">
      {{ $noticias->links() }}
    </div>
    @endif
  </div>
</section>
@endsection
