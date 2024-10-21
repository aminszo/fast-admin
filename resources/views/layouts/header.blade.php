<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{config('app.html_direction', 'ltr')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("/css/fonts.css") }}">
    <link rel="stylesheet" href="{{ asset("/css/base.css") }}">
    <link rel="stylesheet" href="{{ asset("/lib/fontawesome/fontawesome-6.3.0-web/css/all.css") }}">
    <link rel="stylesheet" href="{{ asset("/lib/bootstrap/bootstrap-5.3.0-alpha1/css/bootstrap.rtl.min.css") }}" >
    @yield('custom_css')
    <title>@yield('title', 'page') - {{env('APP_NAME', 'myApp')}}</title>
</head>
<body>
<script src="{{ asset("lib/bootstrap/bootstrap-5.3.0-alpha1/js/bootstrap.bundle.min.js") }}"></script>
