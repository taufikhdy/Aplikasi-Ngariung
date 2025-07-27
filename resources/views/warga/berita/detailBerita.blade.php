@extends('layouts.warga')

@section('title', 'Berita')

@section('content')

    <div class="berita-section">
        <div class="back">
            <a href="{{ url()->previous() }}">
                <h4 class="text-black"><i class="ri-arrow-left-long-line regular-icon"></i>Berita</h4>
            </a>
        </div>
        <div class="berita-header">
            @if (!$berita->gambar)
                <p class="text-center">Tidak ada gambar.</p>
            @else
                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="img berita">
            @endif
            <div class="berita-title">
                <p class="cp">{{ Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</p>
                <h3 class="bold">{{ $berita->judul }}</h3>
            </div>
        </div>
        <div class="berita-content">
            <p>{!! nl2br(e($berita->isi)) !!}</p>
        </div>
    </div>

@endsection
