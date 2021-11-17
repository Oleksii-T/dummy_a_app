<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TradingSim | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api_token" content="{{isset($currentUser) ? $currentUser->api_token : null}}">
    @include('admin.layouts.inc.styles')
    @stack('head')
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        @include('admin.layouts.inc.header')
        @include('admin.layouts.inc.sidebar')

        @yield('content')

        <!-- Main Footer -->
            <footer>
            </footer>
    </div>
    @include('admin.layouts.inc.scripts')
    @stack('js')
</body>
</html>
