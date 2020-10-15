<?php

namespace App\Http\Controllers\Shopping;

use App\Order;
use App\User;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Access\AuthorizationException;


class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth',
            'role:Buyer'
        ]);
    }

    /**
     * Save items and order in the table
     * @param string $userId
     * @param Order $order
     * @return void
     */
    public function saveOrderItems(string $userId, Order $order): void
    {
        $cartItems = \Cart::session($userId)->getContent();

        foreach($cartItems as $item) {
            $order->items()->attach($item->id, [
                'price' => $item->price,
                'quantity' => $item->quantity
            ]);
        }
    }

    /**
     * Create buyer order (Checkout).
     * @return RedirectResponse|View
     */
    public function create()
    {
        $userId = auth()->id();

        if (\Cart::session($userId)->getContent()->count() == 0)
        {
            return redirect()->route('home');
        }

        return view('order.create');
    }

    /**
     * Display a listing of the resource.
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function index(User $user): View
    {

        $this->authorize('view', $user);

        $orders = $user->orders;

        return view('order.index', compact('orders'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return RedirectResponse
     */
    public function store(OrderRequest $request)
    {
        $userId = auth()->id();

        $order = new Order();

        $order->order_reference = time() . '-' . $userId;

        $order->user_id = $userId;
        $order->grand_total = \Cart::session($userId)->getTotal();
        $order->item_count = \Cart::session($userId)->getContent()->count();

        $order->payer_name = $request->get('payer_name');
        $order->payer_email = $request->get('payer_email');
        $order->document_type = $request->get('payer_documentType');
        $order->document_number = $request->get('payer_document');
        $order->payer_phone = $request->get('payer_phone');
        $order->payer_address = $request->get('payer_address');
        $order->payer_city = $request->get('payer_city');
        $order->payer_state = $request->get('payer_state');
        $order->payer_postal = $request->get('payer_postal');

        $order->save();

        $this->saveOrderItems($userId, $order);

        \Cart::session($userId)->clear();

        return redirect()->route('orders.show', $order);
    }

    /**
     * @param Order $order
     * @return View
     * @throws AuthorizationException
     */
    public function show(Order $order): View
    {

        $this->authorize('view', $order);

        $items = $order->items()->get();

        return view('order.show', compact('items','order'));
    }

    /**
     * Show the form for editing the Order.
     *
     * @param Order $order
     * @throws AuthorizationException
     */
    public function edit(Order $order)
    {
        $this->authorize('edit', $order);

        $items = $order->items()->get();

        return view('order.edit', compact( 'items' ,'order' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(OrderRequest $request, Order $order): RedirectResponse
    {
        $order->payer_name = $request->get('payer_name');
        $order->payer_email = $request->get('payer_email');
        $order->document_type = $request->get('payer_documentType');
        $order->document_number = $request->get('payer_document');
        $order->payer_phone = $request->get('payer_phone');
        $order->payer_address = $request->get('payer_address');
        $order->payer_city = $request->get('payer_city');
        $order->payer_state = $request->get('payer_state');
        $order->payer_postal = $request->get('payer_postal');

        $order->save();

        return redirect()->route('orders.index', $order->user_id)
            ->with('status', 'Tu orden a sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Order $order): RedirectResponse
    {
        $this->authorize('delete', $order);

        $order->delete();

        return redirect()->route('orders.index', $order->user_id)
            ->with('status', 'Tu orden a sido eliminada');
    }
}
