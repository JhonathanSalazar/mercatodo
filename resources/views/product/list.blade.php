@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Lista de Productos</span></h2>
    </section>

    <div class="col">
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 py-3">
                    <x-product.home-carousel
                        :product="$product"></x-product.home-carousel>
                </div>
            @empty
                No hay productos para mostrar
            @endforelse

            <div class="col-12 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>

@endsection
