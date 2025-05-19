@extends('template')

@section('title','Editar Tarjeta')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<style>
    .titulo-bloque {
        background-color: #004a91;
        color: white;
        font-weight: bold;
        padding: 6px 12px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .form-container {
        background-color: #e9efff;
        border: 1px solid #c9c9c9;
        border-radius: 4px;
        padding: 6px 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Editar Tarjeta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tarjetas.index') }}">Tarjetas</a></li>
        <li class="breadcrumb-item active">Editar Tarjeta</li>
    </ol>

    <div class="container w-100 mt-4">

        <!-- Título tipo barra -->
        <div class="titulo-bloque">
            Datos de la Tarjeta
        </div>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('tarjetas.update', $tarjeta['id']) }}" method="post">
                @csrf
                @method('PUT')

                <!-- Titular -->
                <div class="col-md-6 mb-3">
                    <label for="cuenta_id" class="form-label fw-bold">Titular:</label>
                    <select data-size="4" title="Seleccione el cliente" data-live-search="true" name="cuenta_id"
                        id="cuenta_id" class="form-control selectpicker show-tick" required>
                        @foreach ($cuentas as $cuenta)
                            <option value="{{ $cuenta['id'] }}"
                                {{ isset($tarjeta) && $cuenta['id'] == $tarjeta['cuenta_id'] ? 'selected' : '' }}>
                                {{ $cuenta['cliente']['usuario']['nombre'] }} {{ $cuenta['cliente']['usuario']['apellido'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Número de Tarjeta -->
                <div class="col-md-6 mb-3">
                    <label for="numero" class="form-label fw-bold">Número de Tarjeta:</label>
                    <input type="text" name="numero" id="numero" class="form-control"
                        value="{{ old('numero', $tarjeta['numero']) }}" required maxlength="16">
                </div>

                <!-- CVC -->
                <div class="col-md-4 mb-3">
                    <label for="cvc" class="form-label fw-bold">CVC:</label>
                    <input type="text" name="cvc" id="cvc" class="form-control"
                        value="{{ old('cvc', $tarjeta['cvc']) }}" required maxlength="3">
                </div>

                <!-- Fecha de Vencimiento -->
                <div class="col-md-4 mb-3">
                    <label for="fecha_vencimiento" class="form-label fw-bold">Fecha de Vencimiento:</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
                        value="{{ old('fecha_vencimiento', $tarjeta['fecha_vencimiento']) }}" required>
                </div>

                <!-- Tipo de Tarjeta -->
                <div class="col-md-4 mb-3">
                    <label for="tipo" class="form-label fw-bold">Tipo de Tarjeta:</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo_credito" value="Crédito"
                                {{ old('tipo', $tarjeta['tipo']) == 'Crédito' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="tipo_credito">Crédito</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" id="tipo_debito" value="Débito"
                                {{ old('tipo', $tarjeta['tipo']) == 'Débito' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="tipo_debito">Débito</label>
                        </div>
                    </div>
                </div>

                <!-- Botón Guardar -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar Tarjeta</button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush