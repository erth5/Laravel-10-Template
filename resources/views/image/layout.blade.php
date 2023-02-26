<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Route::current()->getName() }}</title>
</head>

<body>

    <x-debug.sessionStatus />
    <x-debug.style />
    <div style="float: left">
        <x-image.menu />
    </div>
    <div style="margin: auto">

        @yield('image_views')
    </div>


</body>

</html>
