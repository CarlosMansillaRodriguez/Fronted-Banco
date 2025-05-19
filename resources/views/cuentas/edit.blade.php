{{-- @extends('template')

@section('title','Crear Cuenta')

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

    <h1 class="mt-4 text-center">Crear Cuenta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cuentas.index') }}">Cuentas</a></li>
        <li class="breadcrumb-item active">Crear Cuenta</li>
    </ol>

        <form action="{{ route('cuentas.update', $cuenta['id']) }}" method="post">
            @csrf
            <div class="container mt-4">
                <div class="row gy-4">
                    <!----- Datos de la cuenta--->
                    <div class="col-md-12">
                        <div>
                            <div class="text-white bg-primary p-1 text-center">
                                Detalles de la cuenta   
                            </div>
                            <div class="p-3 border border-3 border-primary">
                                <div class="row">
                                    <!-- Número de cuenta -->
                                    <div class="col-md-6 mb-3">
                                        <label for="numero_cuenta" class="form-label fw-bold">Número de Cuenta:</label>
                                        <input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control" value="{{ $cuenta['numero_cuenta'] }}" required>
                                    </div>
                                    <!-- Saldo Inicial -->
                                    <div class="col-md-6 mb-3">
                                        <label for="saldo" class="form-label fw-bold">Saldo Inicial:</label>
                                        <input type="number" step="0.01" name="saldo" id="saldo" class="form-control" required>
                                    </div>
                                    <!-- Fecha de Apertura -->
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha_de_apertura" class="form-label fw-bold">Fecha de Apertura:</label>
                                        <input type="date" name="fecha_de_apertura" id="fecha_de_apertura" class="form-control" required>
                                    </div>
                                    <!-- Moneda -->
                                    <div class="col-md-6 mb-3">
                                        <label for="moneda" class="form-label fw-bold">Moneda:</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="moneda" id="moneda_bob" value="BOB" required>
                                                <label class="form-check-label" for="moneda_bob">BOB</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="moneda" id="moneda_usd" value="USD" required>
                                                <label class="form-check-label" for="moneda_usd">USD</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tipo de Cuenta -->
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_de_cuenta" class="form-label fw-bold">Tipo de Cuenta:</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipo_de_cuenta" id="tipo_corriente" value="Corriente" required>
                                                <label class="form-check-label" for="tipo_corriente">Corriente</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipo_de_cuenta" id="tipo_ahorro" value="Ahorro" required>
                                                <label class="form-check-label" for="tipo_ahorro">Ahorro</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Intereses -->
                                    <div class="col-md-6 mb-3">
                                        <label for="intereses" class="form-label fw-bold">Intereses (%):</label>
                                        <input type="number" step="0.01" name="intereses" id="intereses" class="form-control" required>
                                    </div>
                                    <!-- Límite de Retiro Diario -->
                                    <div class="col-md-6 mb-3">
                                        <label for="limite_de_retiro" class="form-label fw-bold">Límite de Retiro:</label>
                                        <input type="number" step="0.01" name="limite_de_retiro" id="limite_de_retiro" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-----Datos del cliente--->
                    <div class="col-md-12">
                        <div class="text-white bg-primary p-1 text-center">
                            Datos del cliente  
                        </div>
                        <div class="p-3 border border-3 border-primary">
                            <div class="row">
                                
                                <div class="row g-3">

                                    <!--Nombre-->
                                    <div class="col-md-6 mb-2">
                                        <label for="nombre" class="form-label fw-bold">Nombres</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
                                        @error('nombre')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>

                                    <!--Apellido-->
                                    <div class="col-md-6 mb-2">
                                        <label for="apellido" class="form-label fw-bold">Apellidos</label>
                                        <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido') }}">
                                        @error('apellido')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                                    <!--direccion-->
                                    <div class="col-md-12 mb-2">
                                        <label for="direccion" class="form-label fw-bold">Dirección</label>
                                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
                                        @error('direccion')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>

                                    <!--CI-->
                                    <div class="col-md-6 mb-2">
                                        <label for="ci" class="form-label fw-bold">Ci (Carnet de identidad)</label>
                                        <input type="text" name="ci" id="ci" class="form-control" value="{{ old('ci') }}">
                                        @error('ci')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                                    <!--Fecha de nacimiento-->
                                    <div class="col-md-6 mb-2">
                                        <label for="fecha_nacimiento" class="form-label fw-bold">Fecha de nacimiento</label>
                                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                                        @error('fecha_nacimiento')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                                    <!--telefono-->
                                    <div class="col-md-6 mb-4">
                                        <label for="telefono" class="form-label fw-bold">Teléfono</label>
                                        <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
                                        @error('telefono')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                                    
                                    <!-- Género -->
                                    <div class="col-md-6 mb-4">
                                        <label for="genero" class="form-label fw-bold">Género</label>
                                        <select name="genero" id="genero" class="form-select"  aria-labelledby="rolHelpBlock">
                                            <option value="" selected disabled>Seleccione un genero:</option>
                                            <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>M - Masculino</option>
                                            <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>F - Femenino</option>
                                        </select>
                                        @error('genero')
                                            <small class="text-danger">{{ '*'.$message }}</small>
                                        @enderror
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-----Datos del Usuario--->
                    <div class="col-md-12">
                        <div class="text-white bg-primary p-1 text-center">
                            Datos del Usuario  
                        </div>
                        <div class="p-3 border border-3 border-primary">
                            <div class="row">
                                
                                <div class="row g-3">

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
                                    Escriba una contraseña segura, Mínimo 8 caracteres. Debe incluir números.
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
                                    
                            </div>
                        </div>
                    </div>
                    <!-- Botón Guardar -->
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </form>        
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush
--}}

