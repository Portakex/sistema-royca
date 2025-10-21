{{-- /resources/views/productos/components/indexContent.blade.php --}}
{{-- NO extiende ningún layout --}}

{{-- Título H1 (se actualizará con JS) --}}
{{-- <h1 id="view-title">Maestro de Productos</h1> --}} {{-- Movido al index principal --}}

{{-- Contenido de la tabla y buscador --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-8">
                <label for="searchKeywordProducto" class="form-label fw-bold">Buscar Productos:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchKeywordProducto" placeholder="Ingresa nombre del producto...">
                    <span class="input-group-text" style="cursor: pointer;">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-md-end">
                {{-- CAMBIO: Usar 'ajax-link' para que lo capture el JS --}}
                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-registrar ajax-link">
                    <i class="bi bi-plus-circle"></i>&nbsp;Registrar Producto
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            {{-- CAMBIO: Añadir id="tabla-productos" para posible recarga parcial futura --}}
            <table class="table" id="tabla-productos">
                <thead class="table-header-custom">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Medidas</th>
                        <th>Unidades</th>
                        <th>Tipo</th>
                        <th>Descripcion Repuesto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->modelo }}</td>
                            <td>{{ $producto->medidas }}</td>
                            <td>{{ $producto->unidades }}</td>
                            <td>{{ $producto->tipo }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>
                                {{-- CAMBIO: Usar 'ajax-link' para Editar --}}
                                <a href="{{ route('productos.edit', $producto->id) }}" class="action-icon me-2 ajax-link" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-icon-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{-- CAMBIO: Asegurarse de que los enlaces de paginación también usen AJAX --}}
            {{-- Laravel por defecto genera enlaces normales. Necesitamos interceptarlos con JS si queremos paginación AJAX --}}
            {{-- Por ahora, dejaremos que recarguen el wrapper completo al hacer clic --}}
            {{ $productos->links() }}
        </div>
    </div>
</div>