@extends('template')

@section('title','Tarjetas')

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

    <h1 class="mt-4 text-center">Tarjetas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Tarjetas</li>
    </ol>



    <!-- Botón para crear nueva tarjeta -->
    <div class="mb-4">
        <a href="{{ route('tarjetas.create') }}">
            <button type="button" class="btn btn-primary">Añadir nueva tarjeta</button>
        </a>
    </div>

    <!-- Tabla de tarjetas -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de Tarjetas
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombre y Apellido</th>
                        <th>Número</th>
                        <th>Fecha de vencimiento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarjetas as $item)
                        <tr>
                            <td>
                                {{ $item['cuenta']['cliente']['usuario']['nombre'] ?? 'Sin titular' }} {{ $item['cuenta']['cliente']['usuario']['apellido'] ?? '' }}
                            </td>
                            <td>{{ $item['numero'] }}</td>
                            <td>{{ $item['fecha_vencimiento'] }}</td>
                            <td>
                                @if ($item['estado'] == 'Activado')
                                    <span class="badge rounded-pill text-bg-success d-inline">Activo</span>
                                @else
                                    <span class="badge rounded-pill text-bg-danger d-inline">Desactivado</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <form action="{{ route('tarjetas.edit', ['tarjeta' => $item['id']]) }}" method="get">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>

                                    @if ($item['estado'] == 'Activado')
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item['id'] }}">Desactivar</button>
                                    @else
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item['id'] }}">Activar</button>
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
                                            {{ $item['estado'] == 'Activado' ? 'Confirmar desactivación' : 'Confirmar activación' }}
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $item['estado'] == 'Activado' ? '¿Seguro que quieres desactivar esta tarjeta?' : '¿Seguro que quieres activar esta tarjeta?' }}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <form action="{{ route('tarjetas.destroy', ['tarjeta' => $item['id']]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn 
                                                {{ $item['estado'] == 'Activado' ? 'btn-danger' : 'btn-success' }}">
                                                {{ $item['estado'] == 'Activado' ? 'Desactivar' : 'Activar' }}
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
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush