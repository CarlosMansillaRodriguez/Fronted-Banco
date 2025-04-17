@extends('template')

@section('title','clientes')

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

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Cuentas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Cuentas</li>
        </ol>

        
        <div class="mb-4">
            <a href="{{route('cuentas.create')}}">
                <button type="button" class="btn btn-primary">Añadir nueva cuenta</button>
            </a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de cuentas
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped fs-6">
                    <thead>
                        <tr>
                            <th>Titular</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                            <th>ver detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td></td>

                            <td>
                                <span class="badge rounded-pill text-bg-success d-inline">Activo</span>

                                {{-- <span class="badge rounded-pill text-bg-success d-inline">Eliminado</span> --}}
                            </td>
                            
                            <td class="d-flex justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                    {{-- <form action="{{route('clientes.edit')}}" method="get"> --}}
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                   {{--  </form> --}}
                                        <button type="button" class="btn btn-danger">Eliminar</button>
    
                                    <button type="button" class="btn btn-success" >Restaurar</button>
                                    
                                </div>
                                <td>
                                
                                    {{-- <form action="{{route('cuentas.show')}}"> --}}
                                        <button type="submit" class="btn btn-primary">Ver detalles</button>
                                    {{-- </form> --}}
                                </td>
                            </td>
                        </tr>
                    
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