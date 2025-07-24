@extends('layouts.rt')

@section('title', 'Detail Surat Pengajuan')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <h6>Ajukan Surat</h6>
            <p>Login ke akun anda</p>
        </div>

            <div class="input-group">

                <div class="input-box">
                    <label for="nama">Nama</label>
                    <input type="text" name="name" id="nama" placeholder="Nama" autocomplete="off">
                </div>

                <div class="input-box">
                    <label for="nik">NIK</label>
                    <input type="number" name="nik" id="nik" placeholder="Nomor Induk Kependudukan"
                        autocomplete="off">
                </div>

                <div class="input-box"> <label for="password">Kata Sandi</label>
                    <input type="password" name="password" id="password" placeholder="Kata Sandi" autocomplete="off">
                </div>

                <a href="{{route('warga.surat')}}" class="text-small link-a-active text-center">Kembali</a>
            </div>

    </div>

@endsection
