<?php

namespace App\View\Components\Product;

use Illuminate\View\Component;
use Illuminate\View\View;

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
     * @var string
     */
    public $url;

    /**
     * @var int
     */
    public $id;


    /**
     * Create a new component instance.
     * @param string $name
     * @param string $image
     * @param string $price
     * @param string $category
     * @param string $url
     * @param int $id
     */
    public function __construct(string $name, string $image, string $price, string $category, string $url, int $id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
        $this->category = $category;
        $this->url = $url;
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
