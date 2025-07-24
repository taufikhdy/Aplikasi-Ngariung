@extends('layouts.rt')

@section('title', 'Konfirmasi Kas')

@section('content')

    <div class="tambah-kas">

        <div class="tambah-kas-header">
            <h4>Konfirmasi Kas Warga</h4>
        </div>

        <form action="" method="post">
            @csrf
            <div class="form">
                <div class="input-tambah">
                    <label for="nama">Nama Warga</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama Warga">
                </div>

                <div class="input-tambah-flex">
                    <div class="input-tambah">
                        <label for="tanggal-bayar">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" id="tanggal-bayar" placeholder="Tanggal bayar">
                    </div>

                    <div class="input-tambah">
                        <label for="nominal">Nominal Kas</label>
                        <input type="number" name="nominal_kas" id="nominal" placeholder="Nominal Kas">
                    </div>
                </div>

                <div class="input-tambah">
                    <label for="bukti">Bukti Pembayaran Kas</label>
                    <input type="file" name="bukti_kas" id="bukti" placeholder="Bukti Pembayaran Kas">
                </div>
            </div>

            <input type="submit" name="" id="" placeholder="Konfirmasi" class="text-small">

        </form>
        
        <a href="{{route('admin.kasiuran')}}" class="link-a-error big text-small text-center">Batal</a>
    </div>

@endsection
