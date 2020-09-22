<?php

namespace App\Http\Controllers;

use App\Classes\P2PRequest;
use App\Http\Requests\OrderRequest;
use App\Order;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {

        $userId = auth()->id();

        $order = new Order();

        $order->order_reference = Str::uuid();

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

        return redirect()->route('order.confirm', compact('order'));
        //Process pay with PlaceToPay
/*        $reference = 'TEST_' . time();

        $request = [
            "locale" => "es_CO",
            "payer" => [
                "name" => "Kellie Gerhold",
                "surname" => "Kellie Gerhold",
                "email" => "flowe@anderson.com",
                "documentType" => "CC",
                "document" => "1848839248",
                "mobile" => "3006108300",
                "address" => [
                    "street" => "703 Dicki Island Apt. 609",
                    "city" => "North Randallstad",
                    "state" => "Antioquia",
                    "postalCode" => "46292",
                    "country" => "US",
                    "phone" => "363-547-1441 x383"
                ]
            ],
            "payment" => [
                "reference" => $reference,
                "description" => "Iusto sit et voluptatem.",
                "amount" => [
                    "taxes" => [
                        [
                            "kind" => "ice",
                            "amount" => 56.4,
                            "base" => 470
                        ],
                        [
                            "kind" => "valueAddedTax",
                            "amount" => 89.3,
                            "base" => 470
                        ]
                    ],
                    "details" => [
                        [
                            "kind" => "shipping",
                            "amount" => 47
                        ],
                        [
                            "kind" => "tip",
                            "amount" => 47
                        ],
                        [
                            "kind" => "subtotal",
                            "amount" => 940
                        ]
                    ],
                    "currency" => "USD",
                    "total" => 1076.3
                ],
                "items" => [
                    [
                        "sku" => 26443,
                        "name" => "Qui voluptatem excepturi.",
                        "category" => "physical",
                        "qty" => 1,
                        "price" => 940,
                        "tax" => 89.3
                    ]
                ],
                "shipping" => [
                    "name" => "Kellie Gerhold",
                    "surname" => "Yost",
                    "email" => "flowe@anderson.com",
                    "documentType" => "CC",
                    "document" => "1848839248",
                    "mobile" => "3006108300",
                    "address" => [
                        "street" => "703 Dicki Island Apt. 609",
                        "city" => "North Randallstad",
                        "state" => "Antioquia",
                        "postalCode" => "46292",
                        "country" => "US",
                        "phone" => "363-547-1441 x383"
                    ]
                ],
                "allowPartial" => false
            ],
            "expiration" => date('c', strtotime('+1 hour')),
            "ipAddress" => "127.0.0.1",
            "userAgent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
            "returnUrl" => "http://mercatodo.test/",
            "cancelUrl" => "http://mercatodo.test/",
            "skipResult" => false,
            "noBuyerFill" => false,
            "captureAddress" => false,
            "paymentMethod" => null
        ];

        try {
            $placetopay = new PlacetoPay([
                'login' => config('placetopay.login'),
                'tranKey' => config('placetopay.trankey'),
                'url' => config('placetopay.url'),
                'type' => config('placetopay.type'),
            ]);

            $response = $placetopay->request($request);

            if ($response->isSuccessful()) {
                // Redirect the client to the processUrl or display it on the JS extension
                $response->processUrl();
            } else {
                // There was some error so check the message
                $response->status()->message();
            }
            dd($response);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }*/

    }

    /**
     * @param Order $order
     * @return View
     */
    public function confirm(Order $order): View
    {
        $items = $order->items()->get();

        return view('orders.confirm', compact('items','order'));
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
