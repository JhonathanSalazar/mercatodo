@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Product Detail</span></h2>
    </section>

    <div class="col">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 py-3">
                <div class="product-box">
                    <span class="sale_tag"></span>
                    <p><a href="{{ route('products.details') }}"><img src="/shooper/themes/images/ladies/1.jpg" alt="" class="img-fluid"/></a></p>
                    <a href="{{ route('products.details') }}" class="title">Ut wisi enim ad</a><br/>
                    <a href="products.html" class="category">Commodo consequat</a>
                    <p class="price">$17.25</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 py-3">
                <div class="product-box">
                    <span class="sale_tag"></span>
                    <p><a href="{{ route('products.details') }}"><img src="/shooper/themes/images/ladies/1.jpg" alt="" class="img-fluid"/></a></p>
                    <a href="{{ route('products.details') }}" class="title">Ut wisi enim ad</a><br/>
                    <a href="products.html" class="category">Commodo consequat</a>
                    <p class="price">$17.25</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 py-3">
                <div class="product-box">
                    <span class="sale_tag"></span>
                    <p><a href="{{ route('products.details') }}"><img src="/shooper/themes/images/ladies/1.jpg" alt="" class="img-fluid"/></a></p>
                    <a href="{{ route('products.details') }}" class="title">Ut wisi enim ad</a><br/>
                    <a href="products.html" class="category">Commodo consequat</a>
                    <p class="price">$17.25</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 py-3">
                <div class="product-box">
                    <span class="sale_tag"></span>
                    <p><a href="{{ route('products.details') }}"><img src="/shooper/themes/images/ladies/1.jpg" alt="" class="img-fluid"/></a></p>
                    <a href="{{ route('products.details') }}" class="title">Ut wisi enim ad</a><br/>
                    <a href="products.html" class="category">Commodo consequat</a>
                    <p class="price">$17.25</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 py-3">
                <div class="product-box">
                    <span class="sale_tag"></span>
                    <p><a href="{{ route('products.details') }}"><img src="/shooper/themes/images/ladies/1.jpg" alt="" class="img-fluid"/></a></p>
                    <a href="{{ route('products.details') }}" class="title">Ut wisi enim ad</a><br/>
                    <a href="products.html" class="category">Commodo consequat</a>
                    <p class="price">$17.25</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 py-3">

            </div>

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
