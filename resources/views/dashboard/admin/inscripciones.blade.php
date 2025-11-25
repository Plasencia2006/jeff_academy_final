<!-- INSCRIPCIONES - Gestión de Registros -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-clipboard-list text-orange-600 mr-3"></i>
            Gestión de Registros
        </h1>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Registros</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $registros->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Con Plan Activo</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $registros->where('tiene_plan', 1)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gray-100 rounded-lg p-3">
                    <i class="fas fa-times-circle text-gray-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Sin Plan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $registros->where('tiene_plan', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!--Filtros por estado (activo o inactivo) y búsqueda por nombre o apellido-->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100" x-data="{
        filtroEstado: '',
        buscarNombre: '',
        filtrarRegistros() {
            const estado = this.filtroEstado;
            const nombre = this.buscarNombre.toLowerCase();
            
            document.querySelectorAll('.registro-row').forEach(row => {
                const rowEstado = row.dataset.estado || '';
                const rowNombre = row.dataset.nombre?.toLowerCase() || '';
                
                const matchEstado = !estado || rowEstado === estado;
                const matchNombre = !nombre || rowNombre.includes(nombre);
                
                if (matchEstado && matchNombre) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        },
        limpiarFiltros() {
            this.filtroEstado = '';
            this.buscarNombre = '';
            this.filtrarRegistros();
        }
    }">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Filtro por estado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter text-orange-600 mr-2"></i>Filtrar por Estado
                    </label>
                    <select x-model="filtroEstado" @change="filtrarRegistros()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activos (Con Plan)</option>
                        <option value="inactivo">Inactivos (Sin Plan)</option>
                    </select>
                </div>

                <!-- Búsqueda por nombre o apellido -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search text-orange-600 mr-2"></i>Buscar por Nombre o Apellido
                    </label>
                    <input type="text" x-model="buscarNombre" @input="filtrarRegistros()"
                            placeholder="Ingrese nombre o apellido..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>

                <!-- Botón limpiar -->
                <div class="flex items-end">
                    <button @click="limpiarFiltros()" type="button"
                            class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-redo mr-2"></i>
                        Limpiar Filtros
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Principal -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i class="fas fa-table text-orange-600 mr-2"></i>
                Registros en el Sistema
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan Adquirido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registros as $registro)
                    <tr class="registro-row hover:bg-gray-50 transition-colors {{ intval($registro->tiene_plan) === 1 ? 'bg-green-50' : '' }}"
                        data-estado="{{ intval($registro->tiene_plan) === 1 ? 'activo' : 'inactivo' }}"
                        data-nombre="{{ $registro->nombres }} {{ $registro->apellido_paterno }} {{ $registro->apellido_materno }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500">#{{ $registro->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $registro->nombres }}</div>
                            <div class="text-sm text-gray-500">{{ $registro->apellido_paterno }} {{ $registro->apellido_materno }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $registro->email }}</div>
                            <div class="text-sm text-gray-500">{{ $registro->nro_celular }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(intval($registro->tiene_plan) === 1)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $registro->plan_nombre }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">S/ {{ $registro->plan_precio }}</div>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Sin plan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(intval($registro->tiene_plan) === 1)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $registro->estado_suscripcion }}
                                </span>
                                <div class="text-xs text-gray-500 mt-1">
                                    Vence: {{ $registro->fecha_fin ? \Carbon\Carbon::parse(trim($registro->fecha_fin))->format('d/m/Y') : 'N/A' }}
                                </div>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Inactivo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-2">
                                <button @click="$dispatch('open-modal', { modal: 'detalle{{ $registro->id }}' })" 
                                    class="relative text-blue-600 hover:text-blue-800 transition-colors" 
                                    title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                    @if(intval($registro->tiene_plan) === 1)
                                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1">PLAN</span>
                                    @endif
                                </button>

                                <!-- Botón Eliminar -->
                                <button onclick="eliminarRegistro({{ $registro->id }}, '{{ $registro->nombres }} {{ $registro->apellido_paterno }}')"
                                    class="text-red-600 hover:text-red-800 transition-colors" 
                                    title="Eliminar registro">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-lg">No hay registros disponibles</p>
                                <p class="text-gray-400 text-sm mt-2">Los registros aparecerán aquí cuando se realicen inscripciones</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sistema de Modales con Alpine.js -->
