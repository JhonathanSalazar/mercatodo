<?php

namespace App\Http\Controllers\Shopping;

use App\Classes\PaymentStatus;
use Carbon\Carbon;
use App\Entities\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Classes\P2PRequest;
use App\Entities\PaymentAttempt;
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

        Log::info('paymentAttempt.store', ['user' => auth()->user(), 'order' => $order->id]);


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

        Log::info('paymentAttempt.show', ['user' => auth()->user(), 'order' => $order->id]);

        return view('payment.show', compact('order', 'paymentAttempt'));
    }
}
