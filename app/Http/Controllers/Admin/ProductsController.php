<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Entities\Tag;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Validation\ValidationException;

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
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('index', Product::class);

        $products = Product::paginate();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function show(Product $product): View
    {
        $this->authorize('view', $product);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Store the specified resource.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $attributes = $this->validate($request, ['name' => 'required']);

        $userId = array('user_id' => auth()->id());
        $attributes = array_merge($attributes, $userId);

        $product = Product::create($attributes);

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Store the specified resource.
     *
     * @param Product $product
     * @param UpdateProductRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Product $product, UpdateProductRequest $request): RedirectResponse
    {
        $this->authorize('update', $product);

        $product->name = $request->get('name');
        $product->user_id = auth()->id();
        $product->ean = $request->get('ean');
        $product->branch = $request->get('branch');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->category_id = $request->get('category');
        $product->published_at = Carbon::parse($request->get('published_at'));

        if ($request->file('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }

            $product->image = $request->file('image')->store('images');
            $img = Image::make(Storage::get($product->image))
                ->heighten(250)
                ->limitColors(255)
                ->encode();

            Storage::put($product->image, (string)$img);
        }

        $product->save();
        $product->tags()->sync($request->get('tags'));

        return redirect()->route('admin.products.index')
            ->with('status', 'Tu producto ha sido guardado');
    }

    /**
     *  Show the edit form of the specified resource.
     *
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Product $product): View
    {
        $this->authorize('edit', $product);

        // Tomarlo desde Cache
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     *  Delete the resource and their relations.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('destroy', $product);

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Tu producto ha sido eliminado');
    }
}
