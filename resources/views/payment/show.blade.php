@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Resultado de la transacción</span></h2>
    </section>
    <section class="main-content">
        <div class="row">
            <div class="col-12 center">
                @if($order->status == PaymentStatus::APPROVED)
                    <h5>@lang('orders.payment.approved')</h5>
                @elseif($order->status == PaymentStatus::PENDING)
                    <h5>@lang('orders.payment.pending')</h5>
                @else
                    <h5>@lang('orders.payment.rejected')</h5>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-4 offset-4">
                <p class="mt-3">
                    <strong>@lang('orders.state')</strong>: {{ __($order->status) }}<br>
                    <strong>@lang('orders.reason')</strong>: {{ $order->message }}<br>
                    <strong>@lang('orders.transaction_number')</strong>: {{ $paymentAttempt->requestID }}<br>
                    <strong>@lang('orders.total')</strong>: $ {{ $order->grand_total }} COP<br>
                </p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 center">
                <form action="{{ route('payments.store', $order) }}">
                    <a class="mr-3" href="{{ route('orders.index', $order->user_id) }}">@lang('orders.back')</a>
                    @if($order->status == PaymentStatus::REJECTED)
                        <button>@lang('orders.pay_retry')</button>
                    @endif
                </form>
            </div>
        </div>
    </section>
@endsection
