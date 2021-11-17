<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api_token" content="{{isset($currentUser) ? $currentUser->api_token : null}}">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('meta')
    @if (isset($page) && $page)
        <meta name="title" content="{{$page->seo_title}}">
        <meta name="og:title" content="{{$page->seo_title}}">
        <meta name="description" content="{{$page->seo_description}}">  
        <meta name="og:description" content="{{$page->seo_description}}">  
    @else
        <title>APPLICATION</title>
    @endif
    @include('website.layouts.inc.styles')
    @stack('css')
</head>
<body class="{{$body_class ?? ''}}">

@yield('header')

@yield('content')

@include('website.layouts.inc.scripts')
@stack('js')

</body>
</html>





