<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
            'role:Buyer'
        ]);
    }

    /**
     * Add a product to the Customer Cart
     * @param Product $product
     * @return RedirectResponse
     */
    public function add(Product $product): RedirectResponse
    {

        $userId = auth()->id();

        $id = $product->id;
        $name = $product->name;
        $price = $product->price;
        $qty = request('quantity') ? request('quantity') : $_REQUEST['quantity'];

        \Cart::session($userId)->add($id, $name, $price, $qty);

        return redirect()->route('cart.index')
            ->with('status', 'El producto ha sido agregado a tu carrito');
    }

    /**
     * Show the Cart Products
     * @return View
     */
    public function index(): View
    {
        $userId = auth()->id();

        $cartProducts = \Cart::session($userId)->getContent();

        return view('cart.index', compact('cartProducts'));
    }

    /**
     * Delete the specific cart product
     * @param $productId
     * @return RedirectResponse
     */
    public function delete($productId): RedirectResponse
    {
        $userId = auth()->id();

        \Cart::session($userId)->remove($productId);

        return back()->with('status', 'El producto ha sido eliminado de tu carrito');

    }

    /**
     * @param $productId
     * @return RedirectResponse
     */
    public function update($productId): RedirectResponse
    {

        $userId = auth()->id();

        \Cart::session($userId)->update($productId, array(
            'quantity' => array(
                'relative' => false,
                'value' => request('quantity')
            ),
        ));

        return back()->with('status', 'El producto ha sido actualizado en tu carrito');
    }

    /**
     *
     */
    public function checkout()
    {
        $userId = auth()->id();

        $cartCount = \Cart::session($userId)->getContent()->count();

        if($cartCount == 0) {
            return redirect(route('home'));
        }

        return view('cart.checkout');
    }
}
