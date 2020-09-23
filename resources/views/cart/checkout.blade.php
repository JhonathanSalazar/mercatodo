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
        @if($errors->any())
            <ul class="list-group">
                @foreach($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        @endif
        <form action="{{ route('order.store') }}" method="POST" class="py-3">
            @CSRF
            <div class="row">
                <div class="col-4 offset-1">
                    <h4>Información personal</h4>
                    <div class="form-group">
                        <label>Nombre Completo:</label>
                        <input type="text" class="form-control form-control-sm" name="payer_name" placeholder="Jhonathan Salazar">
                    </div>
                    <div class="form-group">
                        <label>Correo electronico:</label>
                        <input type="email" class="form-control form-control-sm" name="payer_email" placeholder="me@email.com">
                    </div>
                    <div class="form-group">
                        <label>Tipo de documento:</label>
                        <select name="payer_documentType" class="form-control">
                            <option value=""></option>
                            <option value="CC">Cedula de ciudadania</option>
                            <option value="DI">Documento de identidad</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número de Documento:</label>
                        <input type="text" class="form-control form-control-sm" name="payer_document">
                    </div>
                    <div class="form-group">
                        <label>Celular:</label>
                        <input type="text" class="form-control form-control-sm" name="payer_phone" placeholder="3131112222">
                    </div>
                </div>
                <div class="col-4 offset-2">
                    <h4>Tu dirección</h4>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <input type="text" class="form-control form-control-sm" name="payer_address" placeholder="Kr 99 N 99 - 99">
                    </div>
                    <div class="form-group">
                        <label>Ciudad:</label>
                        <input type="text" class="form-control form-control-sm" name="payer_city" placeholder="Medellin">
                    </div>
                    <div class="form-group">
                        <label>Departamento:</label>
                        <input type="text" class="form-control form-control-sm" name="payer_state" placeholder="Antioquia">
                    </div>
                    <div class="form-group">
                        <label>Código Postal:</label>
                        <input type="text" class="form-control form-control-sm" name="payer_postal" placeholder="050030">
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
