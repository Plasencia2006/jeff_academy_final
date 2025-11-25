<footer class="jeff-footer">
    <div class="jeff-container">
        <div class="jeff-content">
            <!-- Sección 1: Info Jeff Academy -->
            <div class="jeff-section">
                <h4>Jeff Academy</h4>
                <p>Formando campeones integrales con excelencia deportiva y valores sólidos.</p>
                <p>Somos una institución dedicada al desarrollo integral de jóvenes deportistas, combinando entrenamiento de alto nivel con formación en valores.</p>
            </div>

            <!-- Sección 2: Enlaces Rápidos -->
            <div class="jeff-section">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li><a href="{{ route('nosotros') }}"><i class="fas fa-users"></i> Nosotros</a></li>
                    <li><a href="{{ route('home') }}#disciplinas"><i class="fas fa-futbol"></i> Disciplinas</a></li>
                    <li><a href="{{ route('home') }}#instalaciones"><i class="fas fa-building"></i> Instalaciones</a></li>
                    <li><a href="{{ route('noticias.index') }}"><i class="fas fa-newspaper"></i> Noticias</a></li>
                    <li><a href="{{ route('planes') }}"><i class="fas fa-tags"></i> Planes</a></li>
                    <li><a href="{{ route('contacto') }}"><i class="fas fa-envelope"></i> Contacto</a></li>
                </ul>
            </div>

            <!-- Sección 3: Contacto -->
            <div class="jeff-section">
                <h4>Contacto</h4>
                <p><i class="fas fa-map-marker-alt"></i> {{ $config->direccion }}</p>
                <p><i class="fas fa-phone"></i> {{ $config->telefono }}</p>
                <p><i class="fas fa-envelope"></i> {{ $config->email }}</p>
                <p><i class="fas fa-clock"></i> Lun - Vie: {{ $config->horario_semana }}<br>Sáb: {{ $config->horario_sabado }}</p>
                
                <h4 style="margin-top: 20px;">Síguenos</h4>
                <div class="jeff-social">
                    @if($config->facebook_url)
                    <a href="{{ $config->facebook_url }}" target="_blank" title="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    @endif
                    @if($config->twitter_url)
                    <a href="{{ $config->twitter_url }}" target="_blank" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if($config->instagram_url)
                    <a href="{{ $config->instagram_url }}" target="_blank" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if($config->youtube_url)
                    <a href="{{ $config->youtube_url }}" target="_blank" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Sección 4: Medios de Pago -->
            <div class="jeff-section">
                <h4>Medios de Pago</h4>
                <p style="font-size: 13px; color: #cfcfcfff; margin: 0 0 15px 0;">Aceptamos los siguientes métodos de pago</p>
                <div class="jeff-payment">
                    <a href="https://www.viabcp.com/" target="_blank" rel="noopener noreferrer" title="BCP - Banco de Crédito del Perú">
                        <img src="{{ asset('img/tipos-de-pago/bcp.png') }}" alt="BCP">
                    </a>
                    <a href="https://www.yape.com.pe/" target="_blank" rel="noopener noreferrer" title="Yape - App de pagos">
                        <img src="{{ asset('img/tipos-de-pago/yape.png') }}" alt="Yape">
                    </a>
                    <a href="https://www.plin.pe/" target="_blank" rel="noopener noreferrer" title="Plin - Sistema de pagos">
                        <img src="{{ asset('img/tipos-de-pago/plin.png') }}" alt="Plin">
                    </a>
                </div>
            </div>
        </div>

        <div class="jeff-bottom">
            <p>&copy; 2025 <strong>Jeff Academy</strong> | Formando Campeones en Trujillo - Perú | Todos los derechos reservados</p>
        </div>
    </div>
</footer>