<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="//fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ url('/css/app.css') }}">
    <title>@yield('title', env('APP_NAME'))</title>
  </head>
  <div class="root" id="app">
    @yield('content')
  </div>
  <script src="{{ url('/js/app.js') }}" charset="utf-8"></script>
</html>
