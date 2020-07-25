@extends('admin.layout')

@section('header')
    <h1>
        PRODUCTOS
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
            <h3 class="box-title">Listado de productos</h3>
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Crear producto</button>
        </div>

        <div class="box-body">
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <table id="admin-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>COD Producto</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->ean }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->branch }}</td>
                        <td>$ {{ $product->price }}</td>
                        <td>
                            @if($product->stock)
                                <span class="label label-success">Disponible</span>
                            @else
                                <span class="label label-danger">Agotado</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.show', $product) }}"
                               class="btn btn-xs btn-default">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-xs btn-info">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#"
                               class="btn btn-xs btn-danger">
                                <i class="fa fa-close"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <h5>No hay productos registrados aún</h5>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agrega el titulo de tu nuevo producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                            {{-- <label for="">Nombre producto:</label> --}}
                            <input name="name"
                                   type="text"
                                   value="{{ old('name') }}"
                                   class="form-control"
                                   placeholder="Ingrese el nombre del producto">
                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Crear producto</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endpush
