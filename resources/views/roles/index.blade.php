@extends('template')

@section('title', 'Roles')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">

    <style>
        .datatable-selector {
            padding-right: 30px; /* Ajusta el padding para dar espacio suficiente a la flecha */
            height: auto; /* Ajusta la altura si es necesario */
            appearance: none; /* Esto elimina el estilo predeterminado del navegador */
            -webkit-appearance: none;
            -moz-appearance: none;
            position: relative;
        }
    
        .datatable-selector::after {
            content: "\25BC"; /* Código para la flecha hacia abajo */
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
        <h1 class="mt-4 text-center">Roles</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Roles</li>
        </ol>
        <div class="mb-4">
            <a href="{{ route('roles.create') }}">
                <button type="button" class="btn btn-primary">Añadir nuevo rol</button>
            </a>          
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla roles
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>    
                    <tbody>
                        @foreach ($roles as $item)
                        <tr>
                            <td>
                                {{ $item['nombre'] }}
                            </td>
                            <td>
                                @foreach ($item['permisos'] as $permiso)
                                    <span class="badge bg-info">{{ $permiso['nombre'] }}</span>
                                @endforeach
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{ route('roles.edit', ['role' => $item['id']]) }}" method="get">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item['id'] }}">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal de confirmacion -->
                        <div class="modal fade" id="confirmModal-{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Seguro que quieres eliminar el rol?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="{{ route('roles.destroy', ['role' => $item['id']]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Confirmar</button>
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