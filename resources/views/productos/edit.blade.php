@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            
            <h2 class="text-center fw-bold" style="color: #2c519a;">Editar Producto/Repuesto</h2>
            <p class="text-center text-muted mb-4">Modifica la información del repuesto seleccionado.</p>

            {{-- 1. CAMBIO: La acción apunta a 'update' y el método es 'PUT' --}}
            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="row g-3">
                    {{-- Columna Izquierda --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="codigo" class="form-label fw-bold">Código del Repuesto</label>
                            {{-- 2. CAMBIO: Se rellena el valor --}}
                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ej: RPT-00123" value="{{ old('codigo', $producto->codigo) }}">
                        </div>
                        <div class="mb-3">
                            <label for="marca" class="form-label fw-bold">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" placeholder="Ej: Mack, Iveco, Mercedes-Benz, Scania" value="{{ old('marca', $producto->marca) }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="medidas" class="form-label fw-bold">Medidas</label>
                                <select id="medidas" name="medidas" class="form-select">
                                    {{-- 3. CAMBIO: Lógica para seleccionar el valor guardado --}}
                                    <option value="">Seleccione</option>
                                    <option value="5 metros" @selected(old('medidas', $producto->medidas) == '5 metros')>5 metros</option>
                                    <option value="10 pulgadas" @selected(old('medidas', $producto->medidas) == '10 pulgadas')>10 pulgadas</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="unidades" class="form-label fw-bold">Unidades</label>
                                <select id="unidades" name="unidades" class="form-select">
                                    <option value="">Seleccione</option>
                                    <option value="LT" @selected(old('unidades', $producto->unidades) == 'LT')>Litros</option>
                                    <option value="GL" @selected(old('unidades', $producto->unidades) == 'GL')>Galones</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Columna Derecha --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre del Repuesto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Filtro de aceite" value="{{ old('nombre', $producto->nombre) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="modelo" class="form-label fw-bold">Modelo Compatible</label>
                            <select id="modelo" name="modelo" class="form-select">
                                <option value="">Seleccione un modelo</option>
                                <option value="Modelo A1" @selected(old('modelo', $producto->modelo) == 'Modelo A1')>Modelo A1</option>
                                <option value="Modelo B2" @selected(old('modelo', $producto->modelo) == 'Modelo B2')>Modelo B2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label fw-bold">Tipo de Repuesto</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ej: Amortiguadores" value="{{ old('tipo', $producto->tipo) }}">
                        </div>
                    </div>

                    {{-- Fila Completa --}}
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">Descripción Repuesto</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Botón de Guardar --}}
                <div class="text-end mt-3">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #2c519a; border-color: #2c519a;">
                        <i class="bi bi-save-fill"></i>&nbsp;
                        Actualizar Repuesto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@stop