@extends('template')

@section('title','Editar rol')

@push('css')

@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Rol</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index')}}">Roles</a></li>
        <li class="breadcrumb-item active">Editar rol</li>
    </ol>

    <div class="card">
        <div class="card-header">
            <p>Nota: Los roles son un conjunto de permisos</p>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update', ['role' => $role['id']]) }}" method="post">
                @method('PATCH')
                @csrf
                <!---Nombre de rol---->
                <div class="row mb-4">
                    <label for="nombre" class="col-md-auto col-form-label">Nombre del rol:</label>
                    <div class="col-md-4">
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $role['nombre']) }}">
                    </div>
                    <div class="col-md-4">
                        @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

                <!---Permisos---->
                <div class="col-12">
                    <label class="form-label">Permisos <span class="text-danger">*</span></label>                    
                    @foreach ($permisos as $permiso)
                        <div class="permisos-group mb-2">
                            <div class="form-check">
                                <input type="checkbox" 
                                    name="permisos[]" 
                                    id="permiso-{{ $permiso['id'] }}" 
                                    value="{{ $permiso['id'] }}"
                                    class="form-check-input"
                                    @if(in_array($permiso['id'], old('permisos', $permisosAsignados ?? []))) checked @endif>
                                <label for="permiso-{{ $permiso['id'] }}" class="form-check-label fw-bold">
                                    {{ $permiso['name'] ?? $permiso['nombre'] }}
                                </label>
                            </div>
                            @if(!empty($permiso['descripcion']))
                                <div class="permisos-item text-muted small ms-3">
                                    {{ $permiso['descripcion'] }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                    
                    @error('permisos')
                        <div class="text-danger small mt-2">{{ '*'.$message }}</div>
                    @enderror
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="reset" class="btn btn-secondary">Reiniciar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush


{{-- @extends('template')

@section('title', 'Editar Rol')

@push('css')
<style>
    .permisoss-container {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .permisos-group {
        margin-bottom: 10px;
    }
    .permisos-item {
        margin-left: 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Rol</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Editar Rol</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulario de Edición</h5>
                <span class="text-muted">ID: {{ $role['id'] }}</span>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.update', ['role' => $role['id']]) }}" method="post" id="role-edit-form">
                @method('PATCH')
                @csrf
                
                <!-- Nombre del Rol -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre del Rol <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                            value="{{ old('nombre', $role['nombre']) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" 
                            value="{{ old('descripcion', $role['descripcion'] ?? '') }}">
                    </div>
                </div>

                <!-- Permisos -->
                <div class="mb-4">
                    <label class="form-label">Permisos <span class="text-danger">*</span></label>
                    <div class="alert alert-info py-2">
                        <i class="fas fa-info-circle me-2"></i> Seleccione los permisos que tendrá este rol
                    </div>
                    
                    <div class="permisoss-container">
                        @foreach ($permisos as $permiso)
                            <div class="permisos-group">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           name="permisos[]" 
                                           id="permiso-{{ $permiso['id'] }}" 
                                           value="{{ $permiso['id'] }}"
                                           class="form-check-input"
                                           @if(in_array($permiso['id'], old('permisos', $permisosAsignados ?? []))) checked @endif>
                                    <label for="permiso-{{ $permiso['id'] }}" class="form-check-label fw-bold">
                                        {{ $permiso['name'] ?? $permiso['nombre'] }}
                                    </label>
                                </div>
                                @if(!empty($permiso['descripcion']))
                                    <div class="permisos-item text-muted small">
                                        {{ $permiso['descripcion'] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @error('permisos')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Regresar
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-danger me-2">
                            <i class="fas fa-undo me-1"></i> Reiniciar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar Rol
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        document.getElementById('role-edit-form').addEventListener('submit', function(e) {
            const checkedpermisoss = document.querySelectorAll('input[name="permisos[]"]:checked').length;
            
            if (checkedpermisoss === 0) {
                e.preventDefault();
                alert('Debe seleccionar al menos un permiso para el rol');
            }
        });
        
        // Select all/none functionality (opcional)
        // Puedes agregar botones para seleccionar todos/ninguno si hay muchos permisos
    });
</script>
@endpush --}}