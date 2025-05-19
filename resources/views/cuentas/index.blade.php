@extends('template')

@section('title','Cuentas')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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

    <h1 class="mt-4 text-center">Cuentas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Cuentas</li>
    </ol>


    <!-- Botón para crear nueva cuenta -->
    <div class="mb-4">
        <a href="{{ route('cuentas.create') }}">
            <button type="button" class="btn btn-primary">Aperturar nueva cuenta</button>
        </a>
    </div>

    <!-- Tabla de cuentas -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de Cuentas
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Titular</th>
                        <th>Tipo de cuenta</th>
                        <th>Moneda</th>
                        <th>Saldo</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cuentas as $cuenta)
                        <tr>
                            <td>{{ $cuenta['cliente']['usuario']['nombre'] ?? 'Sin titular' }} {{ $cuenta['cliente']['usuario']['apellido'] ?? '' }}</td>
                            <td>{{$cuenta['tipo_de_cuenta']}}</td>
                            <td>{{ $cuenta['moneda'] }}</td>
                            <td>{{ number_format($cuenta['saldo'], 2) }}</td>
                            <td class="text-center">
                                @if ($cuenta['estado'] == 'Activado')
                                    <span class="badge rounded-pill text-bg-success d-inline">Activo</span>
                                @else
                                    <span class="badge rounded-pill text-bg-danger d-inline">Inactivo</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#verModal-{{ $cuenta['id'] }}"> Ver </button>
                                    <a href="{{ route('cuentas.edit', $cuenta['id']) }}" class="btn btn-warning">Editar</a>
                                    <button type="button" class="btn {{ $cuenta['estado'] == 'Activado' ? 'btn-danger' : 'btn-success' }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmModal-{{ $cuenta['id'] }}">
                                        {{ $cuenta['estado'] == 'Activado' ? 'Eliminar' : 'Restaurar' }}
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="confirmModal-{{ $cuenta['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            {{ $cuenta['estado'] == 'Activado' ? 'Confirmar eliminación' : 'Confirmar restauración' }}
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $cuenta['estado'] == 'Activado' ? '¿Seguro que quieres eliminar esta cuenta?' : '¿Seguro que quieres restaurar esta cuenta?' }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="{{ route('cuentas.destroy', ['cuenta' => $cuenta['id']]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para detalles de cuenta -->
                        <div class="modal fade" id="verModal-{{ $cuenta['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles de la Cuenta</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Número de Cuenta:</label>
                                            <input type="text" class="form-control" value="{{ $cuenta['numero_cuenta'] }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Fecha de Apertura:</label>
                                            <input type="text" class="form-control" value="{{ $cuenta['fecha_de_apertura'] }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Intereses (%):</label>
                                            <input type="text" class="form-control" value="{{ $cuenta['intereses'] }}%" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Límite de Retiro Diario:</label>
                                            <input type="text" class="form-control" value="{{ $cuenta['limite_de_retiro'] }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Estado:</label>
                                            <input type="text" class="form-control" value="{{ $cuenta['estado'] == 1 ? 'Activo' : 'Inactivo' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay cuentas registradas.</td>
                        </tr>
                    @endforelse
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