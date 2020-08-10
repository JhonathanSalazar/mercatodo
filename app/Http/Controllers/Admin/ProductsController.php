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
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProductRequest;
use Intervention\Image\Facades\Image;

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
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
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
     * @param UpdateProductRequest $request
     * @return RedirectResponse
     */
    public function update(Product $product ,UpdateProductRequest $request): RedirectResponse
    {

        $product->name = $request->get('name');
        $product->user_id = auth()->id();
        $product->ean = $request->get('ean');
        $product->branch = $request->get('branch');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->category_id = $request->get('category');
        $product->published_at = Carbon::parse($request->get('published_at'));

        if($request->file('image'))
        {
            if($product->image) {
                Storage::delete($product->image);
            }

            $product->image = $request->file('image')->store('images');
            $img = Image::make(Storage::get($product->image))
                ->heighten(250)
                ->limitColors(255)
                ->encode();

            Storage::put($product->image, (string) $img);
        }

        $product->save();
        $product->tags()->sync($request->get('tags'));

        return redirect()->route('admin.products.index')
            ->with('status', 'Tu producto ha sido guardado');
    }

    /**
     *  Show the edit form of the specified resource.
     * @param Product $product
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     *  Delete the resource and their relations.
     * @param Product $product
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product): RedirectResponse
    {

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Tu producto ha sido eliminado');
    }
}
