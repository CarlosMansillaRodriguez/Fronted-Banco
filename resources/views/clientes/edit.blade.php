@extends('template')

@section('title'.'Editar cliente')

@push('css')

@endpush

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Editar cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
        <li class="breadcrumb-item active">Editar cliente</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('clientes.update')}}" method="post">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <!--Nombre-->
                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                </div>

                <!--CI-->
                <div class="col-md-6 mb-2">
                    <label for="ci" class="form-label">Ci (Carnet de identidad)</label>
                    <input type="text" name="ci" id="ci" class="form-control">
                </div>


                <!--direccion-->
                <div class="col-md-12 mb-2">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control">
                    
                </div>

                <!--telefono-->
                
                <div class="col-md-4 mb-2">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control">
                </div>
                <!--Email-->
                <div class="col-md-4 mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control">
                </div>
               

                <!--fecha-->
                <div class="col-md-4 mb-2">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control">
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
    
@endpush

