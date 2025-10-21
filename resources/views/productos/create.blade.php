{{-- Título H1 (lo actualizará el JS) --}}
<h1 id="view-title" class="d-none">Registrar Nuevo Producto</h1>

{{-- Contenido del formulario (dentro del wrapper que cargará el JS) --}}
<div class="card card-primary card-outline shadow-sm"> {{-- Usamos card-outline para el borde superior --}}
    <div class="card-header">
        <h3 class="card-title"><b>Llenar los campos del formulario</b></h3>
        <div class="card-tools">
            {{-- CAMBIO: Usar botón y data-url para GoTo() --}}
            <button type="button" class="btn btn-tool ajax-link" data-url="{{ route('productos.index') }}">
                <i class="fas fa-arrow-left"></i> <b>Volver</b>
            </button>
        </div>
    </div>
    <div class="card-body">
        {{-- CAMBIO: Añadir id="createForm" --}}
        <form id="createForm" action="{{ route('productos.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                {{-- Columna Izquierda --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="codigo" class="form-label fw-bold">Código del Repuesto</label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" placeholder="Ej: RPT-00123" value="{{ old('codigo') }}">
                        @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label fw-bold">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder="Ej: Mack, Iveco, Mercedes-Benz, Scania" value="{{ old('marca') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="medidas" class="form-label fw-bold">Medidas</label>
                            <select id="medidas" name="medidas" class="form-select">
                                <option value="" selected>Seleccione</option>
                                <option value="5 metros" @selected(old('medidas') == '5 metros')>5 metros</option>
                                <option value="10 pulgadas" @selected(old('medidas') == '10 pulgadas')>10 pulgadas</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unidades" class="form-label fw-bold">Unidades</label>
                            <select id="unidades" name="unidades" class="form-select">
                                <option value="" selected>Seleccione</option>
                                <option value="PZA" @selected(old('unidades') == 'PZA')>Pieza</option>
                                <option value="CAJA" @selected(old('unidades') == 'CAJA')>Caja</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Columna Derecha --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre del Repuesto</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Ej: Filtro de aceite" value="{{ old('nombre') }}" required>
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="modelo" class="form-label fw-bold">Modelo Compatible</label>
                        <select id="modelo" name="modelo" class="form-select">
                            <option value="" selected>Seleccione un modelo</option>
                            <option value="Modelo A1" @selected(old('modelo') == 'Modelo A1')>Modelo A1</option>
                            <option value="Modelo B2" @selected(old('modelo') == 'Modelo B2')>Modelo B2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label fw-bold">Tipo de Repuesto</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ej: Amortiguadores" value="{{ old('tipo') }}">
                    </div>
                </div>
                {{-- Fila Completa --}}
                <div class="col-12">
                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold">Descripción Repuesto</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                {{-- CAMBIO: Botón Cancelar también usa JS --}}
                <button type="button" class="btn btn-secondary ajax-link" data-url="{{ route('productos.index') }}">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-accion-principal">
                    <i class="bi bi-save-fill"></i>&nbsp;
                    Guardar Repuesto
                </button>
            </div>
        </form>
    </div>
</div>