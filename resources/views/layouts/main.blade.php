<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', 'Title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    @include('layouts.partial.link')
</head>

<body>
    @include('layouts.partial.header')

    @include('layouts.partial.sidebar')

    @yield('content')

    @if (!isset($hideFooter) || !$hideFooter)
        @include('layouts.partial.footer')
    @endif

    @include('layouts.partial.script')

</body>

</html>
