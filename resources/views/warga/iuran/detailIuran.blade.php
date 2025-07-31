@extends('layouts.warga')

@section('title', 'Detail Kas')

@section('content')

    <div class="bg">
        <div class="back">
            <a href="{{ route('warga.kasiuran') }}">
                <h4 class="text-white"><i class="ri-arrow-left-long-line small-icon"></i>Detail Iuran</h4>
            </a>
        </div>



        <div class="card">
            <div class="card-head">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ri-wallet-3-line card-icon"></i>
                        <h6>{{ $iuran->nama_iuran }}</h6>
                    </div>
                </div>

                <div class="card-info">
                    <p class="cp">Dibuat pada : {{ $iuran->created_at->format('d M Y') }}</p>
                    <p class="cp">Berakhir Tanggal {{ $iuran->tanggal_akhir }}</p>
                    <h3>{{ 'Rp. ' . number_format($iuran->jumlah, 0, ',', '.') }}</h3>
                </div>
            </div>

        </div>
    </div>



    <div class="kas-text">
        <h6><i class="ri-wallet-3-line title-icon"></i> {{ $iuran->nama_iuran }}</h6>

        <p class="text-small">
            {{ $iuran->deskripsi }}
        </p>
    </div>


    <div class="data-list">

        <div class="data">
            <div class="data-caption">
                <h6>Detail Iuran</h6>
            </div>

            <div class="row">

                {{-- @if (!$riwayat)
                    <p class="cp-gray text-center">Belum ada riwayat bayar</p>
                @else --}}
                <div class="item">
                    <p class="text-regular">Total Target Iuran </p>
                    <p class="text-regular">{{ 'Rp. ' . number_format($target, 0, ',', '.') }}</p>
                </div>

                <div class="item">
                    <p class="text-regular">Total Iuran Terkumpul</p>
                    <p class="text-regular">{{ 'Rp. ' . number_format($total_masuk, 0, ',', '.') }}</p>
                </div>

                <div class="item">
                    <p class="text-regular">Sudah Bayar </p>
                    <p class="text-regular">{{ $sudah_bayar . ' warga dari ' . $total_warga . ' warga' }}</p>
                </div>
                {{-- @endif --}}
            </div>

        </div>

    </div>


    <div class="data-list">

        <div class="data">
            <div class="data-caption">
                <h6>Riwayat Bayar</h6>
            </div>

            {{-- search-box
            <div class="search-box">
                <form action="" method="post">
                    <input type="text" name="" id="" placeholder="Cari Warga">
                </form>
            </div> --}}

            <div class="row">

                @if (!$riwayat)
                    <p class="cp-gray text-center">Belum ada riwayat bayar</p>
                @else
                    <div class="item">
                        <p class="text-regular">{{ $riwayat->warga->nama }}</p>

                        <a href="#popup-{{ $riwayat->id }}" class="text-small">Lihat bukti</a>

                        <div id="popup-{{ $riwayat->id }}" class="popup-overlay">
                            <a href="#" class="popup-content">
                                <img src="{{ asset('storage/' . $riwayat->bukti_bayar) }}" alt="bukti bayar">
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>

    @if (!$riwayat)
        <div class="navigasi">
            <a href="{{ route('warga.formBayarIuran', ['id' => $iuran->id] ) }}"
                class="link-a-active big text-center text-small tombol">Bayar Iuran</a>
        </div>
    @endif
@endsection
