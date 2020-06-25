@extends('layouts.layout')

@section('content')
    Bienvenido a tu <strong> CUENTA </strong>
        @guest()
            <strong>Invitado</strong>
        @else
            <strong>{{ auth()->user()->name }}</strong>

        @endguest
    a la mejor tienda.
@endsection
