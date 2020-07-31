<div class="col-md-3">
    <div class="product-box">
        <span class="sale_tag"></span>
        <p><a href="{{ route('products.details') }}"><img src="/storage/{{ $image }}" alt="{{ $name }}" class="img-fluid"/></a></p>
        <a href="{{ route('products.details') }}" class="title">{{ $name }}</a><br/>
            <a href="products.html" class="category">{{ $category }}</a>
        <p class="price">$ {{ $price }}</p>
    </div>
</div>
