@extends('layouts.app')

@section('content')
    <section class="center">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Resultado de la transacción</span></h2>
    </section>
    <section class="main-content">
        <div class="row">
            <div class="col-12 center">
                @if($order->status == 'APPROVED')
                    <h5>TU TRANSACCIÓN HA SIDO APROBADA</h5>
                @else
                    <h5>TU TRANSACCIÓN HA SIDO RECHAZADA</h5>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-4 offset-4">
                <p class="mt-3">
                    <strong>Estado</strong>: {{ $order->status }}<br>
                    <strong>Razón</strong>: {{ $order->message }}<br>
                    <strong># Transacción</strong>: {{ $paymentAttempt->requestID }}<br>
                    <strong>Total</strong>: $ {{ $order->grand_total }} COP<br>
                </p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 center">
                <form action="{{ route('payment.store', $order) }}">
                    <a class="mr-3" href="{{ route('order.index', $order->user_id) }}">Regresar</a>
                    @if($order->status != 'APPROVED')
                        <button>Reintentar Pago</button>
                    @endif
                </form>
            </div>
        </div>
    </section>
@endsection
