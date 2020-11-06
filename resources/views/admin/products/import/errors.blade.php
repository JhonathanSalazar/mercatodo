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
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Listado de errores</h3>
        </div>
        <div class="box-body">
            <table id="admin-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Fila</th>
                    <th>Campo fallido</th>
                    <th>Descripción error</th>
                </tr>
                </thead>
                <tbody>
                {{dd($importErrors)}}
                @forelse($importErrors as $row => $errors)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->ean }}</td>
                        <td>{{ $product->name }}</td>
                @empty
                    <h5>No hay productos registrados aún</h5>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
