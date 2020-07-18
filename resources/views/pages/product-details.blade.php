@extends('layouts.app')

@section('content')
    <section class="center">
            <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
            <h2 class="py-3"><span>Product Detail</span></h2>
    </section>

    <section class="main-content">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="col-md-4">
                    <img src="/shooper/themes/images/ladies/1.jpg" alt="" class="img-thumbnail border-0">
                </div>
                <div class="col-md-3">
                    <address>
                        <strong class="">Brand:</strong> <span>Apple</span><br>
                        <strong>Product Code:</strong> <span>Product 14</span><br>
                        <strong>Reward Points:</strong> <span>0</span><br>
                        <strong>Availability:</strong> <span>Out Of Stock</span><br>
                    </address>
                    <h4><strong>Price: $587.50</strong></h4>
                    <form action="" class="">
                        <div>
                            <strong>Cantidad:</strong>
                            <input type="text" class="input-small" placeholder="1">
                        </div>
                        <div class="py-3">
                        <button class="btn btn-outline-dark" type="submit">Agregar al carrito</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection()
