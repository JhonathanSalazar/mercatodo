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
    public function index():View
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
     * Create a new product instance after a valid registration.
     *
     * @param  array  $data
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store the specified resource.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //Validate
        $attributes = $request->validate([
            'name' => 'required',
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
