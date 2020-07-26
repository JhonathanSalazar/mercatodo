<?php

namespace App\Http\Controllers\Admin;


use App\Tag;
use App\Product;
use App\Category;
use Carbon\Carbon;
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
            'description' => 'required',
            'ean' => 'required|integer|digits_between:8,14',
            'branch' => 'required',
            'price' => 'required|integer',
            'image' => [
                'required',
                'mimes:jpeg,png',
            ]
        ]);

        //$userId = array('user_id' => auth()->id());
        //$attributes = array_merge($attributes, $userId);

        $product->name = $request->get('name');
        $product->user_id = auth()->id();
        $product->ean = $request->get('ean');
        $product->branch = $request->get('branch');
        $product->price = $request->get('price');
        $product->image = $request->file('image')->store('images');
        $product->description = $request->get('description');
        $product->category_id = $request->get('category');
        $product->published_at = Carbon::parse($request->get('published_at'));
        $product->save();
        $product->tags()->sync($request->get('tags'));

        //Redirect
        return redirect()->route('admin.products.index')
            ->with('status', 'Tu producto ha sido guardado');
    }


    /**
     * @param Product $product
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }
}
