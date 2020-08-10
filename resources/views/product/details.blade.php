@extends('layouts.app')

@section('content')
    <section class="center">
            <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
            <h2 class="py-3"><span>Detalles del producto: {{ $product->name }}</span></h2>
    </section>

    <section class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <img src="/storage/{{ $product->image }}" alt="{{ $product->name }}" class="img-thumbnail border-0">
                </div>
                <div class="col-md-3">
                    <address>
                        <strong>Nombre:</strong> <span>{{ $product->name }}</span><br>
                        <strong>Marca:</strong> <span>{{ $product->branch }}</span><br>
                        <strong>Código del producto:</strong> <span>{{ $product->ean }}</span><br>
                        <strong>Categoria:</strong>
                            <span><a href="{{ route('pages.category.show', $product->category->url) }}">{{ $product->category->name }}</a></span><br>
                    </address>
                    <h4><strong>Precio: ${{ $product->price }}</strong></h4>
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
            <div class="row justify-content-md-center py-5">
                <div class="col-md-6">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">Description</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">{{ $product->description }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection()
