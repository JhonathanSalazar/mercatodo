@extends('admin.layout')

@section('content')
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle"
                             src="/adminlte/dist/img/user4-128x128.jpg"
                             alt="{{ $user->name }}">

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">{{ $user->getRoleNames()->implode(', ') }}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Ciudad</b> <a class="pull-right">Medellin (COP) Static</a>
                            </li>
                            <li class="list-group-item">
                                <b>Telefono</b> <a class="pull-right">+57 3024247156 Static</a>
                            </li>
                            <li class="list-group-item">
                                <b>Dirección</b> <a class="pull-right">Static Address</a>
                            </li>
                        </ul>

                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block">
                            <b>Editar usuario</b>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Productos comprados</h3>

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
                                        <th>ID Producto</th>
                                        <th>Nombre Producto</th>
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
