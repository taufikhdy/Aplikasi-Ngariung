<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="scroll-restoration" content="manual">

    <title>@yield('title') - RT</title>

    {{-- CSS EKSTERNAL --}}



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">

    {{-- CSS INTERNAL --}}
    <link rel="stylesheet" href="{{ asset('styles/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/components.css?v=10') }}">
    <link rel="stylesheet" href="{{ asset('styles/main.css?v=13') }}">
    <link rel="stylesheet" href="{{ asset('styles/dataList.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/form.css?V=6') }}">
    <link rel="stylesheet" href="{{ asset('styles/kas_iuran.css?v=4')}}">
    <link rel="stylesheet" href="{{ asset('styles/card.css?v=3') }}">
    <link rel="stylesheet" href="{{ asset('styles/berita.css?=3+') }}">
    <link rel="stylesheet" href="{{ asset('styles/surat.css')}}">
    <link rel="stylesheet" href="{{ asset('styles/messages.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/table.css') }}">

    <link rel="stylesheet" href="{{ asset('remixicon/fonts/remixicon.css') }}">

</head>

<body>
    @include('components.rtSidebar')
    @include('components.navbar')

    <main>
        @yield('content')
    </main>


    {{-- IMPOR JS DARI PUBLIC --}}
    <script src="{{ asset('js/script.js?v=7') }}"></script>
    <script src="{{ asset('js/message.js') }}"></script>
</body>

</html>
