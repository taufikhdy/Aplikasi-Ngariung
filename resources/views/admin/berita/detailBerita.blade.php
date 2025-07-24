@extends('layouts.rt')

@section('title', 'Berita')

@section('content')


    <div class="berita-section">
        <div class="back">
            <a href="{{ url()->previous() }}">
                <h4 class="text-black"><i class="ri-arrow-left-long-line regular-icon"></i>Berita</h4>
            </a>
        </div>
        <div class="berita-header">
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="berita img">
            <div class="berita-title">
                <p class="cp">{{ Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</p>
                <h3>{{ $berita->judul }}</h3>
            </div>
        </div>
        <div class="berita-content">
            <p>{!! nl2br(e($berita->isi)) !!}</p>
        </div>
    </div>

    <form action="{{ route('admin.hapusBerita', ['id' => $berita->id]) }}" method="post"
        onsubmit="return confirm('Yakin ingin menghapus berita ini?')" class="navigasi">
        @csrf
        @method('DELETE')
        <input type="submit" name="" id="" class="link-a-error big text-small text-center tombol"
            value="Hapus">
    </form>

@endsection
