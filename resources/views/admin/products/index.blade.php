@extends('admin.layout')

@section('header')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

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
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Listado de productos</h3>

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
                            <a href="#"
                               class="btn btn-xs btn-info">
                                <i class="fa fa-pencil"></i>
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
