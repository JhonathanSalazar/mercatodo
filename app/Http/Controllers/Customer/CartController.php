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

        return redirect()->route('cart.index')
            ->with('status', 'Tu producto ha sido agregado');
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
     * @param $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($productId)
    {

        \Cart::session(auth()->id())->remove($productId);

        return back()->with('status', 'Tu producto ha sido eliminado');
    }

    /**
     *
     */
    public function update($productId)
    {

        \Cart::session(auth()->id())->update($productId, array(
            'quantity' => array(
                'relative' => false,
                'value' => request('quantity')
            ),
        ));

        return back();
    }
}
