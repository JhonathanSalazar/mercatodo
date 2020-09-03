<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = auth()->id();

        $request->validate([
            'shipping_name' => 'required',
            'shipping_email' => 'required',
            'shipping_phone' => 'required',
            'shipping_address' => 'required',
            'shipping_city' => 'required',
            'shipping_postal' => 'required',
            'shipping_country' => 'required',
        ]);

        $order = new Order();

        $order->order_number= uniqid('O#');

        $order->user_id = $userId;
        $order->grand_total = \Cart::session($userId)->getTotal();
        $order->item_count = \Cart::session($userId)->getContent()->count();

        $order->shipping_name = $request->get('shipping_name');
        $order->shipping_email = $request->get('shipping_email');
        $order->shipping_phone = $request->get('shipping_phone');
        $order->shipping_address = $request->get('shipping_address');
        $order->shipping_city = $request->get('shipping_city');
        $order->shipping_postal = $request->get('shipping_postal');
        $order->shipping_country = $request->get('shipping_country');

        $order->save();

        //Save order items
        $cartItems = \Cart::session($userId)->getContent();

        foreach($cartItems as $item) {
            $order->items()->attach($item->id, [
                'price' => $item->price,
                'quantity' => $item->quantity
            ]);
        }

        \Cart::session($userId)->clear();

        //send email to customer


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
