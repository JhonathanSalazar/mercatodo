@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Editar Orden</span></h2>
    </section>
    <section class="main-content">
        <form action="{{ route('orders.update', $order) }}" method="POST">
            @CSRF @method('PUT')
            <div class="row">
                <div class="col-12">
                    <h4 class="title"><span class="text"><strong>LISTA</strong> DE PRODUCTOS</span></h4>
                </div>
                <div class="col-8 offset-2">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Imagen</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>SubTotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td></td>
                                <td>{{ $item->pivot->quantity }}</td>
                                <td>$ {{ $item->pivot->price }}</td>
                                <td>$ {{ $item->pivot->quantity*$item->price }}</td>
                            </tr>
                        @empty
                            <tr>
                                No hay productos en su orden.
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h4 class="title"><span class="text"><strong>DATOS</strong> DE ENVIÓ</span></h4>
                </div>
                <div class="col-4 offset-1">
                    <h4>Información personal</h4>
                    <div class="form-group">
                        <label>Nombre Completo:</label>
                        <input name="payer_name"
                               type="text"
                               value="{{ old('name', $order->payer_name) }}"
                               class="form-control form-control-sm"
                               placeholder="Nombre completo">
                        {!! $errors->first('payer_name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Correo electronico:</label>
                        <input name="payer_email"
                               type="email"
                               value="{{ old('payer_email', $order->payer_email) }}"
                               class="form-control form-control-sm"
                               placeholder="Dirección correo electrónico">
                        {!! $errors->first('payer_email', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                        <select name="payer_documentType" class="form-control form-control-sm">
                            <option value="CC" {{ old('payer_documentType', $order->document_type) == 'CC' ? 'selected' : '' }}
                            >Cedula de ciudadania</option>
                            <option value="DI" {{ old('payer_documentType', $order->document_type) == 'DI' ? 'selected' : '' }}
                            >Documento de identidad</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número de Documento:</label>
                        <input name="payer_document"
                               type="text"
                               value="{{ old('document_number', $order->document_number) }}"
                               class="form-control form-control-sm"
                               placeholder="# Documento">
                        {!! $errors->first('document_number', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Celular:</label>
                        <input name="payer_phone"
                               type="text"
                               value="{{ old('payer_phone', $order->payer_phone) }}"
                               class="form-control form-control-sm"
                               placeholder="Número de celular">
                        {!! $errors->first('payer_phone', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="col-4 offset-2">
                    <h4>Tu dirección</h4>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <input name="payer_address"
                               type="text"
                               value="{{ old('payer_address', $order->payer_address) }}"
                               class="form-control form-control-sm"
                               placeholder="Dirección envío">
                        {!! $errors->first('payer_address', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Ciudad:</label>
                        <input name="payer_city"
                               type="text"
                               value="{{ old('payer_city', $order->payer_city) }}"
                               class="form-control form-control-sm"
                               placeholder="Dirección envío">
                        {!! $errors->first('payer_city', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Departamento:</label>
                        <input name="payer_state"
                               type="text"
                               value="{{ old('payer_state', $order->payer_state) }}"
                               class="form-control form-control-sm"
                               placeholder="Dirección envío">
                        {!! $errors->first('payer_state', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Código Postal:</label>
                        <input name="payer_postal"
                               type="text"
                               value="{{ old('payer_postal', $order->payer_postal) }}"
                               class="form-control form-control-sm"
                               placeholder="Dirección envío">
                        {!! $errors->first('payer_postal', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 center">
                    <button type="submit">Actualizar Orden</button>
                </div>
            </div>
        </form>
    </section>
@endsection()
