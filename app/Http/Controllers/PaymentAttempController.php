<?php

namespace App\Http\Controllers;

use App\Classes\P2PRequest;
use App\Order;
use App\PaymentAttemp;
use Dnetix\Redirection\Exceptions\PlacetoPayException;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentAttempController extends Controller
{
    /**
     * @param Order $order
     * @param PlacetoPay $placetoPay
     * @throws PlacetoPayException
     */
    public function store(Order $order, PlacetoPay $placetoPay): RedirectResponse
    {
        //$this->authorize('pay', $order);

        $requestUser = new P2PRequest($order);

        $response = $placetoPay->request($requestUser->create());

        $paymentAttemp = new PaymentAttemp();
        $paymentAttemp->order_id = $order->id;
        $paymentAttemp->user_id = $order->user_id;
        $paymentAttemp->status = $response->status()->status();
        $paymentAttemp->reason = $response->status()->reason();
        $paymentAttemp->message = $response->status()->message();
        $paymentAttemp->grand_total = $order->grand_total;
        $paymentAttemp->requestID = $response->requestId();
        $paymentAttemp->processUrl = $response->processUrl();
        $paymentAttemp->save();

        return redirect()->away($response->processUrl());
    }
}
