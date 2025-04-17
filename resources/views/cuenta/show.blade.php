@extends('template')

@section('title','Ver cuenta')

@push('css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 text-center">Ver cuenta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Cuentas</a></li>
            <li class="breadcrumb-item active">Ver cuenta</li>
        </ol>
    </div>

    <div class="container w-100">

        <div class="card p-2 mb-4">

        

            <!--Titular-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                        <input disabled type="text" class="form-control" value="Titular: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="colocar el nombre del titular">
                </div>
            </div>

            <!--Salado-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                        <input disabled type="text" class="form-control" value="Saldo: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="colocar el saldo">
                </div>
            </div>

            <!--Moneda-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                        <input disabled type="text" class="form-control" value="Moneda: ">
                    </div>
                    
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="colocar aqui el nombre de la moneda">
                </div>
            </div>

            <!--Tipo de cuenta-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                        <input disabled type="text" class="form-control" value="Tipo de cuenta: ">
                    </div>
                    
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="colocar aqui el tipo de cuenta">
                </div>
            </div>
            <!--Interes-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                        <input disabled type="text" class="form-control" value="Interes: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="colocar aqui el interes">
                </div>
            </div>
            <!--Limite de retiro-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-peso-sign"></i></span>
                        <input disabled type="text" class="form-control" value="Limite : ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="colocar aqui el limite de retiro">
                </div>
            </div>

            <!--Fecha de apertura-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input disabled type="text" class="form-control" value="Fecha de apertura: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="colocar aqui la fecha de apertura">
                </div>
            </div>

            
    </div>



    @endsection

@push('js')
   
@endpush