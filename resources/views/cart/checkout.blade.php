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
        <form>
            <div class="row">
                <div class="col-4 offset-1">
                    <h4>Información personal</h4>
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" class="form-control form-control-sm" id="first-name" placeholder="Jhonathan">
                        </div>
                        <div class="form-group">
                            <label>Apellidos:</label>
                            <input type="text" class="form-control form-control-sm" id="last-name" placeholder="Salazar">
                        </div>
                        <div class="form-group">
                            <label>Correo electronico:</label>
                            <input type="email" class="form-control form-control-sm" id="email" placeholder="me@email.com">
                        </div>
                        <div class="form-group">
                            <label>Celular:</label>
                            <input type="text" class="form-control form-control-sm" id="phone" placeholder="3131112222">
                        </div>
                </div>
                <div class="col-4 offset-2">
                    <h4>Tu dirección</h4>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <input type="text" class="form-control form-control-sm" id="address" placeholder="Kr 99 N 99 - 99">
                    </div>
                    <div class="form-group">
                        <label>Ciudad:</label>
                        <input type="text" class="form-control form-control-sm" id="city" placeholder="Medellin">
                    </div>
                    <div class="form-group">
                        <label>Código Postal:</label>
                        <input type="text" class="form-control form-control-sm" id="postal" placeholder="050030">
                    </div>
                    <div class="form-group">
                        <label>País:</label>
                        <input type="text" class="form-control form-control-sm" id="country" placeholder="Colombia">
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
