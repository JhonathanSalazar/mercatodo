<?php

namespace App\View\Components\Product;

use App\Entities\Product;
use Illuminate\View\Component;
use Illuminate\View\View;

class HomeCarousel extends Component
{

    /**
     * @var mixed
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $price;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->image = $product->getImageUrlAttribute();
        $this->price = $product->price;
        $this->category = $product->category->name;
        $this->url = $product->category->url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.product.home-carousel');
    }
}
