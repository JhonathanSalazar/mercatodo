<div class="product-box">
    <span class="sale_tag"></span>
    <p><a href="{{ route('products.details', $id) }}"><img src="{{ $image }}" alt="{{ $name }}" class="img-fluid"/></a></p>
    <a href="{{ route('products.details', $id) }}" class="title">{{ $name }}</a><br/>
        <a href="{{ route('pages.category.show', $url) }}" class="category">{{ $category }}</a>
    <p class="price">$ {{ $price }}</p>
</div>
