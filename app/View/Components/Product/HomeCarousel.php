<?php

namespace App\View\Components\Product;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class HomeCarousel extends Component
{

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
     * Create a new component instance.
     * @param string $name
     * @param string $image
     * @param string $price
     * @param string $category
     */
    public function __construct(string $name, string $image, string $price, string $category)
    {

        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.product.home-carousel');
    }
}