@extends('template')
@section('title','Editar Cuenta')
@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js "></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select @1.14.0-beta3/dist/css/bootstrap-select.min.css">
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
    <h1 class="mt-4 text-center">Editar Cuenta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cuentas.index') }}">Cuentas</a></li>
        <li class="breadcrumb-item active">Editar Cuenta</li>
    </ol>


    <form action="{{ route('cuentas.update', ['cuenta' => $cuenta['id']]) }}" method="POST">
        @csrf
        @method('PUT')
    
        <div class="container mt-4">
            <div class="row gy-4">
    
                <!-- Datos de la cuenta -->
                <div class="col-md-12">
                    <div class="text-white bg-primary p-1 text-center">Detalles de la cuenta</div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!-- Número de cuenta -->
                            <div class="col-md-6 mb-3">
                                <label for="numero_cuenta" class="form-label fw-bold">Número de Cuenta:</label>
                                <input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control"
                                    value="{{ old('numero_cuenta', $cuenta['numero_cuenta']) }}" required>
                            </div>
                            <!-- Saldo Inicial -->
                            <div class="col-md-6 mb-3">
                                <label for="saldo" class="form-label fw-bold">Saldo Inicial:</label>
                                <input type="number" step="0.01" name="saldo" id="saldo" class="form-control"
                                    value="{{ old('saldo', $cuenta['saldo']) }}" required>
                            </div>
                            <!-- Fecha de Apertura -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_de_apertura" class="form-label fw-bold">Fecha de Apertura:</label>
                                <input type="date" name="fecha_de_apertura" id="fecha_de_apertura" class="form-control"
                                    value="{{ old('fecha_de_apertura', $cuenta['fecha_de_apertura']) }}" required>
                            </div>
                            <!-- Moneda -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Moneda:</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="moneda" id="moneda_bob" value="BOB"
                                            {{ old('moneda', $cuenta['moneda']) == 'BOB' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="moneda_bob">BOB</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="moneda" id="moneda_usd" value="USD"
                                            {{ old('moneda', $cuenta['moneda']) == 'USD' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="moneda_usd">USD</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Tipo de Cuenta -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipo de Cuenta:</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipo_de_cuenta" id="tipo_corriente" value="Corriente"
                                            {{ old('tipo_de_cuenta', $cuenta['tipo_de_cuenta']) == 'Corriente' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="tipo_corriente">Corriente</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipo_de_cuenta" id="tipo_ahorro" value="Ahorro"
                                            {{ old('tipo_de_cuenta', $cuenta['tipo_de_cuenta']) == 'Ahorro' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="tipo_ahorro">Ahorro</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Intereses -->
                            <div class="col-md-6 mb-3">
                                <label for="intereses" class="form-label fw-bold">Intereses (%):</label>
                                <input type="number" step="0.01" name="intereses" id="intereses" class="form-control"
                                    value="{{ old('intereses', $cuenta['intereses']) }}" required>
                            </div>
                            <!-- Límite de Retiro Diario -->
                            <div class="col-md-6 mb-3">
                                <label for="limite_de_retiro" class="form-label fw-bold">Límite de Retiro:</label>
                                <input type="number" step="0.01" name="limite_de_retiro" id="limite_de_retiro" class="form-control"
                                    value="{{ old('limite_de_retiro', $cuenta['limite_de_retiro']) }}">
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Datos del cliente -->
                <div class="col-md-12">
                    <div class="text-white bg-primary p-1 text-center">Datos del cliente</div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-2">
                                <label for="nombre" class="form-label fw-bold">Nombres:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                    value="{{ old('nombre', $cuenta['cliente']['usuario']['nombre'] ?? '') }}">
                                @error('nombre')
                                    <small class="text-danger">{{ '*'.$message }}</small>
                                @enderror
                            </div>
                            <!-- Apellido -->
                            <div class="col-md-6 mb-2">
                                <label for="apellido" class="form-label fw-bold">Apellidos:</label>
                                <input type="text" name="apellido" id="apellido" class="form-control"
                                    value="{{ old('apellido', $cuenta['cliente']['usuario']['apellido'] ?? '') }}">
                                @error('apellido')
                                    <small class="text-danger">{{ '*'.$message }}</small>
                                @enderror
                            </div>
                            <!-- Dirección -->
                            <div class="col-md-12 mb-2">
                                <label for="direccion" class="form-label fw-bold">Dirección:</label>
                                <input type="text" name="direccion" id="direccion" class="form-control"
                                    value="{{ old('direccion', $cuenta['cliente']['direccion'] ?? '') }}">
                                @error('direccion')
                                    <small class="text-danger">{{ '*'.$message }}</small>
                                @enderror
                            </div>
                            <!-- CI -->
                            <div class="col-md-6 mb-2">
                                <label for="ci" class="form-label fw-bold">Ci (Carnet de identidad):</label>
                                <input type="text" name="ci" id="ci" class="form-control"
                                    value="{{ old('ci', $cuenta['cliente']['ci'] ?? '') }}">
                                @error('ci')
                                    <small class="text-danger">{{ '*'.$message }}</small>
                                @enderror
                            </div>
                            <!-- Fecha de nacimiento -->
                            <div class="col-md-6 mb-2">
                                <label for="fecha_nacimiento" class="form-label fw-bold">Fecha de nacimiento:</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
                                    value="{{ old('fecha_nacimiento', $cuenta['cliente']['usuario']['fecha_nacimiento'] ?? '') }}">
                                @error('fecha_nacimiento')
                                    <small class="text-danger">{{ '*'.$message }}</small>
                                @enderror
                            </div>
                            <!-- Teléfono -->
                            <div class="col-md-6 mb-4">
                                <label for="telefono" class="form-label fw-bold">Teléfono:</label>
                                <input type="text" name="telefono" id="telefono" class="form-control"
                                    value="{{ old('telefono', $cuenta['cliente']['telefono'] ?? '') }}">
                                @error('telefono')
                                    <small class="text-danger">{{ '*'.$message }}</small>
                                @enderror
                            </div>
                            <!-- Género -->
                            <div class="col-md-6 mb-4">
                                <label for="genero" class="form-label fw-bold">Género:</label>
                                <select name="genero" id="genero" class="form-select">
                                    <option value="" disabled>Seleccione un género</option>
                                    <option value="M" {{ old('genero', $cuenta['cliente']['usuario']['genero'] ?? '') == 'M' ? 'selected' : '' }}>M - Masculino</option>
                                    <option value="F" {{ old('genero', $cuenta['cliente']['usuario']['genero'] ?? '') == 'F' ? 'selected' : '' }}>F - Femenino</option>
                                </select>
                                @error('genero')
                                    <small class="text-danger">{{ '*'.$message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Datos del Usuario -->
                <div class="col-md-12">
                    <div class="text-white bg-primary p-1 text-center">Datos del Usuario</div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!-- Nombre de usuario -->
                            <div class="row mb-4">
                                <label for="nombre_user" class="col-lg-2 col-form-label">Nombre de usuario:</label>
                                <div class="col-lg-4">
                                    <input autocomplete="off" type="text" name="nombre_user" id="nombre_user" class="form-control"
                                        value="{{ old('nombre_user', $cuenta['cliente']['usuario']['nombre_user'] ?? '') }}">
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-text">Escriba un solo nombre</div>
                                </div>
                                <div class="col-lg-2">
                                    @error('nombre_user')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="row mb-4">
                                <label for="email" class="col-lg-2 col-form-label">Email:</label>
                                <div class="col-lg-4">
                                    <input autocomplete="off" type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', $cuenta['cliente']['usuario']['email'] ?? '') }}">
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-text">Dirección de correo electrónico</div>
                                </div>
                                <div class="col-lg-2">
                                    @error('email')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Contraseña -->
                            <div class="row mb-4">
                                <label for="password" class="col-lg-2 col-form-label">Contraseña:</label>
                                <div class="col-lg-4">
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-text">Opcional. Mínimo 8 caracteres.</div>
                                </div>
                                <div class="col-lg-2">
                                    @error('password')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Confirmar contraseña -->
                            <div class="row mb-4">
                                <label for="password_confirmation" class="col-lg-2 col-form-label">Confirmar:</label>
                                <div class="col-lg-4">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-text">Vuelva a escribir su contraseña.</div>
                                </div>
                                <div class="col-lg-2">
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ '*'.$message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Botón Guardar -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select @1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush