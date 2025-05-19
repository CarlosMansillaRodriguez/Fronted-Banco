@extends('template')

@section('title','Editar usuario')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Usuario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index')}}">Usuarios</a></li>
        <li class="breadcrumb-item active">Editar Usuario</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('users.update', ['user' => $user['id']]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="card-header">
                <p class="">Nota: Los usuarios son los que pueden ingresar al sistema</p>
            </div>
            <div class="card-body">
                <!---Nombre---->
                <div class="row mb-4">
                    <label for="nombre_user" class="col-lg-2 col-form-label">Nombres:</label>
                    <div class="col-lg-4">
                        <input type="text" name="nombre_user" id="nombre_user" class="form-control" value="{{ old('nombre_user', $user['nombre_user']) }}">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
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
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user['email']) }}">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
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
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
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
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
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
                    <label for="roles" class="col-lg-2 col-form-label">Roles:</label>
                    <div class="col-lg-8">
                        <select name="roles[]" id="roles" class="form-select" aria-labelledby="rolHelpBlock">
                            @php
                                // Obtenemos los IDs de los roles actuales del usuario
                                $userRoleIds = collect($user['roles'])->pluck('id')->toArray();
                            @endphp

                            @foreach ($roles as $role)
                                <option value="{{ $role['id'] }}"
                                    {{ in_array($role['id'], $userRoleIds) ? 'selected' : '' }}>
                                    {{ $role['nombre'] }}
                                </option>
                            @endforeach
                        </select>
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
                        <input autocomplete="off" type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $user['nombre']) }}" aria-labelledby="nombreUserHelpBlock">
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
                        <input autocomplete="off" type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido', $user['apellido'])}}" aria-labelledby="nombreUserHelpBlock">
                    </div>
                    <div class="col-lg-2">
                        @error('apellido')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>
                <!--Genero-->
                <div class="row mb-4">
                    <label for="genero" class="col-lg-2 col-form-label">Genero:</label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" name="genero" id="genero" class="form-control" value="{{ old('genero', $user['genero']) }}" aria-labelledby="nombreUserHelpBlock">
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
                        <input autocomplete="off" type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $user['fecha_nacimiento'])}}" aria-labelledby="nombreUserHelpBlock">
                    </div>
                    <div class="col-lg-2">
                        @error('fecha_nacimiento')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

{{-- 
@extends('template')

@section('title','Editar usuario')

@push('css')
<style>
    .error-message {
        color: #dc3545;
        font-size: 0.875em;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Usuario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index')}}">Usuarios</a></li>
        <li class="breadcrumb-item active">Editar Usuario</li>
    </ol>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-light">
        <form action="{{ route('users.update', ['user' => $usuario['id']]) }}" method="post">
            @method('PUT')
            @csrf
            
            <div class="card-header">
                <p class="mb-0">Nota: Los usuarios son los que pueden ingresar al sistema</p>
            </div>
            
            <div class="card-body">
                <!-- Nombre -->
                <div class="row mb-4">
                    <label for="nombre_user" class="col-lg-2 col-form-label">Nombres:</label>
                    <div class="col-lg-4">
                        <input type="text" name="nombre_user" id="nombre_user" class="form-control @error('nombre_user') is-invalid @enderror" 
                               value="{{ old('nombre_user', $user->nombre_user) }}" required>
                        @error('nombre_user')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Escriba un solo nombre
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="row mb-4">
                    <label for="email" class="col-lg-2 col-form-label">Email:</label>
                    <div class="col-lg-4">
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Dirección de correo electrónico
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="row mb-4">
                    <label for="password" class="col-lg-2 col-form-label">Contraseña:</label>
                    <div class="col-lg-4">
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Escriba una contraseña segura (mínimo 6 caracteres)
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="row mb-4">
                    <label for="password_confirmation" class="col-lg-2 col-form-label">Confirmar:</label>
                    <div class="col-lg-4">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">
                            Vuelva a escribir su contraseña
                        </div>
                    </div>
                </div>

                <!-- Roles -->
                <div class="row mb-4">
                    <label class="col-lg-2 col-form-label">Roles:</label>
                    <div class="col-lg-8">
                        @foreach ($roles as $role)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="roles[]" 
                                       id="role_{{ $role->id }}" value="{{ $role->id }}"
                                       @if(in_array($role->id, old('roles', $user->roles->pluck('id')->toArray()))) checked @endif>
                                <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->nombre }}</label>
                            </div>
                        @endforeach
                        @error('roles')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection --}}