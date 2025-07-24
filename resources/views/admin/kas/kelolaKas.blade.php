@extends('layouts.rt')

@section('title', 'Kelola Kas')

@section('content')

    <div class="bg">

        <div class="back">
            <a href="{{ url()->previous() }}">
                <h4 class="text-white"><i class="ri-arrow-left-long-line regular-icon"></i>Kelola Iuran</h4>
            </a>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ri-wallet-3-line card-icon"></i>
                        <h6>{{ $kas->nama_kas }}</h6>
                    </div>
                </div>

                <div class="card-info">
                    <p class="cp">diperbarui pada : {{ $kas->created_at->format('d M Y') }}</p>
                    <h3>Saldo : {{ 'Rp. ' . number_format($kas->saldo, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="card-menu">
                <div class="card-nav">
                    <a href="{{ route('admin.detailkas', ['id' => $kas->id]) }}"
                        class="link-a-disable text-small text-center">Detail</a>
                </div>
            </div>
        </div>

    </div>

    <div class="tambah-kas">

        <div class="tambah-kas-header">
            <h6 class="text-left">Tambah Transaksi</h6>
        </div>

        <form action="{{ route('admin.tambahTransaksiKas') }}" method="post">
            @csrf
            <div class="form">

                <input type="hidden" name="kas_id" id="" value="{{ $kas->id }}">
                <div class="input-tambah-flex">
                    <div class="input-tambah">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" placeholder="Tanggal">
                    </div>

                    <div class="input-tambah">
                        <label for="jenis">Jenis</label>
                        <select name="jenis" id="jenis">
                            <option value="masuk">Pemasukan</option>
                            <option value="keluar">Pengeluaran</option>
                        </select>
                    </div>

                </div>

                <div class="input-tambah">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" placeholder="Jumlah">
                </div>

                <div class="input-tambah">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="5" cols="20">keterangan...</textarea>
                </div>

            </div>

            <input type="submit" name="" id="" placeholder="Tambah Kas" class="text-small"
                value="Tambah Transaksi">

        </form>
        {{-- <a href="{{ route('admin.kasiuran') }}" class="link-a-error big text-small text-center">Batal</a> --}}
    </div>

@endsection
