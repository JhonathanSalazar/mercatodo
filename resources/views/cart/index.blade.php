@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Carrito de compras</span></h2>
    </section>
    <section class="main-content">
        <div class="row">
            <div class="col-md-12">
                <h4 class="title"><span class="text"><strong>SU</strong> CARRITO</span></h4>
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th> </th>
                            <th>Imagen</th>
                            <th>Nombre Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($cartProducts as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('cart.delete', $product->id) }}">Borrar</a>
                                </td>
                                <td><a href=""><img alt="" src=""></a></td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $product->id) }}">
                                        <input name="quantity" type="number"  value="{{ $product->quantity }}">
                                        <input type="submit" value="Guardar">
                                    </form>
                                </td>
                                <td>$ {{ $product->price }}</td>
                                <td>$ {{ Cart::session(auth()->id())->get($product->id)->getPriceSum() }}</td>
                            </tr>
                        @empty
                            <tr>
                                No hay productos en su canasta aún.
                            </tr>
                         @endforelse
                        </tbody>
                    </table>
                </div>

                <hr>
                <p class="cart-total float-right mr-5">
                    <strong>Sub-Total</strong>:	$ {{ Cart::session(auth()->id())->getSubTotal() }}<br>
                    <strong>IVA (19%)</strong>: $NA<br>
                    <strong>Total</strong>: $NA<br>
                </p>

                <p class="buttons center">
                    <a href="{{ route('home') }}" class="btn-sm">Continuar</a>
                    <button type="submit" id="checkout">Checkout</button>
                </p>
            </div>
        </div>
    </section>
@endsection
