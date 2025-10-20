@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('content_header')
@stop

@section('content')

    <h2 class="page-title text-center">Lista de Productos</h2>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✅ {{ $message }}</strong> {{-- Añadí el emoji aquí --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-registrar">
                        <i class="bi bi-plus-circle"></i>&nbsp;Registrar Producto
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
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
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="action-icon me-2" title="Editar">
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
                {{ $productos->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .page-title {
            font-weight: 600;
            margin-bottom: 25px;
            color: #4a4a4a;
        }
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            border: none;
            border-radius: 0.75rem; 
        }
        .btn-registrar {
            background-color: #2c519a;
            border-color: #2c519a;
            border-radius: 0.375rem;
        }
        .table-header-custom {
            background-color: #f0f3f8;
            color: #2c519a;
            font-weight: 600;
        }
        .table-header-custom th {
            border-bottom: 0;
        }
        .action-icon {
            color: #0d6efd;
            text-decoration: none;
            font-size: 1.1rem;
        }
        .action-icon:hover {
            color: #0a58ca;
        }
        .action-icon-danger {
            background: none;
            border: none;
            padding: 0;
            color: #dc3545;
            text-decoration: none;
            font-size: 1.1rem;
            cursor: pointer;
        }
        .action-icon-danger:hover {
            color: #bb2d3b;
        }

        /* */
        .alert-fade-out {
            transition: opacity 0.5s ease-out;
            opacity: 0;
        }
    </style>
@stop

@section('js')
    <script>
        // Espera a que todo el DOM esté cargado
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- SOLUCIÓN 2: ARREGLO PARA EL BOTÓN DE ELIMINAR ---
            const deleteForms = document.querySelectorAll('.form-delete');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Detiene el envío
                    
                    // Se guarda el formulario en una variable
                    const formElement = this; 
                    
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, ¡elimínalo!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si se confirma, se usa la variable para enviar
                            formElement.submit();
                        }
                    });
                });
            });

            const successAlert = document.querySelector('.alert-success');
            
            if (successAlert) {
                // Espera 5 segundos (5000 milisegundos)
                setTimeout(() => {
                    // Agrega la clase para iniciar el fade-out
                    successAlert.classList.add('alert-fade-out');
                    
                    // Espera a que termine la animación (0.5s) para eliminarla
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500); 
                }, 5000); 
            }
        });
    </script>
@stop