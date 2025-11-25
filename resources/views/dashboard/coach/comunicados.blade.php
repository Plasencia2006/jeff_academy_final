<!-- COMUNICADOS -->
<div class="space-y-6">
    <!-- Título de la sección -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-envelope text-blue-600 mr-3"></i>
            Comunicados
        </h1>
        <button onclick="document.getElementById('modalNuevoComunicado').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Nuevo Comunicado
        </button>
    </div>


    <!-- Tabla de comunicados -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">De</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Para</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contenido</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(isset($comunicados) && $comunicados->count() > 0)
                        @foreach($comunicados as $comunicado)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $comunicado->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $comunicado->remitente->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $comunicado->destinatario->name ?? 'Admin' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $comunicado->titulo }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ Str::limit($comunicado->contenido, 100) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Botón Ver Detalles -->
                                    <button 
                                        class="btn-view text-green-600 hover:text-green-800 transition-colors"
                                        data-titulo="{{ e($comunicado->titulo) }}"
                                        data-contenido="{{ e($comunicado->contenido) }}"
                                        data-fecha="{{ $comunicado->created_at->format('d/m/Y H:i') }}"
                                        data-remitente="{{ $comunicado->remitente->name ?? 'N/A' }}"
                                        data-destinatario="{{ $comunicado->destinatario->name ?? 'Admin' }}"
                                        title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($comunicado->remitente_id == Auth::id())
                                    <button 
                                        class="btn-edit text-blue-600 hover:text-blue-800 transition-colors"
                                        data-id="{{ $comunicado->id }}"
                                        data-titulo="{{ e($comunicado->titulo) }}"
                                        data-contenido="{{ e($comunicado->contenido) }}"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endif
                                    <form action="{{ route('coach.comunicados.destroy', $comunicado->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" onclick="return confirm('¿Estás seguro de eliminar este comunicado?')" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-envelope text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">No hay comunicados registrados</p>
                                    <p class="text-gray-400 text-sm mt-2">Crea tu primer comunicado para comenzar</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Nuevo Comunicado -->
<div id="modalNuevoComunicado" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-envelope text-blue-600 mr-2"></i>
                    Nuevo Comunicado
                </h3>
                <button onclick="document.getElementById('modalNuevoComunicado').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <form action="{{ route('coach.comunicados.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="tipo" value="coach_to_admin">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                    <input type="text" name="titulo" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contenido</label>
                    <textarea name="contenido" required rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modalNuevoComunicado').classList.add('hidden')" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Comunicado
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ver Detalles del Comunicado (compacto) -->
<div id="modalVerComunicado" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-2">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
        <div class="p-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-envelope-open text-green-600 mr-2"></i>
                    Detalles del Comunicado
                </h3>
                <button onclick="document.getElementById('modalVerComunicado').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
        <div class="p-3">
            <!-- Información del comunicado -->
            <div class="space-y-2">
                <div class="grid grid-cols-2 gap-2 pb-2 border-b border-gray-200">
                    <div>
                        <p class="text-xs text-gray-500">De:</p>
                        <p class="font-medium text-gray-900 text-sm" id="view_remitente"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Para:</p>
                        <p class="font-medium text-gray-900 text-sm" id="view_destinatario"></p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs text-gray-500">Fecha:</p>
                        <p class="font-medium text-gray-900 text-sm" id="view_fecha"></p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Título</label>
                    <div class="w-full px-2 py-2 bg-gray-50 border border-gray-200 rounded">
                        <p class="text-gray-900 font-semibold text-sm" id="view_titulo"></p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Contenido</label>
                    <div class="w-full px-2 py-2 bg-gray-50 border border-gray-200 rounded min-h-[70px] max-h-[150px] overflow-y-auto">
                        <p class="text-gray-900 whitespace-pre-wrap text-sm" id="view_contenido"></p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-3">
                <button type="button" onclick="document.getElementById('modalVerComunicado').classList.add('hidden')" class="px-3 py-1.5 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors text-sm">
                    <i class="fas fa-times mr-2"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Editar Comunicado -->
<div id="modalEditarComunicado" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-edit text-blue-600 mr-2"></i>
                    Editar Comunicado
                </h3>
                <button onclick="document.getElementById('modalEditarComunicado').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <form id="formEditarComunicado" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Título</label>
                    <input type="text" id="edit_titulo" name="titulo" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contenido</label>
                    <textarea id="edit_contenido" name="contenido" required rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modalEditarComunicado').classList.add('hidden')" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>


<script>
// Función para abrir modal de ver detalles
document.addEventListener('DOMContentLoaded', function() {
    // Escuchar clics en todos los botones de ver
    document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', function() {
            const titulo = this.getAttribute('data-titulo');
            const contenido = this.getAttribute('data-contenido');
            const fecha = this.getAttribute('data-fecha');
            const remitente = this.getAttribute('data-remitente');
            const destinatario = this.getAttribute('data-destinatario');
            
            // Llenar los campos con los datos
            document.getElementById('view_titulo').textContent = titulo || 'Sin título';
            document.getElementById('view_contenido').textContent = contenido || 'Sin contenido';
            document.getElementById('view_fecha').textContent = fecha || 'N/A';
            document.getElementById('view_remitente').textContent = remitente || 'N/A';
            document.getElementById('view_destinatario').textContent = destinatario || 'N/A';
            
            // Mostrar el modal
            document.getElementById('modalVerComunicado').classList.remove('hidden');
        });
    });
    
    // Escuchar clics en todos los botones de editar
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const titulo = this.getAttribute('data-titulo');
            const contenido = this.getAttribute('data-contenido');
            
            console.log('=== Abriendo modal de edición ===');
            console.log('ID:', id);
            console.log('Título:', titulo);
            console.log('Contenido:', contenido);
            
            // Establecer la acción del formulario
            const form = document.getElementById('formEditarComunicado');
            form.action = '{{ url("/coach/comunicados") }}/' + id;
            
            // Llenar los campos con los datos
            document.getElementById('edit_titulo').value = titulo || '';
            document.getElementById('edit_contenido').value = contenido || '';
            
            // Mostrar el modal
            document.getElementById('modalEditarComunicado').classList.remove('hidden');
        });
    });
    
    // Cerrar modal con tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('modalEditarComunicado').classList.add('hidden');
            document.getElementById('modalNuevoComunicado').classList.add('hidden');
        }
    });
});
</script>
