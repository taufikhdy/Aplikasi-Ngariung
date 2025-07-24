@extends('layouts.warga')

@section('title', 'Surat Pengajuan')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <h6>Ajukan Surat</h6>
            <p>Login ke akun anda</p>
        </div>

        {{-- disini form ubah --}}
        <form action="" method="post">
            @csrf
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

            </div>

            <input type="submit" name="" id="" value="Ajukan Surat" class="text-small">
        </form>
    </div>


    <div class="surat">
        <h6>Riwayat Surat Pengajuan</h6>

        <div class="surat-section">
            <div class="lite-card">

                <div class="header">
                    <p class="text-small link-a-error">Ditolak</p>
                </div>

                <p class="text-small">Surat Pengajuan</p>

                <div class="menu">
                    <p class="cp-gray">07/07/25</p>
                    <a href="{{route('warga.detailSurat')}}" class="text-small">Detail</a>
                </div>
            </div>

            <div class="lite-card">

                <div class="header">
                    <p class="text-small link-a-error">Ditolak</p>
                </div>

                <p class="text-small">Surat Pengajuan</p>

                <div class="menu">
                    <p class="cp-gray">07/07/25</p>
                    <a href="" class="text-small">Detail</a>
                </div>
            </div>
        </div>
    </div>


@endsection
