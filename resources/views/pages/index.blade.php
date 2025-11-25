@extends('layouts.app')

@section('title', 'Jeff Academy - Formando Futuros Campeones')

@section('content')
    <!-- ===================================
         HERO MODERNO
         =================================== -->
    <section id="inicio" class="hero-section">
        <div class="hero-overlay"></div>
        
        <!-- FLECHAS DEL CARRUSEL -->
        <div class="hero-arrow left" onclick="prevSlide()">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="hero-arrow right" onclick="nextSlide()">
            <i class="fas fa-chevron-right"></i>
        </div>

        <div class="stars"></div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title" data-aos="fade-up">Formando Futuros Campeones</h1>
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                    Desarrollamos talento deportivo desde la base hasta la competencia de alto nivel, 
                    formando atletas integrales con valores sólidos.
                </p>
                <div class="hero-buttons" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('inscripcion') }}" class="btn btn-primary-glow">Únete Ahora</a>
                    <a href="{{ route('nosotros') }}" class="btn btn-secondary">Conoce Más</a>
                </div>
            </div>
            <div class="hero-animation">
                <div class="floating-ball"></div>
            </div>
        </div>
        <div class="scroll-indicator">
            <span>Desplázate</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- ===================================
         INSTALACIONES
         =================================== -->
    <section id="instalaciones" class="gallery-section" style="padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 class="section-titlei" style="font-size: 2.5rem; font-weight: 800; color: #1f2937; margin-bottom: 12px;">
                    <i class="fas fa-building" style="color: var(--verde-medio); margin-right: 12px;"></i>
                    Nuestras Instalaciones
                </h2>
                <p class="section-subtitlei" style="font-size: 1.1rem; color: #6b7280; max-width: 700px; margin: 0 auto;">
                    Espacios diseñados para potenciar el rendimiento de nuestros futbolistas
                </p>
            </div>

            <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                <!-- 1 -->
                <div class="gallery-item" style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; height: 320px; background: #fff;"
                     onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)';">
                    <img src="{{ asset('/img/instalaciones/cancha.jpg') }}" alt="Campo de Fútbol Profesional"
                         style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    <div class="gallery-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 60%, transparent 100%); padding: 30px 20px 20px; color: #fff; transform: translateY(0); transition: all 0.3s ease;">
                        <h4 style="margin: 0 0 8px 0; font-size: 1.3rem; font-weight: 700;">Campo Profesional</h4>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.95; line-height: 1.5;">Superficie de nivel competitivo, perfecta para entrenamientos y partidos oficiales.</p>
                    </div>
                </div>

                <!-- 2 -->
                <div class="gallery-item" style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; height: 320px; background: #fff;"
                     onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)';">
                    <img src="{{ asset('/img/instalaciones/Entrenamiento-Fisico.jpg') }}" alt="Entrenamiento Físico"
                         style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    <div class="gallery-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 60%, transparent 100%); padding: 30px 20px 20px; color: #fff; transform: translateY(0); transition: all 0.3s ease;">
                        <h4 style="margin: 0 0 8px 0; font-size: 1.3rem; font-weight: 700;">Entrenamiento Físico</h4>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.95; line-height: 1.5;">Área equipada para mejorar fuerza, resistencia y capacidad atlética.</p>
                    </div>
                </div>

                <!-- 3 -->
                <div class="gallery-item" style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; height: 320px; background: #fff;"
                     onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)';">
                    <img src="{{ asset('/img/instalaciones/porteros.jpg') }}" alt="Entrenamiento de Porteros"
                         style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    <div class="gallery-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 60%, transparent 100%); padding: 30px 20px 20px; color: #fff; transform: translateY(0); transition: all 0.3s ease;">
                        <h4 style="margin: 0 0 8px 0; font-size: 1.3rem; font-weight: 700;">Zona de Porteros</h4>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.95; line-height: 1.5;">Espacio exclusivo con materiales especializados para arqueros.</p>
                    </div>
                </div>

                <!-- 4 -->
                <div class="gallery-item" style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease; height: 320px; background: #fff;"
                     onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)';">
                    <img src="{{ asset('/img/instalaciones/jeff-aca.png') }}" alt="Indumentaria Oficial"
                         style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    <div class="gallery-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 60%, transparent 100%); padding: 30px 20px 20px; color: #fff; transform: translateY(0); transition: all 0.3s ease;">
                        <h4 style="margin: 0 0 8px 0; font-size: 1.3rem; font-weight: 700;">Indumentaria Oficial</h4>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.95; line-height: 1.5;">Uniformes modernos y exclusivos diseñados para nuestros jugadores.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================
         DISCIPLINAS DE FÚTBOL
         =================================== -->
    <style>
    /* Mejorar calidad de imágenes en responsive */
    .card-image img {
        image-rendering: auto !important;
        -webkit-backface-visibility: hidden !important;
        backface-visibility: hidden !important;
    }
    
    /* Tamaños más grandes para evitar blur - mantener calidad */
    @media (max-width: 768px) {
        .card-image {
            width: 200px !important;
            height: 200px !important;
        }
    }
    
    @media (max-width: 480px) {
        .card-image {
            width: 180px !important;
            height: 180px !important;
        }
    }
    
    /* Eliminar escala en hover para evitar pixelación */
    .disciplina-card:hover .card-image {
        transform: scale(1) !important;
    }
    </style>

    <section id="disciplinas" class="disciplinas-section">
        <div class="container">
            <h2 class="section-titless">Nuestras Disciplinas Deportivas</h2>
            <p class="disciplinas-subtitless">
                Perfecciona tus habilidades y domina cada aspecto<br>
                del juego con nuestros programas de entrenamiento profesional.
            </p>

            <div class="disciplinas-grid">
                @forelse($disciplinas as $disciplina)
                <!-- Contenedor de tarjeta con flip -->
                <div class="disciplina-card-container">
                    <div class="disciplina-card">
                        <!-- FRENTE DE LA TARJETA -->
                        <div class="card-front">
                            <div class="card-image">
                                @if($disciplina->imagen)
                                    <img src="{{ asset('storage/' . $disciplina->imagen) }}" alt="{{ $disciplina->nombre }}">
                                @else
                                    <img src="{{ asset('img/disciplinas/default.jpg') }}" alt="{{ $disciplina->nombre }}">
                                @endif
                            </div>
                            
                            <h3>{{ $disciplina->nombre }}</h3>
                            
                            <!-- Información (edad y cupo) -->
                            <div class="disciplina-info">
                                @if($disciplina->edad_minima || $disciplina->edad_maxima)
                                <span class="info-badge">
                                    <i class="fas fa-users"></i>
                                    Edad: {{ $disciplina->edad_minima ?? '0' }} - {{ $disciplina->edad_maxima ?? '∞' }} años
                                </span>
                                @endif
                                
                                @if($disciplina->cupo_maximo)
                                <span class="info-badge">
                                    <i class="fas fa-user-friends"></i>
                                    Cupo: {{ $disciplina->cupo_maximo }} personas
                                </span>
                                @endif
                            </div>
                            
                            <button class="btn-flip" onclick="flipCard(this)">
                                Leer más <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                        
                        <!-- REVERSO DE LA TARJETA -->
                        <div class="card-back">
                            <h3>{{ $disciplina->nombre }}</h3>
                            
                            <div class="card-back-content">
                                @if($disciplina->descripcion)
                                <div class="descripcion-section">
                                    <h4><i class="fas fa-info-circle"></i> Descripción</h4>
                                    <p>{{ $disciplina->descripcion }}</p>
                                </div>
                                @endif
                                
                                @if($disciplina->requisitos)
                                <div class="requisitos-section">
                                    <h4><i class="fas fa-clipboard-list"></i> Requisitos</h4>
                                    <p>{{ $disciplina->requisitos }}</p>
                                </div>
                                @endif
                            </div>
                            
                            <button class="btn-flip btn-back" onclick="flipCard(this)">
                                <i class="fas fa-arrow-left"></i> Volver
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Si no hay disciplinas activas, mostrar las predeterminadas -->
                <!-- 1. Control y Precisión -->
                <div class="disciplina-card futbol-control">
                    <div class="card-image">
                        <img src="{{ asset('img/disciplinas/control y precisión.jpg') }}" alt="Control y Precisión">
                    </div>
                    <h3>Control y Precisión</h3>
                    <p>Mejora tu dominio del balón y precisión en pases y disparos.</p>
                    <a href="{{ route('inscripcion') }}" class="btn-card">Inscribirse</a>
                </div>

                <!-- 2. Juego en Equipo -->
                <div class="disciplina-card futbol-equipo">
                    <div class="card-image">
                        <img src="{{ asset('/img/disciplinas/definición.png') }}" alt="Juego en Equipo">
                    </div>
                    <h3>Juego en Equipo</h3>
                    <p>Fortalece tu comunicación, movilidad y trabajo colectivo.</p>
                    <a href="{{ route('inscripcion') }}" class="btn-card">Inscribirse</a>
                </div>

                <!-- 3. Velocidad y Reacción -->
                <div class="disciplina-card futbol-velocidad">
                    <div class="card-image">
                        <img src="{{ asset('/img/disciplinas/juego-en-equipo.png') }}" alt="Velocidad y Reacción">
                    </div>
                    <h3>Velocidad y Reacción</h3>
                    <p>Entrena aceleración, agilidad y rapidez ante cualquier jugada.</p>
                    <a href="{{ route('inscripcion') }}" class="btn-card">Inscribirse</a>
                </div>

                <!-- 4. Entrenamiento de Porteros -->
                <div class="disciplina-card futbol-porteros">
                    <div class="card-image">
                        <img src="{{ asset('/img/disciplinas/porteros_entrenamientos.jpg') }}" alt="Entrenamiento de Porteros">
                    </div>
                    <h3>Entrenamiento de Porteros</h3>
                    <p>Perfecciona reflejos, blocajes, estiradas y técnicas de arquero.</p>
                    <a href="{{ route('inscripcion') }}" class="btn-card">Inscribirse</a>
                </div>

                <!-- 5. Táctica y Estrategia -->
                <div class="disciplina-card futbol-tactica">
                    <div class="card-image">
                        <img src="{{ asset('/img/disciplinas/tacticas.png') }}" alt="Táctica y Estrategia">
                    </div>
                    <h3>Táctica y Estrategia</h3>
                    <p>Comprende sistemas de juego, posicionamiento y lectura táctica.</p>
                    <a href="{{ route('inscripcion') }}" class="btn-card">Inscribirse</a>
                </div>

                <!-- 6. Definición y Finalización -->
                <div class="disciplina-card futbol-definicion">
                    <div class="card-image">
                        <img src="{{ asset('img/disciplinas/definición.png') }}" alt="Definición y Finalización">
                    </div>
                    <h3>Definición y Finalización</h3>
                    <p>Aprende remates potentes, tiros colocados y efectividad en gol.</p>
                    <a href="{{ route('inscripcion') }}" class="btn-card">Inscribirse</a>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ===================================
         TESTIMONIOS
         =================================== -->
    <section class="testimonios-section" id="testimonios">
        <div class="container">
            
            <!-- Encabezado -->
            <div class="testimonios-header">
                </span>
                <h2 class="section-titleis">
                    Lo Que Dicen Nuestros <span>Jugadores</span>
                </h2>
                <p class="section-subtitleis">
                    Historias reales de crecimiento, disciplina y éxito deportivo en Jeff Academy
                </p>
            </div>

            <!-- Carrusel -->
            <div class="carousel-wrapper">
                
                <!-- Flecha Anterior -->
                <button class="carousel-arrow prev" onclick="cambiarTestimonio(-1)" aria-label="Anterior">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <!-- Track del Carrusel -->
                <div class="carousel-track" id="carouselTrack">

                    <!-- Testimonio 1 -->
                    <div class="testimonio-card">
                        <div class="testimonio-header">
                            <div class="avatar-wrapper">
                                <img src="{{ asset('img/perfiles/img-perfil1.jpg') }}" alt="Diego Sánchez">
                                <div class="verified-badge">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="testimonio-info">
                                <h4>Diego Sánchez</h4>
                                <p class="role">
                                    <i class="fas fa-futbol"></i>
                                    Futbolista Categoría Sub-16
                                </p>
                            </div>
                        </div>
                        <p class="testimonio-text">
                            "Jeff Academy me ha ayudado a mejorar mis habilidades futbolísticas de manera increíble. Los entrenadores son excelentes, siempre atentos y motivadores. Las instalaciones son de primera calidad. ¡Recomendado al 100%!"
                        </p>
                    </div>

                    <!-- Testimonio 2 -->
                    <div class="testimonio-card">
                        <div class="testimonio-header">
                            <div class="avatar-wrapper">
                                <img src="{{ asset('img/perfiles/img-perfil2.jpg') }}" alt="Carlos Rodríguez">
                                <div class="verified-badge">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="testimonio-info">
                                <h4>Carlos Rodríguez</h4>
                                <p class="role">
                                    <i class="fas fa-futbol"></i>
                                    Jugador Equipo prfesional
                                </p>
                            </div>
                        </div>
                        <p class="testimonio-text">
                            "Gracias a Jeff Academy mejoré mi técnica y ahora formo parte del equipo regional. El ambiente es familiar y profesional a la vez. Los entrenamientos son exigentes pero siempre con un enfoque positivo que te hace crecer como jugador."
                        </p>
                    </div>

                    <!-- Testimonio 3 -->
                    <div class="testimonio-card">
                        <div class="testimonio-header">
                            <div class="avatar-wrapper">
                                <img src="{{ asset('/img/perfiles/padre-t.png') }}" alt="Roberto Torres">
                                <div class="verified-badge">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="testimonio-info">
                                <h4>Roberto Torres</h4>
                                <p class="role">
                                    <i class="fas fa-users"></i>
                                    Padre de Jugador
                                </p>
                            </div>
                        </div>
                        <p class="testimonio-text">
                            "Mi hijo ha crecido no solo como deportista sino también como persona. La formación en valores que reciben es realmente excepcional. Veo cambios positivos en su disciplina, responsabilidad y trabajo en equipo cada día."
                        </p>
                    </div>

                </div>

                <!-- Flecha Siguiente -->
                <button class="carousel-arrow next" onclick="cambiarTestimonio(1)" aria-label="Siguiente">
                    <i class="fas fa-chevron-right"></i>
                </button>

            </div>

            <!-- Indicadores -->
            <div class="indicadores" id="indicadores">
                <span class="dot active" onclick="irATestimonio(0)"></span>
                <span class="dot" onclick="irATestimonio(1)"></span>
                <span class="dot" onclick="irATestimonio(2)"></span>
            </div>
        </div>
    </section>
    
    <!-- ===================================
         CTA SECTION
         =================================== -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2>¿Listo para Comenzar tu Camino al Éxito?</h2>
                <p>Únete a la mejor academia deportiva de Trujillo y alcanza tu máximo potencial</p>
                <div class="cta-buttons">
                    <a href="{{ route('inscripcion') }}" class="btn btn-cta-primary">
                        <i class="fas fa-rocket"></i> Inscríbete Ahora
                    </a>
                    <a href="{{ route('contacto') }}" class="btn btn-cta-secondary">
                        <i class="fas fa-phone"></i> Contáctanos
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================
     PREGUNTAS FRECUENTES
     =================================== -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section-titlei">Preguntas Frecuentes</h2>
            <p class="section-subtitlei">Resolvemos tus dudas sobre nuestros programas</p>
            
            <div class="faq-container">
                
                <!-- Pregunta 1 -->
                <div class="faq-item" data-aos="fade-up">
                    <div class="faq-question">
                        <h4>¿A partir de qué edad pueden inscribirse?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Aceptamos estudiantes desde los 5 años en adelante. Trabajamos con todas las edades y adaptamos los entrenamientos según el nivel y capacidad de cada jugador, formando grupos de trabajo adecuados para su desarrollo.</p>
                    </div>
                </div>

                <!-- Pregunta 2 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="faq-question">
                        <h4>¿Cuánto dura el programa de entrenamiento?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Ofrecemos diferentes modalidades según tus posibilidades:</p>
                        <ul>
                            <li><strong>Programa Mensual:</strong> Ideal para comenzar (4 semanas)</li>
                            <li><strong>Programa Trimestral:</strong> Para ver progreso continuo (3 meses)</li>
                            <li><strong>Programa Anual:</strong> Formación completa con mejores resultados</li>
                        </ul>
                        <p>Los entrenamientos son de 2 a 3 veces por semana, dependiendo de los horarios inscritos.</p>
                    </div>
                </div>

                <!-- Pregunta 3 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="faq-question">
                        <h4>¿Necesito experiencia previa?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>No es necesario tener experiencia previa. Recibimos jugadores principiantes y con experiencia. Realizamos una evaluación inicial para ubicarte en el grupo más adecuado para tu aprendizaje y desarrollo.</p>
                    </div>
                </div>

                <!-- Pregunta 4 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="faq-question">
                        <h4>¿Qué incluye la inscripción?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>La inscripción incluye:</p>
                        <ul>
                            <li><strong>Evaluación inicial</strong> para conocer tu nivel</li>
                            <li><strong>Acceso a las instalaciones</strong> durante los horarios de entrenamiento</li>
                            <li><strong>Seguimiento del progreso</strong> por parte de los entrenadores</li>
                            <li><strong>Participación en partidos amistosos</strong> y prácticas grupales</li>
                        </ul>
                        <p>El uniforme y equipamiento personal corre por cuenta del jugador.</p>
                    </div>
                </div>

                <!-- Pregunta 5 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="faq-question">
                        <h4>¿Cuáles son los horarios de entrenamiento?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Nuestros horarios son:</p>
                        <ul>
                            <li><strong>Lunes a Viernes:</strong> 4:00 PM - 8:00 PM</li>
                            <li><strong>Sábados:</strong> 9:00 AM - 1:00 PM</li>
                        </ul>
                        <p>Los horarios específicos se coordinan según disponibilidad de campo y grupo asignado.</p>
                    </div>
                </div>

                <!-- Pregunta 6 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                    <div class="faq-question">
                        <h4>¿Qué métodos de pago aceptan?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Aceptamos:</p>
                        <ul>
                            <li><strong>Efectivo:</strong> En nuestras instalaciones</li>
                            <li><strong>Transferencias bancarias</strong></li>
                            <li><strong>Yape / Plin</strong></li>
                        </ul>
                        <p>Ofrecemos facilidades de pago para programas de varios meses. Consulta nuestras opciones disponibles.</p>
                    </div>
                </div>

                <!-- Pregunta 7 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                    <div class="faq-question">
                        <h4>¿Los padres pueden observar los entrenamientos?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sí, los padres y familiares son bienvenidos a observar los entrenamientos desde las áreas designadas alrededor del campo. Valoramos el apoyo familiar en el desarrollo deportivo de nuestros jugadores.</p>
                    </div>
                </div>

                <!-- Pregunta 8 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="700">
                    <div class="faq-question">
                        <h4>¿Qué debo traer al entrenamiento?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Es importante que cada jugador traiga:</p>
                        <ul>
                            <li><strong>Ropa deportiva cómoda</strong></li>
                            <li><strong>Zapatillas o botines de fútbol</strong></li>
                            <li><strong>Botella de agua</strong> para mantenerse hidratado</li>
                            <li><strong>Canilleras</strong> (obligatorio para prácticas)</li>
                            <li><strong>Toalla pequeña</strong></li>
                        </ul>
                        <p>Recomendamos marcar todas las pertenencias con el nombre del jugador.</p>
                    </div>
                </div>

                <!-- Pregunta 9 -->
                <div class="faq-item" data-aos="fade-up" data-aos-delay="800">
                    <div class="faq-question">
                        <h4>¿Ofrecen algún descuento?</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Sí, contamos con:</p>
                        <ul>
                            <li><strong>Descuento por hermanos:</strong> Si inscriben a más de un hijo</li>
                            <li><strong>Descuento por pago adelantado:</strong> Al pagar programas de 3 meses o más</li>
                        </ul>
                        <p>Consulta con nuestro equipo administrativo para más información sobre facilidades disponibles.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
@endsection

@push('scripts')

<!-- ===================================
     SCRIPT: SLIDER HERO + OCULTAR FLECHAS
     =================================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    /* IMÁGENES DEL HERO (SLIDER AUTOMÁTICO) */
    const heroImages = [
        "{{ asset('img/hero-print.jpg') }}",
        "{{ asset('img/hero-print-1.jpg') }}",
        "{{ asset('img/hero-print-3.jpg') }}"
    ];

    let currentIndex = 0;
    let autoPlayInterval;

    const heroOverlay = document.querySelector(".hero-overlay");
    if (!heroOverlay) return;

    function changeSlide() {
        heroOverlay.classList.add('is-changing');
        setTimeout(() => {
            heroOverlay.style.backgroundImage = `url('${heroImages[currentIndex]}')`;
            heroOverlay.classList.remove('is-changing');
        }, 300);
    }

    window.nextSlide = function() {
        currentIndex = (currentIndex + 1) % heroImages.length;
        changeSlide();
        restartAutoplay();
    }

    window.prevSlide = function() {
        currentIndex = (currentIndex - 1 + heroImages.length) % heroImages.length;
        changeSlide();
        restartAutoplay();
    }

    function startAutoplay() {
        autoPlayInterval = setInterval(() => {
            nextSlide();
        }, 7000);
    }

    function restartAutoplay() {
        clearInterval(autoPlayInterval);
        startAutoplay();
    }

    heroOverlay.style.backgroundImage = `url('${heroImages[currentIndex]}')`;
    startAutoplay();

    /* OCULTAR FLECHAS AL DESLIZAR */
    const arrows = document.querySelectorAll(".hero-arrow");
    let lastScrollY = 0;

    window.addEventListener("scroll", () => {
        const scrollY = window.scrollY;
        const threshold = 10;

        arrows.forEach(arrow => {
            if (scrollY > threshold && scrollY > lastScrollY) {
                arrow.style.opacity = "0";
                arrow.style.transform = "scale(0.7)";
                arrow.style.pointerEvents = "none";
            } else if (scrollY < lastScrollY - 10) {
                arrow.style.opacity = "1";
                arrow.style.transform = "scale(1)";
                arrow.style.pointerEvents = "auto";
            }
        });

        lastScrollY = scrollY;
    });
});
</script>

