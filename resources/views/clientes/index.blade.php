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
    <h1 class="mt-4 text-center">Clientes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Clientes</li>
    </ol>
    <div class="mb-4">
    <a href="{{ route('clientes.create') }}">
        <button type="button" class="btn btn-primary">Añadir nuevo cliente</button>
    </a>          
    </div>



    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Clientes
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Ci</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Direccion</th>
                        <th>Fecha</th>
                        <th>Estados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>    
                <tbody>
                    {{-- @foreach ($clientes as $item) --}}
                    <tr>
                        <td>
                            Joaquin Chumacero
                        </td>
                        <td>
                            41231455
                        </td>
                        <td>
                            67980404
                        </td>
                        <td>
                            av.moscu #500
                        </td>
                        <td>
                            av. Bush
                        </td>
                        <td>
                            16/04/2025
                        </td>
                        <td>

                                <span class="badge rounded-pill text-bg-success d-inline">Activo</span>

                                {{-- <span class="badge rounded-pill text-bg-success d-inline">Eliminado</span> --}}

                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                {{-- <form action="{{route('clientes.edit')}}" method="get"> --}}
                                    <button type="submit" class="btn btn-warning">Editar</button>
                               {{--  </form> --}}
                                    <button type="button" class="btn btn-danger">Eliminar</button>

                                <button type="button" class="btn btn-success" >Restaurar</button>

                                
                            </div>
                        </td>
                    </tr>
                    
                    {{-- @endforeach --}}
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
