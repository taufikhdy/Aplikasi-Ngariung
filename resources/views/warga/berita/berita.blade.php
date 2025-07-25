@extends('layouts.warga')

@section('title', 'Berita')

@section('content')

<div class="news-section">
        <div class="news-menu">
            <h4>Berita</h4>
            {{-- <a href="" class="text-small">Lihat semua</a> --}}
        </div>

        @if($beritas->isEmpty())
            <p class="cp-gray text-center">Belum ada berita</p>
        @else
        @foreach ($beritas as $berita)

        <div class="news-group">

            <div class="news">
                <div class="image">
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="img berita">
                </div>

                <div class="detail">
                    <h4>{{$berita->judul}}</h4>

                    <p class="text-small text-justify isi">{{$berita->isi}}</p>

                    <div class="news-menu">
                        <p class="cp">{{Carbon\Carbon::parse($berita->tanggal)->format('d M Y')}}</p>

                        <a href="{{route('warga.detailBerita', ['id' => $berita->id])}}" class="text-small">Lihat detail</a>
                    </div>


                </div>
            </div>

        </div>
        @endforeach

        @endif

    </div>
{{--
    <div class="navigasi">
        <a href="{{ route('admin.formTambahBerita') }}" class="link-a-active big text-center text-small tombol">Buat Berita</a>
    </div> --}}

@endsection
