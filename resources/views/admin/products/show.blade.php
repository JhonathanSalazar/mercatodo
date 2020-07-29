@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-body box-profile">

                    @if($product->image)
                    <img class="img-responsive center-block"
                         src="/storage/{{ $product->image }}"
                         alt="{{ $product->name }}">
                    @endif

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Nombre</b> <a class="pull-right">{{ $product->name }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Código de producto</b> <a class="pull-right">{{ $product->ean }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Marca</b> <a class="pull-right">{{ $product->branch }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Precio</b> <a class="pull-right">{{ $product->price }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Fecha para publicacion</b> <a class="pull-right">{{ $product->published_at ? $product->published_at->format('m/d/Y') : null}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Categoria producto</b> <a class="pull-right">{{ $product->category ? $product->category->name : 'No definida' }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tags producto</b>
                            <a class="pull-right"
                            >@foreach($product->tags as $tag)
                                <span class="label label-primary">{{ $tag->name }}</span>
                             @endforeach</span></a>
                        </li>
                        <li class="list-group-item">
                            <b>Stock</b>
                            <a class="pull-right">
                                @if( $product->stock )
                                    <span class="label label-success">Disponible</span>
                                @else
                                    <span class="label label-danger">Agotado</span>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Descripcion</b>
                            <p class="text-muted">{{ $product->description }}</p>
                        </li>
                    </ul>

                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary btn-block">
                        <b>Editar producto</b>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Usuarios que compraron</h3>

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
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>ID </th>
                                    <th>Nombre Usuario</th>
                                    <th>Fecha de compra</th>
                                    <th>Estado transacción</th>
                                </tr>
                                <tr>
                                    <td>1111</td>
                                    <td>Cadeneta Acero 1</td>
                                    <td>11-7-2014</td>
                                    <td><span class="label label-success">Aprobada</span></td>
                                </tr>
                                <tr>
                                    <td>2222</td>
                                    <td>Vasos porcelana</td>
                                    <td>11-7-2014</td>
                                    <td><span class="label label-warning">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td>3333</td>
                                    <td>Globos cumpleaños x30</td>
                                    <td>11-7-2014</td>
                                    <td><span class="label label-primary">Aprobada</span></td>
                                </tr>
                                <tr>
                                    <td>4444</td>
                                    <td>Cuadernos 100h</td>
                                    <td>11-7-2014</td>
                                    <td><span class="label label-danger">Rechazada</span></td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </div>

@endsection
