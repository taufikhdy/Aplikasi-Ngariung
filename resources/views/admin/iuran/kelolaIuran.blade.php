@extends('layouts.rt')

@section('title', 'Kelola Kas')

@section('content')

    <div class="bg">

        <div class="back">
            {{-- <a href="{{ url()->previous() }}"> --}}
            <a href="{{ route('admin.kasiuran') }}">
                <h4 class="text-white"><i class="ri-arrow-left-long-line small-icon"></i>Kelola Iuran</h4>
            </a>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ri-wallet-3-line card-icon"></i>
                        <h6>{{ $kategori->nama_iuran }}</h6>
                    </div>
                </div>

                <div class="card-info">
                    <p class="cp">Dibuat pada tanggal : {{ $kategori->created_at->format('d M Y') }}</p>
                    <h3>{{ 'Rp. ' . number_format($kategori->jumlah, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="card-menu">
                <div class="card-nav">
                    <a href="" class="link-a-disable text-small text-center">Detail</a>
                </div>
            </div>
        </div>

    </div>

    <div class="data-list">

        <div class="data">
            <div class="data-caption">
                <p class="cp">Data Warga</p>
            </div>

            {{-- search-box --}}
            <div class="search-box">
                <form action="" method="post">
                    <input type="text" name="" id="" placeholder="Cari Warga">
                </form>
            </div>

            <div class="row">

                @if ($transaksi->isEmpty())
                    <p class="cp-gray text-center">Belum ada data transaksi.</p>
                @else
                    @foreach ($transaksi as $iuran)
                        <div class="item">
                            @if ($iuran->status === 'terkonfirmasi')
                                <p class="text-regular">{{ $iuran->warga->nama }}</p>

                                <div class="card-status-success">
                                    <p>Status : {{ $iuran->status }}</p>
                                </div>

                                <a href="#popup-{{ $iuran->id }}" class="text-small">Lihat bukti</a>

                                <div id="popup-{{ $iuran->id }}" class="popup-overlay">
                                    <a href="#" class="popup-content">
                                        <img src="{{ asset('storage/' . $iuran->bukti_bayar) }}" alt="bukti bayar">
                                    </a>
                                </div>
                            @else
                                 <p class="text-regular">{{ $iuran->warga->nama }}</p>

                                <div class="card-status-warning">
                                    <p>Status : {{ $iuran->status }}</p>
                                </div>

                                <a href="#popup-{{ $iuran->id }}" class="text-small">Lihat bukti</a>

                                <div id="popup-{{ $iuran->id }}" class="popup-overlay">
                                    <a href="#" class="popup-content">
                                        <img src="{{ asset('storage/' . $iuran->bukti_bayar) }}" alt="bukti bayar">
                                    </a>
                                </div>

                                <form action="{{ route('admin.konfirmasiIuran', $iuran->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="link-a-secondary text-small text-center">Konfirmasi</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

@endsection
