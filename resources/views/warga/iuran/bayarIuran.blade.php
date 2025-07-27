@extends('layouts.rt')

@section('title', 'Kelola Kas')

@section('content')

    <div class="bg">

        <div class="back">
            {{-- <a href="{{ url()->previous() }}"> --}}
            <a href="{{ route('warga.kasiuran') }}">
                <h4 class="text-white"><i class="ri-arrow-left-long-line small-icon"></i>Bayar Iuran</h4>
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
                    <p class="cp">Dibuat pada tanggal : {{ $iuran->created_at->format('d M Y') }}</p>
                    <p class="cp">Berakhir pada tanggal :
                        {{ \Carbon\Carbon::parse($iuran->tanggal_akhir)->format('d M Y') }}</p>
                    <h3>{{ 'Rp. ' . number_format($iuran->jumlah, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="card-menu">
                <div class="card-nav">
                    <a href="" class="link-a-disable text-small text-center">Detail</a>
                </div>
            </div>
        </div>

    </div>





    <div class="tambah-kas">

        <div class="tambah-kas-header">
            <h6>Bayar Iuran</h6>
        </div>

        <form action="{{ route('warga.bayarIuran', ['id' => $iuran->id] ) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form">

                <input type="hidden" name="warga_id" id="" value="{{Auth::user()->warga->id}}">

                <div class="input-tambah">
                    <label for="bukti_bayar">Bukti Bayar</label>
                    <input type="file" name="bukti_bayar" id="bukti_bayar" placeholder="bukti_bayar" autocomplete="off" required>
                </div>

                <input type="submit" name="" id="" placeholder="Tambah Kas" class="text-small" value="Tambah Kas">
            </div>


        </form>
    </div>


@endsection
