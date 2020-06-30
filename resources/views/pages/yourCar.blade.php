@extends('layouts.app')

@section('content')
    Bienvenido a tu <strong> CARRITO </strong>
    @guest()
        <strong>Invitado</strong>
    @else
        <strong>{{ auth()->user()->name }}</strong>

    @endguest
    de la mejor tienda.
@endsection
