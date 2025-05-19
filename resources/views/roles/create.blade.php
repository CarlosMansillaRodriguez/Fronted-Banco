@extends('template')

@section('title','Crear rol')

@push('css')
@endpush

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Crear rol</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Crear rol</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('roles.store') }}" method="post">
            @csrf
            <div class="row g-3">
                <!-- Nombre del rol -->
                <div class="row mb-4 mt-4">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre de rol</label>
                    <div class="col-sm-4">
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
                    </div>
                    <div class="col-sm-6">
                        @error('nombre')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Permisos -->
                <div class="col-12 mb-4">
                    <label for="" class="form-label">Permisos para el rol:</label>
                    @foreach ($permisos as $permiso)
                        <div class="form-check mb-2">
                            <input type="checkbox" 
                                   name="permisos[]" 
                                   id="permiso_{{ $permiso['id'] }}" 
                                   class="form-check-input" 
                                   value="{{ $permiso['id'] }}"
                                   {{ in_array($permiso['id'], old('permisos', [])) ? 'checked' : '' }}>
                            <label for="permiso_{{ $permiso['id'] }}" class="form-check-label">
                                {{ $permiso['nombre'] }}
                            </label>
                        </div>
                    @endforeach
                </div>

                @error('permisos')
                    <small class="text-danger">{{ '*'.$message }}</small>
                @enderror

                <!-- Botón de guardar -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    // Puedes agregar scripts personalizados aquí si lo necesitas
</script>
@endpush