<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('assets/images/LogoZhongli.ico') }}">

    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    @yield('content')
</body>
</html>
