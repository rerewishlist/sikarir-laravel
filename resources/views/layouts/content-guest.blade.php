<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', 'Title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    @include('layouts.partial-guest.link')
</head>

<body class="service-details-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        @include('layouts.partial-guest.header')

        @yield('content-guest')

        @if (!isset($hideFooter) || !$hideFooter)
            @include('layouts.partial-guest.footer')
        @endif

        <!-- Scroll Top -->
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Preloader -->
        <div id="preloader"></div>

        @include('layouts.partial-guest.script')
</body>

</html>
