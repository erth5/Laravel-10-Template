<!DOCTYPE html>
<html lang="en">

{{-- The head of an HTML document is the part
    that is not displayed in the web browser when the page is loaded. --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Debug: {{ url()->current() }}</title>
</head>

<body>

    <x-debug.sessionStatus />
    <x-debug.style />
    <div style="float: left">
        <x-debug.menu />
    </div>
    <div style="margin: auto">
        <x-debug.env />
    </div>
    <div style="float: right">
        @yield('c')
    </div>

</body>

</html>
