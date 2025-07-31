@extends('layouts.rt')

@section('title', 'Tambah Kas')

@section('content')

    <div class="tambah-kas">

        <div class="tambah-kas-header">
            <h4>Tambah Kas</h4>
        </div>

        <form action="{{ route('admin.kas.store') }}" method="post">
            @csrf
            <div class="form">
                <div class="input-tambah">
                    <label for="nama">Nama Kas</label>
                    <input type="text" name="nama_kas" id="nama" placeholder="Nama Kas" autocomplete="off" required>
                    @error(('nama_kas'))
                        <p class="message-error cp">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-tambah">
                    <label for="saldo">Saldo Kas</label>
                    <input type="number" name="saldo" id="saldo" placeholder="Saldo Kas">
                </div>

                <div class="input-tambah">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi_kas" id="deskripsi" rows="5" cols="20">Deskripsi...</textarea>
                </div>
            </div>

            <input type="submit" name="" id="" placeholder="Tambah Kas" class="text-small"
                value="Tambah Kas" onclick="loading()">

        </form>
        <a href="{{ route('admin.kasiuran') }}" class="link-a-error big text-small text-center">Batal</a>
    </div>

@endsection
