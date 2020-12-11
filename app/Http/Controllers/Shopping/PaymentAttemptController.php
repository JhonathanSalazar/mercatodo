<?php

namespace App\Http\Controllers\Shopping;

use App\Classes\P2PRequest;
use App\Constants\PaymentStatus;
use App\Entities\Order;
use App\Entities\PaymentAttempt;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Dnetix\Redirection\Exceptions\PlacetoPayException;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
    public function show(Order $order, PlacetoPay $placetoPay): View
    {
        $paymentAttempt = $order->paymentAttempts()->latest()->first();

        $response = $placetoPay->query($paymentAttempt->requestID);

        $order->status = $response->status()->status();
        $order->reason = $response->status()->reason();
        $order->message = $response->status()->message();

        if ($response->status()->status() == PaymentStatus::APPROVED) {
            $order->paid_at = Carbon::now();
        }

        $order->update();

        return view('payment.show', compact('order', 'paymentAttempt'));
    }
}
