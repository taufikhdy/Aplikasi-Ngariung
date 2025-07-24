@extends('layouts.rt')

@section('title', 'Surat Pengajuan')

@section('content')



    <div class="surat">
        <h6>Surat Masuk</h6>

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
