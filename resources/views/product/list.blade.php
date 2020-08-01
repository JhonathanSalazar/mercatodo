@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Product Detail</span></h2>
    </section>
    <div class="col">
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 py-3">
                    <x-product.home-carousel
                        name="{{ $product->name }}"
                        image="{{ $product->image }}"
                        price="{{ $product->price }}"
                        category="{{ $product->category->name }}"></x-product.home-carousel>
                </div>
            @empty
                No hay productos para mostrar
            @endforelse

            <div class="col-12 d-flex justify-content-center">
                <nav aria-label="...">
                    <ul class="pagination ">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection
