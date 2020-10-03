<?php

namespace App\Http\Controllers\Shopping;

use App\Classes\P2PRequest;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\User;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     */
    public function store(OrderRequest $request)
    {
        $userId = auth()->id();

        $order = new Order();

        $order->order_reference = Str::uuid(2);

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

        return redirect()->route('order.show', compact('order'));

        /**


        //Process pay with PlaceToPay
        $reference = 'TEST_' . time();

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
            "expiration" => date('c', strtotime('+2 hour')),
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
                'rest' => [
                    'timeout' => 45, // (optional) 15 by default
                    'connect_timeout' => 30, // (optional) 5 by default
                    ]
            ]);

            $response = $placetopay->request($request);

            dd($response);

            if ($response->isSuccessful()) {
                // Redirect the client to the processUrl or display it on the JS extension
                //$response->processUrl();
            } else {
                // There was some error so check the message
                //$response->status()->message();
            }

            dd($response);

        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

         **/

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
}
