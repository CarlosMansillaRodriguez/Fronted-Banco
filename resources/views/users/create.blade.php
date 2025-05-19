@extends('template')

@section('title','Crear usuario')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Usuario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index')}}">Usuarios</a></li>
        <li class="breadcrumb-item active">Crear Usuario</li>
    </ol>

    <div class="card text-bg-light md-6">
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            <div class="card-header">
                <p class=" text-center">Nota: Los usuarios son los que pueden ingresar al sistema</p>
            </div>
            <div class="card-body">

                <!---Nombre---->
                <div class="row mb-4">
                    <label for="nombre_user" class="col-lg-2 col-form-label">Nombre de usuario:</label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" name="nombre_user" id="nombre_user" class="form-control" value="{{ old('nombre_user') }}" aria-labelledby="nombreUserHelpBlock">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text" id="nombreUserHelpBlock">
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
                    <label for="password_confirmation" class="col-lg-2 col-form-label">Confirmar:</label>
                    <div class="col-lg-4">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" aria-labelledby="passwordConfirmHelpBlock">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text" id="passwordConfirmHelpBlock">
                            Vuelva a escribir su contraseña.
                        </div>
                    </div>
                    <div class="col-lg-2">
                        @error('password_confirmation')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>

                <!---Roles---->
                <div class="row mb-4">
                    <label for="roles" class="col-lg-2 col-form-label">Rol:</label>
                    <div class="col-lg-4">
                        <select name="roles[]" id="roles" class="form-select"  aria-labelledby="rolHelpBlock">
                            <option value="" selected disabled>Seleccione:</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role['id'] }}" @selected(old('roles') && in_array($role['id'], old('roles')))>{{ $role['nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text" id="rolHelpBlock">
                            Escoja un rol para el usuario.
                        </div>
                    </div>
                    <div class="col-lg-2">
                        @error('roles')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="card-header">
                <p class="text-center">Datos personales</p>
            </div>
            <div class="card-body">
                <!--Nombres-->
                <div class="row mb-4">
                    <label for="nombre" class="col-lg-2 col-form-label">Nombre:</label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" aria-labelledby="nombreUserHelpBlock">
                    </div>
                    <div class="col-lg-2">
                        @error('nombre')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>
                <!--Apellidos-->
                <div class="row mb-4">
                    <label for="apellido" class="col-lg-2 col-form-label">Apellido</label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido') }}" aria-labelledby="nombreUserHelpBlock">
                    </div>
                    <div class="col-lg-2">
                        @error('apellido')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>
                <!--Genero-->
                <div class="row mb-4">
                    <label for="apellido" class="col-lg-2 col-form-label">Genero:</label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" name="genero" id="genero" class="form-control" value="{{ old('genero') }}" aria-labelledby="nombreUserHelpBlock">
                    </div>
                    <div class="col-lg-2">
                        @error('genero')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>
                <!--Fecha de nacimiento-->
                <div class="row mb-4">
                    <label for="fecha_nacimiento" class="col-lg-2 col-form-label">Fecha de nacimiento:</label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" aria-labelledby="nombreUserHelpBlock">
                    </div>
                    <div class="col-lg-2">
                        @error('fecha_nacimiento')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>

            </div> 
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush