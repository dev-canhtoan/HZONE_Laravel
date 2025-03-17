<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>H-Zone</title>
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('icon-font/css/all.min.css') }}">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.reuse.alertPopup')
    @include('layouts.reuse.adminHeader')
    <div class="layout3">
        @include('layouts.reuse.navMenu')
        @yield('content')
    </div>
    
</body>
<script src="/jquery.js"></script>

</html>