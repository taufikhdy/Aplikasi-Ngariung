@extends('layouts.rt')

@section('title', 'Tambah Berita')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <h6 class="text-center">Tambah Berita</h6>
        </div>

        {{-- disini form ubah --}}
        <form action="{{ route('admin.tambahBerita') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group">

                <div class="input-box">
                    <label for="judul">Judul Berita</label>
                    <input type="text" name="judul" id="judul" placeholder="Judul Berita" autocomplete="off"
                        required>
                    @error('judul')
                        <p class="message-error cp">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="gambar">Gambar Berita</label>
                    <input type="file" name="gambar" id="gambar" placeholder="Gambar Berita">
                </div>

                <div class="input-box">
                    <label for="isi">Isi Berita</label>
                    <textarea name="isi" id="isi" cols="" rows="5" required>Isi Berita</textarea>
                    @error('isi')
                        <p class="message-error cp">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-box">
                    <label for="tanggal">tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off" required>
                </div>

            </div>

            <input type="submit" name="" id="" value="Tambah Berita" class="text-small" onclick="loading()">
        </form>
        <a href="{{ route('admin.berita') }}" class="link-a-error big text-small text-center">Batal</a>
    </div>

@endsection
