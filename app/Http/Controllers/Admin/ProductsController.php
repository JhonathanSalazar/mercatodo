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

    public function create(): View
    {
        return view('admin.products.create');
    }
    */

    /**
     * Store the specified resource.
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $attributes = $this->validate($request, ['name' => 'required']);

        $userId = array('user_id' => auth()->id());

        $attributes = array_merge($attributes, $userId);

        $product = Product::create($attributes);

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Store the specified resource.
     * @param Product $product
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Product $product ,Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'ean' => 'required|integer|digits_between:8,14',
            'branch' => 'required',
            'price' => 'required|integer'
        ]);

        //$userId = array('user_id' => auth()->id());
        //$attributes = array_merge($attributes, $userId);

        $product->name = $request->get('name');
        $product->user_id = auth()->id();
        $product->ean = $request->get('ean');
        $product->branch = $request->get('branch');
        $product->price = $request->get('price');
        $product->save();

        //Redirect
        return redirect()->route('admin.products.index')
            ->with('status', 'Tu producto ha sido guardado');
    }


    /**
     * @param Product $product
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }
}
