<?php

namespace App\Http\Controllers\Shopping;

use App\Classes\P2PRequest;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\User;
use Dnetix\Redirection\Exceptions\PlacetoPayException;
use Dnetix\Redirection\PlacetoPay;
use http\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
     * Create buyer order.
     */
    public function create()
    {
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

        return redirect()->route('order.show', $order);
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

        return view('order.confirm', compact('items','order'));
    }

    /**
     * Show the form for editing the Order.
     *
     * @param Order $order
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Order $order): View
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
     * @return Response
     */
    public function update(OrderRequest $request, Order $order)
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

        return redirect()->route('order.index', $order->user_id)
            ->with('status', 'Tu orden a sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        return redirect()->route('order.index', $order->user_id)
            ->with('status', 'Tu orden a sido eliminada');
    }

    /**
     * @param Order $order
     * @param PlacetoPay $placetopay
     * @return Redirector
     * @throws AuthorizationException
     * @throws PlacetoPayException
     */
    public function pay(Order $order, PlacetoPay $placetopay)
    {
        $this->authorize('pay', $order);

        $requestUser = new P2PRequest($order);

        $response = $placetopay->request($requestUser->create());

        $order->update([
            'processUrl' => $response->processUrl(),
            'requestID' => $response->requestId(),
            'status' => $response->status()->status(),
        ]);

        dd($order);

        return redirect()->away($response->processUrl());
    }
}
