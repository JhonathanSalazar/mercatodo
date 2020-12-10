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
        </div>

        <div class="box-header pull-right">
            @can(Permissions::CREATE_PRODUCTS)
                <button class="btn btn-primary" data-toggle="modal" data-target="#createProduct"><i
                        class="fa fa-plus"></i> Crear producto
                </button>
            @endcan
            @can(Permissions::EXPORT)
                <a href="{{ route('admin.products.export') }}" class="btn btn-danger"><i class="fa fa-download"></i>
                    Exportar</a>
            @endcan
            @can(Permissions::IMPORT)
                <button class="btn btn-primary" data-toggle="modal" data-target="#importProduct"><i
                        class="fa fa-upload"></i> Importar
                </button>
            @endcan
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
                            @can(Permissions::VIEW_PRODUCTS)
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="btn btn-xs btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan
                            @can(Permissions::UPDATE_PRODUCTS)
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-xs btn-info">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @endcan
                            @can(Permissions::DELETE_PRODUCTS)
                                <form method="POST"
                                      action="{{ route('admin.products.destroy', $product) }}"
                                      style="display: inline">
                                    @CSRF @method('DELETE')
                                    <button class="btn btn-xs btn-danger"
                                            onclick="return confirm('Estas seguro de eliminar el producto? ')">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <h5>No hay productos registrados aún</h5>
                @endforelse
                </tbody>
            </table>
            {{ $products->links() }}

        </div>
    </div>
@endsection

@push('scripts')
    <!-- CreateProduct Modal -->
    <div class="modal fade" id="createProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agrega el titulo de tu nuevo producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                            <input name="name"
                                   type="text"
                                   value="{{ old('name') }}"
                                   class="form-control"
                                   placeholder="Ingrese el nombre del producto" required>
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

    <!-- ImportProducts Modal -->
    <div class="modal fade" id="importProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" action="{{ route('admin.products.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Importar productos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <a href="{{ route('admin.products.import.template') }}" class="pull-right btn btn-warning">Descargar plantilla</a>
                                <input name="productsImport"
                                       type="file"
                                       class="custom-file-input" required>
                                <label class="custom-file-label">Escoja el archivo</label>
                                {!! $errors->first('productsImport', '<span class="help-block alert-danger">:message</span>') !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Importar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endpush