<div x-data="{ 
    currentModal: null,
    openModal(modalId) { this.currentModal = modalId; },
    closeModal() { this.currentModal = null; }
}" 
@open-modal.window="openModal($event.detail.modal)"
@keydown.escape.window="closeModal()">
    @foreach($registros as $registro)
        @php
            // DETECTAR SI EXISTE PLAN ADQUIRIDO
            $tienePlanAdquirido = !empty($registro->plan_nombre) && $registro->plan_nombre !== null;
            $planActivo = $tienePlanAdquirido && intval($registro->tiene_plan) === 1 && $registro->estado_suscripcion === 'active';

            $fechaInicio = $registro->fecha_inicio ? \Carbon\Carbon::parse(trim($registro->fecha_inicio)) : null;
            $fechaFin = $registro->fecha_fin ? \Carbon\Carbon::parse(trim($registro->fecha_fin)) : null;

            // CALCULAR DÍAS RESTANTES
            $diasRestantes = null;
            $claseDias = 'bg-green-100 text-green-800';
            if ($fechaFin) {
                $diasRestantes = $fechaFin->diffInDays(now(), false) * -1;
                if ($diasRestantes < 0) {
                    $claseDias = 'bg-red-100 text-red-800';
                    $diasRestantes = 'Vencido';
                } elseif ($diasRestantes <= 7) {
                    $claseDias = 'bg-yellow-100 text-yellow-800';
                }
            }

            // DETERMINAR COLORES Y ESTADOS
            $colorPrincipal = $planActivo ? 'green' : ($tienePlanAdquirido ? 'yellow' : 'gray');
            $iconoEstado = $planActivo ? 'fa-check-circle' : ($tienePlanAdquirido ? 'fa-clock' : 'fa-times-circle');
            $textoEstado = $planActivo ? 'ACTIVO' : ($tienePlanAdquirido ? 'ADQUIRIDO' : 'SIN PLAN');
        @endphp

        <!-- Modal de Detalle -->
        <div x-show="currentModal === 'detalle{{ $registro->id }}'" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div x-show="currentModal === 'detalle{{ $registro->id }}'" @click="closeModal()" class="fixed inset-0 bg-black bg-opacity-50"></div>
                <div x-show="currentModal === 'detalle{{ $registro->id }}'" class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <!-- Encabezado -->
                    <div class="bg-gray-50 px-6 py-4 rounded-t-lg border-b sticky top-0 z-10">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">
                                <i class="fas fa-user-circle mr-2"></i>Detalles del Registro #{{ $registro->id }}
                                <span class="ml-2 px-3 py-1 text-sm rounded-full bg-{{ $colorPrincipal }}-100 text-{{ $colorPrincipal }}-800">
                                    <i class="fas {{ $iconoEstado }} mr-1"></i>{{ $textoEstado }}
                                </span>
                            </h3>
                            <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Cuerpo -->
                    <div class="p-6">
                        <!-- Información Personal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h4 class="text-lg font-semibold text-blue-600 border-b pb-2 mb-4">
                                    <i class="fas fa-user mr-2"></i>Información Personal
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Nombre completo</p>
                                        <p class="text-gray-900">{{ $registro->nombres }} {{ $registro->apellido_paterno }} {{ $registro->apellido_materno }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Documento</p>
                                        <p class="text-gray-900">{{ $registro->tipo_documento }} - {{ $registro->nro_documento }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Fecha de nacimiento</p>
                                        <p class="text-gray-900">{{ $registro->fecha_nacimiento ? \Carbon\Carbon::parse($registro->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Género</p>
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">{{ $registro->genero }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-lg font-semibold text-blue-600 border-b pb-2 mb-4">
                                    <i class="fas fa-address-card mr-2"></i>Información de Contacto
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Email</p>
                                        <a href="mailto:{{ $registro->email }}" class="text-blue-600 hover:underline">{{ $registro->email }}</a>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Teléfono</p>
                                        <a href="tel:{{ $registro->nro_celular }}" class="text-blue-600 hover:underline">{{ $registro->nro_celular }}</a>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Fecha de registro</p>
                                        <p class="text-gray-900">{{ $registro->created_at ? \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Plan -->
                        @if($tienePlanAdquirido)
                        <div class="border-t pt-6">
                            <h4 class="text-lg font-semibold text-{{ $colorPrincipal }}-600 border-b pb-2 mb-4">
                                <i class="fas fa-crown mr-2"></i>Plan Adquirido
                            </h4>
                            <div class="bg-{{ $colorPrincipal }}-50 border border-{{ $colorPrincipal }}-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-4">
                                    <h5 class="text-xl font-bold text-{{ $colorPrincipal }}-700">
                                        <i class="fas fa-star mr-2"></i>{{ $registro->plan_nombre }}
                                    </h5>
                                    <div class="text-right">
                                        <span class="px-3 py-1 text-sm rounded-full bg-{{ $colorPrincipal }}-100 text-{{ $colorPrincipal }}-800">
                                            {{ $registro->estado_suscripcion ?? 'adquirido' }}
                                        </span>
                                        @if($diasRestantes && $planActivo)
                                            <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $claseDias }}">
                                                {{ is_numeric($diasRestantes) ? $diasRestantes . ' días' : $diasRestantes }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <div><strong><i class="fas fa-tag mr-2"></i>Plan:</strong> {{ $registro->plan_nombre }}</div>
                                        <div><strong><i class="fas fa-align-left mr-2"></i>Descripción:</strong> {{ $registro->plan_descripcion ?? 'No disponible' }}</div>
                                        <div><strong><i class="fas fa-money-bill-wave mr-2"></i>Precio:</strong> S/ {{ number_format($registro->plan_precio, 2) }}</div>
                                        <div><strong><i class="fas fa-layer-group mr-2"></i>Tipo:</strong> {{ $registro->plan_tipo ?? 'Estándar' }}</div>
                                    </div>
                                    <div class="space-y-2">
                                        <div><strong><i class="fas fa-calendar-alt mr-2"></i>Duración:</strong> {{ $registro->plan_duracion ?? '1' }} mes(es)</div>
                                        <div><strong><i class="fas fa-play-circle mr-2"></i>Fecha inicio:</strong> {{ $fechaInicio ? $fechaInicio->format('d/m/Y') : 'N/A' }}</div>
                                        <div><strong><i class="fas fa-flag-checkered mr-2"></i>Fecha fin:</strong> {{ $fechaFin ? $fechaFin->format('d/m/Y') : 'N/A' }}</div>
                                        @if($fechaInicio && $fechaFin && $planActivo)
                                            @php
                                                $totalDias = $fechaInicio->diffInDays($fechaFin);
                                                $diasTranscurridos = $fechaInicio->diffInDays(now());
                                                $porcentaje = min(100, max(0, ($diasTranscurridos / $totalDias) * 100));
                                            @endphp
                                            <div>
                                                <strong><i class="fas fa-chart-line mr-2"></i>Progreso:</strong>
                                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                    <div class="bg-{{ $colorPrincipal }}-600 h-2 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                                </div>
                                                <small class="text-gray-600">{{ number_format($porcentaje, 1) }}% completado</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if($registro->stripe_subscription_id)
                                <div class="mt-4 p-3 bg-gray-800 text-white rounded">
                                    <strong><i class="fas fa-receipt mr-2"></i>ID de Pago Stripe:</strong>
                                    <code class="ml-2">{{ $registro->stripe_subscription_id }}</code>
                                </div>
                                @endif

                                <div class="mt-4 p-3 bg-{{ $colorPrincipal }}-600 text-white rounded text-center">
                                    <strong>
                                        <i class="fas {{ $iconoEstado }} mr-2"></i>
                                        @if($planActivo)
                                            PLAN ACTIVO - El usuario tiene acceso completo a la plataforma
                                        @elseif($tienePlanAdquirido)
                                            PLAN ADQUIRIDO - Estado: {{ strtoupper($registro->estado_suscripcion ?? 'ADQUIRIDO') }}
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="border-t pt-6">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                                <i class="fas fa-times-circle text-gray-400 text-4xl mb-3"></i>
                                <h6 class="text-lg font-semibold text-gray-700 mb-2">Este usuario no ha adquirido ningún plan</h6>
                                <p class="text-gray-600">No se registran planes adquiridos para este usuario.</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center sticky bottom-0 border-t">
                        @if($tienePlanAdquirido)
                            <small class="text-gray-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                Plan: {{ $textoEstado }} | Adquirido el: {{ $fechaInicio ? $fechaInicio->format('d/m/Y') : 'Fecha no disponible' }}
                            </small>
                        @else
                            <div></div>
                        @endif
                        <div class="flex space-x-3">
                            <button @click="closeModal()" class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-100">
                                <i class="fas fa-times mr-1"></i>Cerrar
                            </button>
                            @if($tienePlanAdquirido)
                                <button class="px-4 py-2 text-sm bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                                    <i class="fas fa-cog mr-1"></i>Gestionar Plan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach 
</div>

<style>[x-cloak] { display: none !important; }</style>

<script>
function confirmarPago(id, nombre, plan) {
    if (confirm(`¿Confirmar pago de ${nombre} para el plan "${plan}"?`)) {
        // Aquí iría la lógica para confirmar el pago
        alert('Funcionalidad de confirmación de pago pendiente de implementar');
    }
}

function eliminarRegistro(id, nombre) {
    if (confirm(`¿Está seguro de eliminar el registro de ${nombre}?\n\nEsta acción no se puede deshacer.`)) {
        // Crear formulario para enviar DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/registros/${id}`;
        
        // Agregar token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        // Agregar método DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Agregar al body y enviar
        document.body.appendChild(form);
        form.submit();
    }
}
</script>