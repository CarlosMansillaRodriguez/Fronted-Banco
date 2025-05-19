@extends('template')

@section('title','Empleados')

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
    <h1 class="mt-4 text-center">Empleados</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Empleados</li>
    </ol>
    <div class="mb-4">
        <a href="{{ route('empleados.create') }}">
            <button type="button" class="btn btn-primary">Añadir nuevo Empleado</button>
        </a>          
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Empleados
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Credenciales</th>
                        <th>Datos personales</th>
                        <th>Informacion Laboral</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>    
                <tbody>
                    @foreach ($empleados as $item)
                    <tr>
                        <td>{{ $item['usuario']['nombre'] }} {{ $item['usuario']['apellido'] }}</td>
                        <td>
                            <p class="fw-normal mb-1">Nombre de Usuario::</p>
                            <p class="text-muted mb-0">{{ $item['usuario']['nombre_user'] }}</p>
                            <p class="fw-normal mb-1">Email:</p>
                            <p class="text-muted mb-0">{{ $item['usuario']['email'] }}</p>
                        </td>
                        <td>
                            <p class="fw-normal mb-1">Género:</p>
                            <p class="text-muted mb-0">{{ $item['usuario']['genero'] }}</p>
                            <p class="fw-normal mb-1">Fecha de nacimiento:</p>
                            <p class="text-muted mb-0">{{ $item['usuario']['fecha_nacimiento'] }}</p>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#verModal-{{ $item['id'] }}">Detalles</button>
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
                                <form action="{{-- {{ route('empleados.edit', ['empleado' => $item['id']]) }} --}}" method="get">
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
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $item['estado'] == 1 ? '¿Seguro que quieres eliminar el empleado?' : '¿Seguro que quieres restaurar el empleado?' }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('empleados.destroy', ['empleado' => $item['id']]) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal para detalles de usuario -->
                    <div class="modal fade" id="verModal-{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del Empleado</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Cargo:</label>
                                        <input type="text" class="form-control" value="{{ $item['cargo'] }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Fecha de contrato:</label>
                                        <input type="date" class="form-control" value="{{ $item['fecha_contrato'] }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Hora de entrada:</label>
                                        <input type="time" class="form-control" value="{{ $item['horario_entrada'] }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Hora de salida:</label>
                                        <input type="time" class="form-control" value="{{ $item['horario_salida'] }}" disabled>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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