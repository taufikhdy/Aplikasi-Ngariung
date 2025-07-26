@extends('layouts.rt')

@section('title', 'Surat Pengajuan')

@section('content')



    <div class="surat">
        <h6>Surat Masuk</h6>

        <div class="surat-section">

            @foreach ($surats as $surat)
                <div class="lite-card">

                    <div class="header">
                        @if ($surat->status == 'diproses')
                            <p class="text-small link-a-warning">{{ $surat->status }}</p>
                        @elseif ($surat->status == 'disetujui')
                            <p class="text-small link-a-success">{{ $surat->status }}</p>
                        @elseif ($surat->status == 'ditolak')
                            <p class="text-small link-a-error">{{ $surat->status }}</p>
                        @endif
                    </div>

                    <h6 class="title">{{$surat->jenisSurat->nama_jenis}}</h6>
                    <p class="text-small">Diajukan oleh : {{$surat->warga->nama}}</p>

                    <div class="menu">
                        <p class="cp-gray">{{ Carbon\Carbon::parse($surat->created_at)->format('d M Y') }}</p>
                        <a href="" class="text-small">Detail</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


@endsection
