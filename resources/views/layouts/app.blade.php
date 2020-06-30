<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!-- bootstrap -->
    <link rel="stylesheet" href="/css/app.css">

    <!-- global styles -->
    <link href="/shooper/themes/css/flexslider.css" rel="stylesheet"/>
    <link href="/shooper/themes/css/main.css" rel="stylesheet"/>

    <!-- scripts -->
    <script src="/shooper/themes/js/jquery-1.7.2.min.js"></script>
    <script src="/js/app.js" defer></script>
    <script src="/shooper/themes/js/superfish.js"></script>
    <script src="/shooper/themes/js/jquery.scrolltotop.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

@include('layouts.header')

<!-- Content -->
@yield('content')


@include('layouts.footer')
