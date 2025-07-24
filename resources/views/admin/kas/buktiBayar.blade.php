@extends('layouts.rt')

@section('title', 'Bukti Pembayaran')

@section('content')

    <div class="bg">

        <div class="detail-kas">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        {{-- <i class="ri-wallet-3-line card-icon"></i> --}}
                        <h6>Kas Bulanan Warga</h6>
                    </div>

                    <div class="card-info">
                        <p class="cp">Berakhir tanggal 31 Juli 2025</p>
                        <h3>Rp. 3.000.000</h3>
                    </div>
                </div>

                <div class="card-menu">
                    <div class="card-status-success">
                        <p class="cp">Sudah Bayar</p>
                        <p class="cp">Total : Rp. 10.000</p>
                    </div>

                    {{-- <div class="card-nav">
                        <a href="{{route('warga.detailkas')}}" class="link-a-disable text-small text-center">Detail</a>

                        <a href="" class="link-a-active text-small text-center"><i
                                class="ri-arrow-right-long-line"></i>Bayar</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="kas">

        <div class="kas-section">
            {{-- <h6>Iuran</h6> --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <i class="ri-wallet-3-line card-icon"></i>
                        <h6>Bukti Pembayaran</h6>
                    </div>

                    {{-- <div class="card-info">
                        <p class="cp">ketuk gambar untuk melihat</p>
                        <h3>Rp. 10.000</h3>
                    </div> --}}
                </div>

                <div class="card-image">
                    <img src="" alt="foto bukti">
                </div>
                <p class="cp-gray">ketuk gambar untuk melihat</p>

                <div class="card-menu">
                    {{-- <div class="card-status-success">
                        <p class="cp">Sudah Bayar</p>
                        <p class="cp">Total : Rp. 10.000</p>
                    </div> --}}

                    <div class="card-nav">
                        {{-- <p class="link-a-disable text-small text-center">08/07/25</p> --}}

                        <a href="{{route('admin.detailkas')}}" class="link-a-active text-small text-center">
                            {{-- <i class="ri-arrow-right-long-line"></i> --}}
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
