<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
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
        ]);
    }

    /**
     * Add a product to the Customer Cart
     * @param Product $product
     * @throws \Exception
     */
    public function add(Product $product)
    {
        \Cart::session(auth()->id())->add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => Product::class
        ));

        return redirect()->route('cart.index');
    }

    /**
     * Show the cart products
     */
    public function index()
    {

        $cartProducts = \Cart::session(auth()->id())->getContent();

        return view('cart.index', compact('cartProducts'));
    }

    /**
     * Delete the specific cart product
     */
    public function destroy($productId)
    {

        \Cart::session(auth()->id())->remove($productId);

        return back();
    }
}
