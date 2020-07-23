<?php

namespace App\Http\Controllers\Admin;


use App\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'role:Admin'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\View\View
     */
    public function index(Product $product):View
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     * @param  \App\Product  $product
     * @return Illuminate\View\View
     */
    public function show(Product $product):View
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Display the create view.
     *
     * @return Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.products.create');
    }

    /**
     * Store the specified resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //Validate
        $attributes = $request->validate([
            'name' => 'required',
            'ean' => 'required|integer|digits_between:8,14',
            'branch' => 'required',
            'price' => 'required|integer'
        ]);

        $userId = array('user_id' => auth()->id());

        $attributes = array_merge($attributes, $userId);

        //Presist
        Product::create($attributes);

        //Redirect
        return redirect(route('admin.products.index'));
    }
}
