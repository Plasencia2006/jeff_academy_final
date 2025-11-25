<!-- Pagos del Jugador -->
<div class="space-y-6">
    <!-- Título de la sección con botón -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center space-x-3">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-credit-card text-blue-600 mr-3"></i>
                Estado de Pagos
            </h1>
            <div>
                @if($estadoPagos === 'al_dia')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Al día
                    </span>
                @elseif($estadoPagos === 'proximo_vencimiento')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Próximo a vencer
                    </span>
                @elseif($estadoPagos === 'vencido')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-1"></i>
                        Vencido
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        Sin verificar
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Botón para explorar planes (movido aquí arriba) -->
        <a href="{{ route('registro.elegir-plan') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
            <i class="fas fa-shopping-cart mr-2"></i>
            Explorar Planes Disponibles
        </a>
    </div>

    <!-- Resumen de pagos -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pagos Realizados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pagosRealizados }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pagos Pendientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pagosPendientes }}</p>
                    <p class="text-xs text-gray-500">Por vencer</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-coins text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Pagado</p>
                    <p class="text-2xl font-bold text-gray-900">S/ {{ number_format($totalPagado, 2) }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Próximo Pago</p>
                    <p class="text-2xl font-bold text-gray-900">
                        @if($proximoPago)
                            {{ $proximoPago->end_date->format('d/m') }}
                        @else
                            --/--
                        @endif
                    </p>
                    <p class="text-xs text-gray-500">Fecha límite</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Estado actual -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Estado Actual de Pagos
            </h3>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Cuenta al Día</h4>
                    <p class="text-gray-600 mb-4">
                        Actualmente no tienes pagos pendientes. Tu cuenta está al día y puedes continuar 
                        participando en todos los entrenamientos y actividades.
                    </p>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-lightbulb text-green-600 mr-2"></i>
                            <p class="text-sm text-green-800">
                                <strong>Tip:</strong> Mantén tus pagos al día para no interrumpir tu entrenamiento.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de pagos / Planes Adquiridos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center justify-between">
                <span>
                    <i class="fas fa-history text-purple-600 mr-2"></i>
                    Mis Planes Adquiridos
                </span>
                @if(isset($planesAdquiridos))
                    <span class="text-sm font-normal text-gray-500">
                        Total: {{ $planesAdquiridos->count() }} plan(es)
                    </span>
                @endif
            </h3>
        </div>
        <div class="overflow-x-auto">
            
            @if(isset($planesAdquiridos) && $planesAdquiridos->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duración</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Inicio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Fin</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($planesAdquiridos as $suscripcion)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-purple-600">
                                            <i class="fas fa-{{ $suscripcion->plan->tipo == 'vip' ? 'crown' : ($suscripcion->plan->tipo == 'premium' ? 'gem' : 'star') }} text-white"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $suscripcion->plan->nombre ?? ($suscripcion->plan_nombre ?? 'Plan no disponible') }}
                                            </div>
                                            @if(($suscripcion->plan->descripcion ?? ($suscripcion->plan_descripcion ?? false)))
                                                <div class="text-xs text-gray-500">
                                                    {{ $suscripcion->plan->descripcion ?? $suscripcion->plan_descripcion }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-green-600">
                                        S/ {{ number_format($suscripcion->plan->precio ?? ($suscripcion->plan_precio ?? 0), 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $suscripcion->plan->duracion ?? ($suscripcion->plan_duracion ?? 1) }} meses
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $status = $suscripcion->status ?? 'inactive';
                                        $statusConfig = [
                                            'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'check-circle', 'label' => 'Activo'],
                                            'canceled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'times-circle', 'label' => 'Cancelado'],
                                            'inactive' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'clock', 'label' => 'Inactivo']
                                        ];
                                        $config = $statusConfig[$status] ?? $statusConfig['inactive'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                        <i class="fas fa-{{ $config['icon'] }} mr-1"></i>
                                        {{ $config['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $suscripcion->start_date ? \Carbon\Carbon::parse($suscripcion->start_date)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $suscripcion->end_date ? \Carbon\Carbon::parse($suscripcion->end_date)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-12 text-center text-gray-500">
                    <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                    <p class="text-lg font-medium text-gray-900 mb-2">No has adquirido ningún plan</p>
                    <p class="text-sm mb-6">Explora nuestros planes disponibles y comienza tu entrenamiento con Jeff Academy.</p>
                    <p class="text-xs text-gray-400 mb-4">
                        Haz clic en el botón "Explorar Planes Disponibles" en la parte superior para ver las opciones disponibles.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Información importante -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-blue-900 mb-2">Información Importante sobre Pagos</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Los pagos deben realizarse una semana antes.</li>
                    <li>• Conserva siempre el comprobante de pago para cualquier consulta.</li>
                    <li>• En caso de retraso, comunícate con administración, en la seccion de Ayuda.</li>
                </ul>
            </div>
        </div>
    </div>
</div>