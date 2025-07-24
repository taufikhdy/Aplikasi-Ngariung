@extends('layouts.warga')

@section('title', 'Detail Kas')

@section('content')

    <div class="bg">

        <div class="back">
            <a href="{{ url()->previous() }}">
                <h4 class="text-white"><i class="ri-arrow-left-long-line small-icon"></i>Kelola Iuran</h4>
            </a>
        </div>

        <div class="detail-kas">

            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-wallet-3-line card-icon"></i>
                            <h6>{{ $kas->nama_kas }}</h6>
                        </div>
                    </div>

                    <div class="card-info">
                        <p class="cp">Dibuat pada : {{ $kas->created_at->format('d M Y') }}</p>
                        <h3>Saldo : {{ 'Rp. ' . number_format($kas->saldo, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="kas-text">
        <h6><i class="ri-wallet-3-line title-icon"></i> {{ $kas->nama_kas }}</h6>

        <p class="text-small">
            {{ $kas->deskripsi_kas }}
        </p>
    </div>


    <div class="pemasukan">
        <div class="pemasukan-header">
            <h6><i class="ri-wallet-3-line title-icon"></i> Pemasukan</h6>
            <a href="{{ route('admin.riwayat-bayar') }}" class="text-small">lihat riwayat pembayaran</a>
        </div>

        <div class="detail-pemasukan">
            <p class="text-small">Pemasukan Bulan Juni</p>
            <div class="rincian">
                <div class="saldo-masuk">
                    <p class="cp">Saldo masuk</p>
                    <p class="cp masuk">+Rp. 6.000.000</p>
                </div>
                <div class="saldo-keluar">
                    <p class="cp">Saldo keluar</p>
                    <p class="cp keluar">-Rp. 6.000.000</p>
                </div>
            </div>
            <div class="rincian-menu">
                <a href="{{ route('warga.pengeluaranKas', ['id' => 1]) }}" class="link-a-error cp">Lihat Data
                    Pengeluaran</a>

                <p class="box-a-disable text-small">
                    Total Saldo Akhir <br>
                    Rp. 10.000
                </p>
            </div>
        </div>
    </div>

    {{-- <div class="navigasi">
            <a href="{{route('admin.kelolaKas', ['id' => $kas->id])}}" class="link-a-active big text-center text-small tombol">Kelola Kas</a>
        </div> --}}

@endsection
