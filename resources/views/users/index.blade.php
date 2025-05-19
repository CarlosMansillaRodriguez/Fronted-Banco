@extends('template')

@section('title','Usuarios')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">

<style>
    .datatable-selector {
        padding-right: 30px;
        height: auto;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        position: relative;
    }

    .datatable-selector::after {
        content: "\25BC";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
</style>
@endpush

@section('content')
    @if (session('success'))
    <script>
        let messagge = "{{ session('success') }}";
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });
    Toast.fire({
    icon: "success",
    title: messagge
    });
    </script>
    @endif
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>

    <div class="mb-4">
        <a href="{{ route('users.create') }}">
            <button type="button" class="btn btn-primary">Añadir nuevo usuario</button>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de usuarios
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $item)
                    <tr>
                        <td>{{ $item['nombre_user'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td>
                            {{ $item['roles'][0]['nombre'] ?? 'Sin rol' }}
                        </td>
                        <td>
                            @if ($item['estado'] == 1)    
                                <span class="badge rounded-pill text-bg-success d-inline">Activo</span>
                            @else
                                <span class="badge rounded-pill text-bg-danger d-inline">Eliminado</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{ route('users.edit', ['user' => $item['id']]) }}" method="get">
                                    <button type="submit" class="btn btn-warning">Editar</button>
                                </form> 
                                @if ($item['estado'] == 1)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item['id'] }}">Eliminar</button>
                                @else
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item['id'] }}">Restaurar</button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Modal de confirmación -->
                    <div class="modal fade" id="confirmModal-{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                        {{ $item['estado'] == 1 ? 'Eliminar usuario' : 'Restaurar usuario' }}
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $item['estado'] == 1 ? '¿Seguro que quieres eliminar al usuario?' : '¿Seguro que quieres restaurar al usuario?' }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('users.destroy', ['user' => $item['id']]) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn 
                                            {{ $item['estado'] == 1 ? 'btn-danger' : 'btn-success' }}">
                                            {{ $item['estado'] == 1 ? 'Eliminar' : 'Restaurar' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush