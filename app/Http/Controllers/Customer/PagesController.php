<?php

namespace App\Http\Controllers\Customer;

use App\Product;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Return the main view.
     *
     * @return Illuminate\View\View
     */
    public function home()
    {
        $featuredProductsHome = Product::featuredHome()->get();
        $lastProductsHome = Product::lastHome()->get();

        return view('pages.home', compact('featuredProductsHome', 'lastProductsHome'));
    }

    /**
     * Return the userAccount view.
     *
     * @return Illuminate\View\View
     */
    public function userAccount(): View
    {
        return view('pages.userAccount');
    }

    /**
     * Return the yourCar.
     *
     * @return Illuminate\View\View
     */
    public function yourCar(): View
    {
        return view('pages.yourCar');
    }

    /**
     * Return the checkout view.
     *
     * @return Illuminate\View\View
     */
    public function checkout(): View
    {
        return view('pages.checkout');
    }

    /**
     * Return the checkout view.
     *
     * @return Illuminate\View\View
     */
    public function aboutUs(): View
    {
        return view('pages.about');
    }

    /**
     * Return the checkout view.
     *
     * @return Illuminate\View\View
     */
    public function contactUs(): View
    {
        return view('pages.contact');
    }
}
