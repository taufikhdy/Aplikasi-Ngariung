<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- CSS EKSTERNAL --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">

    {{-- CSS INTERNAL --}}
    <link rel="stylesheet" href="styles/animation.css">
    <link rel="stylesheet" href="styles/messages.css">
    <link rel="stylesheet" href="styles/login.css?v4+">


    <title>Aplikasi Manajemen Warga RT</title>
</head>

<body>
    @guest

        <div class="logo">
            <img src="{{ asset('logo/parahyangan flat.png') }}" alt="logo">
        </div>

        <div class="form-box">
            <div class="form-header">
                <h3>Masuk</h3>
                <p>Login ke akun anda</p>
            </div>

            <form action="{{ route('authenticate') }}" method="post">
                @csrf
                <div class="input-group">

                    <div class="input-box">
                        <label for="nik">NIK</label>
                        <input type="number" name="nik" id="nik" placeholder="Nomor Induk Kependudukan"
                            autocomplete="off" value="{{old('nik')}}">
                        @if(session('nik'))
                            <p class="message-error cp">{{ session('nik') }}</p>
                        @endif
                    </div>

                    <div class="input-box"> <label for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="Kata Sandi" autocomplete="off">
                        @if(session('password'))
                            <p class="message-error cp">{{ session('password') }}</p>
                        @endif
                    </div>

                </div>
                <input type="submit" name="" id="" value="Masuk">

                <p class="helper text-small">Lupa kata sandi anda? <a href="#">Reset kata sandi</a></p>
            </form>
        </div>
    @endguest
</body>

</html>
