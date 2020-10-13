@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Confirmar orden</span></h2>
    </section>
    <section class="main-content">
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
                    <p><strong>{{ $order->payer_name }}</strong></p>
                </div>
                <div class="form-group">
                    <label>Correo electronico:</label>
                    <p><strong>{{ $order->payer_email }}</strong></p>
                </div>
                <div class="form-group">
                    <label>Tipo de documento:</label>
                    <p><strong>
                        @if($order->document_type == 'CC')
                            Cedula de ciudadania
                        @else
                            Tarjeta de identidad
                        @endif
                    </strong></p>
                </div>
                <div class="form-group">
                    <label>Número de Documento:</label>
                    <p><strong>{{ $order->document_number }}</strong></p>
                </div>
                <div class="form-group">
                    <label>Celular:</label>
                    <p><strong>{{ $order->payer_phone }}</strong></p>
                </div>
            </div>
            <div class="col-4 offset-2">
                <h4>Tu dirección</h4>
                <div class="form-group">
                    <label>Dirección:</label>
                    <p><strong>{{ $order->payer_address }}</strong></p>
                </div>
                <div class="form-group">
                    <label>Ciudad:</label>
                    <p><strong>{{ $order->payer_city }}</strong></p>
                </div>
                <div class="form-group">
                    <label>Departamento:</label>
                    <p><strong>{{ $order->payer_state }}</strong></p>
                </div>
                <div class="form-group">
                    <label>Código Postal:</label>
                    <p><strong>{{ $order->payer_postal }}</strong></p>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            @if($order->status != 'APPROVED')
                <form action="{{ route('payment.store', $order) }}">
                    @CSRF
                    <button type="submit">Pagar Orden</button>
                    <a class="ml-2" href="{{ route('order.edit', $order) }}">Editar</a>
                </form>
            @else
                <form action="{{ route('order.index', $order->user_id) }}">
                    <button>Regresar</button>
                </form>
            @endif
        </div>
    </section>
@endsection()