<!-- ===================================
     SCRIPT: ANIMACIÓN DISCIPLINAS
     =================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.disciplina-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    cards.forEach(card => {
        observer.observe(card);
    });
});
</script>

<!-- ===================================
     SCRIPT: CARRUSEL DE TESTIMONIOS
     =================================== -->
<script>
let testimonioActual = 0;
const testimonios = document.querySelectorAll('.testimonio-card');
const totalTestimonios = testimonios.length;
const track = document.getElementById('carouselTrack');
const indicadores = document.querySelectorAll('.dot');

function cambiarTestimonio(direccion) {
    testimonioActual += direccion;
    
    if (testimonioActual < 0) {
        testimonioActual = totalTestimonios - 1;
    } else if (testimonioActual >= totalTestimonios) {
        testimonioActual = 0;
    }
    
    actualizarCarrusel();
}

function irATestimonio(index) {
    testimonioActual = index;
    actualizarCarrusel();
}

function actualizarCarrusel() {
    const cardWidth = testimonios[0].offsetWidth;
    const gap = 30;
    const desplazamiento = -(testimonioActual * (cardWidth + gap));
    
    track.style.transform = `translateX(${desplazamiento}px)`;
    
    indicadores.forEach((dot, index) => {
        if (index === testimonioActual) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

let autoplayInterval;

function iniciarAutoplay() {
    autoplayInterval = setInterval(() => {
        cambiarTestimonio(1);
    }, 5000);
}

function detenerAutoplay() {
    clearInterval(autoplayInterval);
}

window.addEventListener('load', () => {
    actualizarCarrusel();
    iniciarAutoplay();
});

const carouselWrapper = document.querySelector('.carousel-wrapper');
if (carouselWrapper) {
    carouselWrapper.addEventListener('mouseenter', detenerAutoplay);
    carouselWrapper.addEventListener('mouseleave', iniciarAutoplay);
}

window.addEventListener('resize', () => {
    actualizarCarrusel();
});

let touchStartX = 0;
let touchEndX = 0;

if (carouselWrapper) {
    carouselWrapper.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        detenerAutoplay();
    });

    carouselWrapper.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        iniciarAutoplay();
    });
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            cambiarTestimonio(1);
        } else {
            cambiarTestimonio(-1);
        }
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
        cambiarTestimonio(-1);
    } else if (e.key === 'ArrowRight') {
        cambiarTestimonio(1);
    }
});
</script>

