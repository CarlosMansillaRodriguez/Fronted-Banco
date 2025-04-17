@extends('template')

@section('title','Editar cuenta')

@push('css')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" rel="stylesheet"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <style>
        .titulo-bloque {
            background-color: #004a91; /* azul oscuro personalizado */
            color: white;
            font-weight: bold;
            padding: 6px 12px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
    
        .form-container {
            background-color: #e9efff; /* similar al fondo azul claro */
            border: 1px solid #c9c9c9;
            border-radius: 4px;
            padding: 6px 10px;
        }

    </style>

    

@endpush

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Editar cuenta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cuentas.index') }}">Cuentas</a></li>
        <li class="breadcrumb-item active">Editar cuenta</li>
    </ol>

    
    <div class="container w-100 mt-4">

        <!-- Título tipo barra -->
        <div class="titulo-bloque">
          Datos en general
        </div>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        
        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('cuentas.update')}}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
            <div class="row g-3">
                <!--titular-->
                <div class="col-md-6 mb-2">
                    <label for="titular" class="form-label">Titular:</label>
                    <select data-size="4" title="Seleccione el cliente" data-live-search="true" name="titular"
                        id="titular" class="form-control selectpicker show-tick">  
                        <option value="1">pepe 1</option>
                        <option value="2">pepe 2</option>
                        <option value="3">pepe 3</option>
                    </select>
                    
                </div>

                

                <!--Saldo-->
                <div class="col-md-6 mb-2">
                    <label for="saldo" class="form-label">Saldo</label>
                    <input type="text" name="saldo" id="saldo" class="form-control">
                </div>

                <!-- Moneda -->
                <div class="col-md-4 mb-2">
                    <label for="moneda_id" class="form-label">Moneda:</label>
                    <select data-size="4" title="Seleccione una moneda" data-live-search="true" name="moneda_id" 
                            id="moneda_id" class="form-control selectpicker show-tick">
                            
                            <option value="1">dato ejemplo 1</option>
                            <option value="2">dato ejemplo 2</option>
                            <option value="3">dato ejemplo 3</option>
                    </select>

                </div>
                <!-- tipo de cuenta -->
                <div class="col-md-4 mb-2">
                    <label for="tipocuenta_id" class="form-label">Tipo de cuenta:</label>
                    <select data-size="4" title="Seleccione un tipo de cuenta" data-live-search="true" name="tipocuenta_id"
                        id="tipocuenta_id" class="form-control selectpicker show-tick">  
                        <option value="1">dato ejemplo 1</option>
                        <option value="2">dato ejemplo 2</option>
                        <option value="3">dato ejemplo 3</option>
                    </select>
                    
                </div>

                <!--interes-->
                <div class="col-md-4 mb-2">
                    <label for="intereces" class="form-label">Interes</label>
                    <input type="text" name="intereces" id="intereces" class="form-control">
                    
                </div>

                <!--fecha-->
                <div class="col-md-6 mb-2">
                    <label for="fecha_de_apertura" class="form-label">Fecha de apetura</label>
                    <input type="date" name="fecha_de_apertura" id="fecha_de_apertura" class="form-control">
                </div>

                <!--Limite de retiro-->
                <div class="col-md-6 mb-2">
                    <label for="limite_de_retiro" class="form-label">Limite de retiro</label>
                    <input type="text" name="limite_de_retiro" id="limite_de_retiro" class="form-control">
                </div>
                
               

                

                

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>



</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush