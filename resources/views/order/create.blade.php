@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Información de Checkout</span></h2>
    </section>
    <section class="main-content">
        <div class="row">
            <div class="col-12">
                <h4 class="title"><span class="text"><strong>CUENTA</strong> Y DATOS DE FACTURA</span></h4>
            </div>
        </div>
        <form action="{{ route('orders.store') }}" method="POST" class="py-3">
            @CSRF
            <div class="row">
                <div class="col-4 offset-1">
                    <h4>Información personal</h4>
                    <div class="form-group">
                        <label>Nombre Completo:</label>
                        <input name="payer_name"
                               type="text"
                               value="{{ old('payer_name') }}"
                               class="form-control form-control-sm"
                               placeholder="Nombre completo">
                        {!! $errors->first('payer_name', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Correo electronico:</label>
                        <input name="payer_email"
                               type="email"
                               value="{{ old('payer_email') }}"
                               class="form-control form-control-sm"
                               placeholder="Dirección correo electrónico">
                        {!! $errors->first('payer_email', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                        <select name="payer_documentType" class="form-control form-control-sm">
                            <option value="">Seleccione un documento</option>
                            <option value="CC">Cedula de ciudadania</option>
                            <option value="DI">Documento de identidad</option>
                        </select>
                        {!! $errors->first('payer_documentType', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Número de Documento:</label>
                        <input name="payer_document"
                               type="text"
                               value="{{ old('payer_document') }}"
                               class="form-control form-control-sm"
                               placeholder="# Documento">
                        {!! $errors->first('payer_document', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Celular:</label>
                        <input name="payer_phone"
                               type="text"
                               value="{{ old('payer_phone') }}"
                               class="form-control form-control-sm"
                               placeholder="Número de celular">
                        {!! $errors->first('payer_phone', '<span class="alert-danger">:message</span>') !!}
                    </div>
                </div>
                <div class="col-4 offset-2">
                    <h4>Tu dirección</h4>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <input name="payer_address"
                               type="text"
                               value="{{ old('payer_address') }}"
                               class="form-control form-control-sm"
                               placeholder="Dirección de envío">
                        {!! $errors->first('payer_address', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Ciudad:</label>
                        <input name="payer_city"
                               type="text"
                               value="{{ old('payer_city') }}"
                               class="form-control form-control-sm"
                               placeholder="Ciudad de envío">
                        {!! $errors->first('payer_city', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Departamento:</label>
                        <input name="payer_state"
                               type="text"
                               value="{{ old('payer_state') }}"
                               class="form-control form-control-sm"
                               placeholder="Departamento de envío">
                        {!! $errors->first('payer_state', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label>Código Postal:</label>
                        <input name="payer_postal"
                               type="text"
                               value="{{ old('payer_postal') }}"
                               class="form-control form-control-sm"
                               placeholder="Código postal">
                        {!! $errors->first('payer_postal', '<span class="alert-danger">:message</span>') !!}
                    </div>
                    <div class="form-group">
                    <p>Despachos dispones para Colombia solamente</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 center">
                    <button class="submit">Confirmar orden</button>
                </div>
            </div>
        </form>
    </section>
@endsection
