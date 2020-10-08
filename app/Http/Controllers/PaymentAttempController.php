<?php

namespace App\Http\Controllers;

use App\Classes\P2PRequest;
use App\Order;
use App\PaymentAttemp;
use Carbon\Carbon;
use Dnetix\Redirection\Exceptions\PlacetoPayException;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentAttempController extends Controller
{
    /**
     * @param Order $order
     * @param PlacetoPay $placetoPay
     * @return RedirectResponse
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

    /**
     * @param Order $order
     * @param PlacetoPay $placetoPay
     * @return View
     */
    public function show(Order $order, PlacetoPay $placetoPay)
    {
        $paymentAttempt = $order->paymentAttemps()->latest()->first();

        $response = $placetoPay->query($paymentAttempt->requestID);

        if($response->status()->status() == 'APPROVED') {
            $order->status = $response->status()->status();
            $order->reason = $response->status()->reason();
            $order->message = $response->status()->message();
            $order->paid_at = Carbon::now();
            $order->update();
        } else {
            $order->status = $response->status()->status();
            $order->reason = $response->status()->reason();
            $order->message = $response->status()->message();
            $order->update();
        }

        return view('payment.show', compact('order', 'paymentAttempt'));
    }
}
