@extends('layouts.app')

@section('title', $noticia->titulo.' - Noticias - Jeff Academy')

@section('content')
<section class="noticia-show">
  <div class="container">
    <nav class="noticia-breadcrumb">
      <a href="{{ route('home') }}">Inicio</a>
      <span>/</span>
      <a href="{{ route('noticias.index') }}">Noticias</a>
    </nav>

    <div class="noticia-layout">
      <!-- Main Article Column -->
      <article class="noticia-detalle" data-aos="fade-up">
        <header>
          @if($noticia->categoria)
            <span class="noticia-categoria">{{ ucfirst($noticia->categoria) }}</span>
          @endif
          <h1>{{ $noticia->titulo }}</h1>
          <p class="noticia-fecha">{{ optional($noticia->fecha ?? $noticia->created_at)->format('d/m/Y') }}</p>
        </header>

        <div class="noticia-media">
          @if($noticia->imagen)
            @if(strpos($noticia->imagen, 'http') === 0)
              <img src="{{ $noticia->imagen }}" alt="{{ $noticia->titulo }}">
            @else
              <img src="{{ asset('storage/'.$noticia->imagen) }}" alt="{{ $noticia->titulo }}">
            @endif
          @else
            <img src="https://images.unsplash.com/photo-1575361204480-aadea25e6e68?auto=format&fit=crop&w=1470&q=80" alt="{{ $noticia->titulo }}">
          @endif
        </div>

        <div class="noticia-contenido">
          <p>{{ $noticia->descripcion }}</p>
          <a href="{{ route('noticias.index') }}" class="btn-volver">
            Regresar
          </a>
        </div>
      </article>

      <!-- Sidebar with Related News -->
      @if($relacionadas->count())
      <aside class="noticia-sidebar" data-aos="fade-left">
        <h3>Últimas Noticias</h3>
        <div class="noticias-relacionadas-list">
          @foreach($relacionadas as $rel)
          <article class="noticia-relacionada">
            <a href="{{ route('noticias.show', $rel->id) }}" class="noticia-relacionada-imagen">
              @if($rel->imagen)
                @if(strpos($rel->imagen, 'http') === 0)
                  <img src="{{ $rel->imagen }}" alt="{{ $rel->titulo }}">
                @else
                  <img src="{{ asset('storage/'.$rel->imagen) }}" alt="{{ $rel->titulo }}">
                @endif
              @else
                <img src="https://images.unsplash.com/photo-1575361204480-aadea25e6e68?auto=format&fit=crop&w=400&q=80" alt="{{ $rel->titulo }}">
              @endif
            </a>
            <div class="noticia-relacionada-contenido">
              <h4>
                <a href="{{ route('noticias.show', $rel->id) }}">{{ $rel->titulo }}</a>
              </h4>
              <p class="noticia-relacionada-fecha">{{ optional($rel->fecha ?? $rel->created_at)->format('d/m/Y') }}</p>
            </div>
          </article>
          @endforeach
        </div>
      </aside>
      @endif
    </div>
  </div>
</section>
@endsection
