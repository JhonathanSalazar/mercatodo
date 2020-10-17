<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Return the main view.
     * @return View
     */
    public function home(): View
    {
        $featuredProductsHome = Product::featuredHome()->get();
        $lastProductsHome = Product::lastHome()->get();

        return view('pages.home', compact('featuredProductsHome', 'lastProductsHome'));
    }

    /**
     * Return the userAccount view.
     * @return View
     */
    public function userAccount(): View
    {
        return view('pages.userAccount');
    }


    /**
     * Return the checkout view.
     * @return View
     */
    public function aboutUs(): View
    {
        return view('pages.about');
    }

    /**
     * Return the checkout view.
     * @return View
     */
    public function contactUs(): View
    {
        return view('pages.contact');
    }
}