<!-- ===================================
     SCRIPT: CONTADORES Y FAQ
     =================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ====== CONTADORES ======
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200;

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target + '+';
            }
        };

        updateCount();
    });

    // ====== FAQ CON ALTURA AUTOMÁTICA ======
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = question.querySelector('i');
        
        // Configurar estado inicial
        answer.style.maxHeight = '0';
        answer.style.overflow = 'hidden';
        answer.style.transition = 'max-height 0.4s ease, padding 0.4s ease';
        icon.style.transition = 'transform 0.3s ease';
        
        // Evento click
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Cerrar todos los items
            faqItems.forEach(faq => {
                faq.classList.remove('active');
                const faqAnswer = faq.querySelector('.faq-answer');
                const faqIcon = faq.querySelector('.faq-question i');
                faqAnswer.style.maxHeight = '0';
                faqAnswer.style.paddingTop = '0';
                faqAnswer.style.paddingBottom = '0';
                faqAnswer.style.overflow = 'hidden';
                faqIcon.style.transform = 'rotate(-90deg)';
            });
            
            // Si no estaba activo, abrir el item clickeado
            if (!isActive) {
                item.classList.add('active');
                
                // SOLUCIÓN: Usar 'none' para calcular altura real
                answer.style.overflow = 'visible';
                answer.style.maxHeight = 'none';
                
                // Obtener altura real del contenido
                const height = answer.scrollHeight;
                
                // Resetear para animar
                answer.style.maxHeight = '0';
                
                // Forzar repaint
                answer.offsetHeight;
                
                // Aplicar altura real con padding
                answer.style.maxHeight = (height + 100) + 'px';
                answer.style.paddingTop = '25px';
                answer.style.paddingBottom = '40px';
                
                // Después de la animación, dejar altura automática
                setTimeout(() => {
                    if (item.classList.contains('active')) {
                        answer.style.maxHeight = 'none';
                        answer.style.overflow = 'visible';
                    }
                }, 400);
                
                // Rotar flecha hacia abajo
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });

    // Ajustar altura al cambiar tamaño de ventana
    window.addEventListener('resize', () => {
        const activeItems = document.querySelectorAll('.faq-item.active');
        activeItems.forEach(item => {
            const answer = item.querySelector('.faq-answer');
            answer.style.maxHeight = 'none';
            answer.style.overflow = 'visible';
        });
    });
});
</script>

<!-- ===================================
     SCRIPT: FLIP CARD DISCIPLINAS
     =================================== -->
<script>
// Función para voltear la tarjeta
function flipCard(button) {
    const card = button.closest('.disciplina-card');
    card.classList.toggle('flipped');
}
</script>

@endpush