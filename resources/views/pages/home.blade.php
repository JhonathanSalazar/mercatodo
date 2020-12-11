@extends('layouts.app')

@section('content')
    <section  class="carousel slice" id="home-slider">
        <div class="carousel-inner">
            <ul class="carousel-item active list-group">
                <li>
                    <img class="d-block w-100"
                         src="/shooper/themes/images/carousel/banner-1.jpg"
                         alt="First slice"/>
                </li>
            </ul>
        </div>
    </section>
    <section class="header_text">
        Ofrecemos las mejores mercancias de la región a los mejores mayoristas del país
        <br/>Siempre ofreciendoles lo mejor
    </section>
    <section class="main-content">
        <div class="row">
            <div class="col-md-12">
                <h4 class="title">
                    <span class="float-left"><span class="text"><span class="line">Productos <strong>Caracteristicos</strong></span></span></span>
                    <span class="float-right">
                        <a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
                    </span>
                </h4>
                <div id="myCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="thumbnails list-group d-flex flex-row">
                                @forelse($featuredProductsHome as $product)
                                    <div class="col-md-3">
                                        <x-product.home-carousel
                                            :product="$product"></x-product.home-carousel>
                                    </div>
                                @empty
                                    No hay productos para mostrar
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <h4 class="title">
                    <span class="float-left"><span class="text"><span class="line">ULTIMOS <strong>PRODUCTOS</strong></span></span></span>
                    <span class="float-right">
                        <a class="left button" href="#myCarousel-2" data-slide="prev"></a><a class="right button" href="#myCarousel-2" data-slide="next"></a>
                    </span>
                </h4>
                <div id="myCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="thumbnails list-group d-flex flex-row">
                                @forelse($lastProductsHome as $product)
                                    <div class="col-md-3">
                                        <x-product.home-carousel
                                            :product="$product"></x-product.home-carousel>
                                    </div>
                                @empty
                                    No hay productos para mostrar
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row feature_box py-4">
            <div class="col-md-4">
                <div class="service">
                    <div class="responsive">
                        <img src="/shooper/themes/images/feature_img_2.png" alt="" />
                        <h4>MODERN <strong>DESIGN</strong></h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and printing industry unknown printer.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service">
                    <div class="customize">
                        <img src="/shooper/themes/images/feature_img_1.png" alt="" />
                        <h4>FREE <strong>SHIPPING</strong></h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and printing industry unknown printer.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service">
                    <div class="support">
                        <img src="/shooper/themes/images/feature_img_3.png" alt="" />
                        <h4>24/7 LIVE <strong>SUPPORT</strong></h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and printing industry unknown printer.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our_client">
        <h4 class="title"><span class="text">Manufactures</span></h4>
        <div class="row">
            <div class="col-md-2">
                <a href="#"><img alt="" src="/shooper/themes/images/clients/14.png"></a>
            </div>
            <div class="col-md-2">
                <a href="#"><img alt="" src="/shooper/themes/images/clients/35.png"></a>
            </div>
            <div class="col-md-2">
                <a href="#"><img alt="" src="/shooper/themes/images/clients/1.png"></a>
            </div>
            <div class="col-md-2">
                <a href="#"><img alt="" src="/shooper/themes/images/clients/2.png"></a>
            </div>
            <div class="col-md-2">
                <a href="#"><img alt="" src="/shooper/themes/images/clients/3.png"></a>
            </div>
            <div class="col-md-2">
                <a href="#"><img alt="" src="/shooper/themes/images/clients/4.png"></a>
            </div>
        </div>
    </section>
@endsection
