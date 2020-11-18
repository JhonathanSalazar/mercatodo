@extends('admin.layout')

@section('header')
    <h1>
        ERRORES IMPORTACIÓN
        <small>Listado</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Inicio</a></li>
        <li class="active">Productos</li>
    </ol>
@endsection

@section('content')
    <div class="alert @if($cant == 0) alert-danger @else alert-success @endif">
        {{ $cant }} productos fueron importados.
    </div>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Listado de errores</h3>
        </div>
        <div class="box-body">
            <table id="admin-table" class="table table-bordered table-striped center">
                <thead>
                <tr>
                    <th>Fila</th>
                    <th>Campo fallido</th>
                    <th>Descripción error</th>
                </tr>
                </thead>
                <tbody>
                @forelse($failures as $failure)
                    <tr>
                        <td>{{ $failure['row'] }}</td>
                        <td>{{ $failure['attribute'] }}</td>
                        <td>{{ $failure['error'][0] }}</td>
                @empty
                    <p>No hay errores</p>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
