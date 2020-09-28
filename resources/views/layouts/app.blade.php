<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <!-- bootstrap -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">


    <!-- global styles -->
    <link href="/shooper/themes/css/main.css" rel="stylesheet"/>

    <!-- scripts -->
    <script src="/js/app.js" defer></script>

    <!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    @stack('styles')
</head>

<body>

@include('layouts.header')

<!-- Content -->
@yield('content')


@include('layouts.footer')
