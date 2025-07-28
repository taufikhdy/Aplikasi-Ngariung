@extends('layouts.rt')

@section('title', 'Detail Kas')

@section('content')

    <div class="bg">
        <div class="back">
            <a href="{{route('admin.kasiuran')}}">
                <h4 class="text-white"><i class="ri-arrow-left-long-line small-icon"></i>Detail Kas</h4>
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
                    <p class="cp">Dibuat pada : {{ $kas->created_at->format('d M Y') }}</p>
                    <h3>Saldo : {{ 'Rp. ' . number_format($kas->saldo, 0, ',', '.') }}</h3>
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


    <div class="transaksi">
        <div class="transaksi-header">
            <h6><i class="ri-wallet-3-line title-icon"></i> Saldo {{ $kas->updated_at->format('d M Y') }}</h6>
            {{-- <a href="{{ route('admin.riwayat-bayar') }}" class="text-small">lihat riwayat pembayaran</a> --}}
        </div>

        <div class="transaksi-detail">
            <p class="text-small">Detail Saldo </p>
            <div class="rincian-transaksi">
                <div class="saldo-masuk">
                    <p class="cp">Saldo masuk</p>
                    <p class="cp masuk">{{ '+ Rp. ' . number_format($total_masuk, 0, ',', '.') }}</p>
                </div>
                <div class="saldo-keluar">
                    <p class="cp">Saldo keluar</p>
                    <p class="cp keluar">{{ '- Rp. ' . number_format($total_keluar, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="rincian-menu">
                <a href="{{ route('admin.pengeluaranKas', ['id' => $kas->id]) }}" class="link-a-error-full text-center cp">Lihat Transaksi Kas</a>
            </div>
            <p class="box-a-disable text-small">
                Saldo Akhir {{ 'Rp. ' . number_format($saldo_akhir, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="navigasi">
        <a href="{{ route('admin.kelolaKas', ['id' => $kas->id]) }}"
            class="link-a-active big text-center text-small tombol">Kelola Kas</a>
    </div>

@endsection
