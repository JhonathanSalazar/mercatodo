@extends('layouts.app')

@section('content')
    <section class="center container">
        <img class="pageBanner" src="/shooper/themes/images/pageBanner.png" alt="New products">
        <h2 class="py-3"><span>Todas tu ordenes</span></h2>
    </section>

    <section class="container">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Id de la orden</th>
                    <th># de Productos</th>
                    <th>Valor Total</th>
                    <th>Estado de pago</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td><a href="{{ route('orders.show', $order) }}">{{ $order->id }}</a></td>
                    <td>{{ $order->item_count }}</td>
                    <td>{{ $order->grand_total }}</td>
                    <td>{{ __($order->status) }}</td>
                    <td>
                        @if($order->status == null || $order->status == \App\Classes\PaymentStatus::REJECTED)
                            <form action="{{ route('orders.delete', $order) }}" method="POST">
                                @csrf @method('DELETE')
                                <button>Eliminar</button>
                            </form>
                        @endif
                    </td>
            @empty
                Aún no tienes ordenes, sigue comprando
            @endforelse

            <tbody>
        </table>
    </section>
@endsection

