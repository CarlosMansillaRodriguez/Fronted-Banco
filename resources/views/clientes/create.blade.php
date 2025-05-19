@extends('template')

@section('title','Crear cliente')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<style>
    hr {
        border: 0; /* Elimina el estilo predeterminado */
        height: 4px; /* Cambia el grosor */
        background-color: #0d6efd; /* Cambia el color (azul en este caso) */
        margin: 20px 0; /* Ajusta el margen superior e inferior */
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index') }}">Clientes</a></li>
        <li class="breadcrumb-item active">Crear cliente</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('clientes.store') }}" method="post">
            @csrf
            <div class="row g-3">
                <!--Nombre-->
                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Nombres</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
                    @error('nombre')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <!--Apellido-->
                <div class="col-md-6 mb-2">
                    <label for="apellido" class="form-label">Apellidos</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido') }}">
                    @error('apellido')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <!--CI-->
                <div class="col-md-6 mb-2">
                    <label for="ci" class="form-label">Ci (Carnet de identidad)</label>
                    <input type="text" name="ci" id="ci" class="form-control" value="{{ old('ci') }}">
                    @error('ci')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <!--direccion-->
                <div class="col-md-12 mb-2">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
                    @error('direccion')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>

                <!--telefono-->
                <div class="col-md-4 mb-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
                    @error('telefono')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>
                <!--Fecha de nacimiento-->
                <div class="col-md-4 mb-4">
                    <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                    @error('fecha_nacimiento')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>
                <!--genero-->
                <div class="col-md-4 mb-4">
                    <label for="genero" class="form-label">Genero</label>
                    <input type="text" name="genero" id="genero" class="form-control" value="{{ old('genero') }}">
                    @error('genero')
                    <small class="text-danger">{{ '*'.$message }}</small>
                    @enderror
                </div>
                

                <!-- Sección de Datos de Usuario -->
                <div class="col-12 mt-4 mb-3 p-3s">
                    <h5 class="mb-4 text-primary">DATOS DE USUARIO</h5>
                    
                    <!---Nombre de Usuario---->
                    <div class="row mb-4">
                        <label for="nombre_user" class="col-lg-2 col-form-label">Nombre de Usuario:</label>
                        <div class="col-lg-4">
                            <input autocomplete="off" type="text" name="nombre_user" id="nombre_user" class="form-control" value="{{ old('nombre_user') }}" aria-labelledby="nameHelpBlock">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-text" id="nameHelpBlock">
                                Escriba un solo nombre
                            </div>
                        </div>
                        <div class="col-lg-2">
                            @error('nombre_user')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!---Email---->
                    <div class="row mb-4">
                        <label for="email" class="col-lg-2 col-form-label">Email:</label>
                        <div class="col-lg-4">
                            <input autocomplete="off" type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" aria-labelledby="emailHelpBlock">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-text" id="emailHelpBlock">
                                Dirección de correo electrónico
                            </div>
                        </div>
                        <div class="col-lg-2">
                            @error('email')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!---Password---->
                    <div class="row mb-4">
                        <label for="password" class="col-lg-2 col-form-label">Contraseña:</label>
                        <div class="col-lg-4">
                            <input type="password" name="password" id="password" class="form-control" aria-labelledby="passwordHelpBlock">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-text" id="passwordHelpBlock">
                                Escriba una contraseña segura. Debe incluir números.
                            </div>
                        </div>
                        <div class="col-lg-2">
                            @error('password')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!---Confirm_Password---->
                    <div class="row mb-4">
                        <label for="password_confirm" class="col-lg-2 col-form-label">Confirmar:</label>
                        <div class="col-lg-4">
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" aria-labelledby="passwordConfirmHelpBlock">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-text" id="passwordConfirmHelpBlock">
                                Vuelva a escribir su contraseña.
                            </div>
                        </div>
                        <div class="col-lg-2">
                            @error('password_confirm')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush