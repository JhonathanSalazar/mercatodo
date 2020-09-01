@extends('layouts.app')

@section('content')
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
                                <a href="{{ route('cart.destroy', $product->id) }}"
                                   class="btn btn-sm btn-danger">Borrar</a>
                            </td>
                            <td><a href=""><img alt="" src=""></a></td>
                            <td>{{ $product->name }}</td>
                            <td><input type="text" placeholder="1" class="input-mini" value="{{ $product->quantity }}"></td>
                            <td>$ {{ $product->price }}</td>
                            <td>$2,350.00</td>
                        </tr>
                        @empty
                            <h1>No hay productos en su carrito</h1>
                        @endforelse
                        <tr>
                            <td><input type="checkbox" value="option1"></td>
                            <td><a href=""><img alt="" src=""></a></td>
                            <td>Luctus quam ultrices rutrum</td>
                            <td><input type="text" placeholder="2" class="input-mini"></td>
                            <td>$1,150.00</td>
                            <td>$2,450.00</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" value="option1"></td>
                            <td><a href=""><img alt="" src=""></a></td>
                            <td>Wuam ultrices rutrum</td>
                            <td><input type="text" placeholder="1" class="input-mini"></td>
                            <td>$1,210.00</td>
                            <td>$1,123.00</td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><strong>$3,600.00</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <hr>
                <p class="cart-total float-right mr-5">
                    <strong>Sub-Total</strong>:	$100.00<br>
                    <strong>IVA (19%)</strong>: $17.50<br>
                    <strong>Total</strong>: $119.50<br>
                </p>

                <p class="buttons center">
                    <button class="btn btn-danger" type="button">Actualizar</button>
                    <button class="btn btn-outline-primary" type="button">Continue</button>
                    <button class="btn btn-primary" type="submit" id="checkout">Checkout</button>
                </p>
            </div>
        </div>
    </section>
@endsection
