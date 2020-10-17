<?php

namespace App\Http\Controllers\Shopping;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\View\View;
use App\Models\PaymentAttempt;
use App\Classes\P2PRequest;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Dnetix\Redirection\Exceptions\PlacetoPayException;

class PaymentAttemptController extends Controller
{
    /**
     * @param Order $order
     * @param PlacetoPay $placetoPay
     * @return RedirectResponse
     * @throws PlacetoPayException
     */
    public function store(Order $order, PlacetoPay $placetoPay): RedirectResponse
    {
        $requestUser = new P2PRequest($order);

        $response = $placetoPay->request($requestUser->create());

        $paymentAttemp = new PaymentAttempt();
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

        $order->status = $response->status()->status();
        $order->reason = $response->status()->reason();
        $order->message = $response->status()->message();

        if ($response->status()->status() == 'APPROVED') {
            $order->paid_at = Carbon::now();
        }

        $order->update();

        return view('payment.show', compact('order', 'paymentAttempt'));
    }
}
