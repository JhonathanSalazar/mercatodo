<?php

namespace App\Http\Controllers\Customer;

use App\Entities\Product;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    /**
     * Return the main view.
     * @return View
     */
    public function home(): View
    {
        $featuredProductsHome = Product::with('category')->featuredHome()->get();

        $lastProductsHome = Product::with('category')->lastHome()->get();

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
