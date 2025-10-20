@extends('adminlte::page')

@section('title', 'Registrar Producto')

{{-- Quitamos el header por defecto para un look más limpio --}}
@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            
            {{-- Título y Subtítulo como en tu imagen --}}
            <h2 class="text-center fw-bold" style="color: #2c519a;">Productos/Repuestos</h2>
            <p class="text-center text-muted mb-4">Registro de repuestos utilizados en el mantenimiento de vehículos de carga pesada.</p>

            <form action="{{ route('productos.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    
                    {{-- Columna Izquierda --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="codigo" class="form-label fw-bold">Código del Repuesto</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ej: RPT-00123">
                        </div>
                        <div class="mb-3">
                            <label for="marca" class="form-label fw-bold">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" placeholder="Ej: Mack, Iveco, Mercedes-Benz, Scania">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="medidas" class="form-label fw-bold">Medidas</label>
                                <select id="medidas" name="medidas" class="form-select">
                                    <option value="" selected>Seleccione</option>
                                    {{-- TODO: Rellena esto desde la base de datos --}}
                                    <option value="5 metros">5 metros</option>
                                    <option value="10 pulgadas">10 pulgadas</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="unidades" class="form-label fw-bold">Unidades</label>
                                <select id="unidades" name="unidades" class="form-select">
                                    <option value="" selected>Seleccione</option>
                                    {{-- TODO: Rellena esto desde la base de datos --}}
                                    <option value="LT">Litros</option>
                                    <option value="GL">Galones</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Columna Derecha --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre del Repuesto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Filtro de aceite" required>
                        </div>
                        <div class="mb-3">
                            <label for="modelo" class="form-label fw-bold">Modelo Compatible</label>
                            <select id="modelo" name="modelo" class="form-select">
                                <option value="" selected>Seleccione un modelo</option>
                                {{-- TODO: Rellena esto desde la base de datos --}}
                                <option value="Modelo A1">Modelo A1</option>
                                <option value="Modelo B2">Modelo B2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label fw-bold">Tipo de Repuesto</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ej: Amortiguadores">
                        </div>
                    </div>

                    {{-- Fila Completa --}}
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">Descripción Repuesto</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Botón de Guardar --}}
                <div class="text-end mt-3">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #2c519a; border-color: #2c519a;">
                        <i class="bi bi-save-fill"></i>&nbsp;
                        Guardar Repuesto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Importamos Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@stop