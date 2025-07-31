@extends('layouts.rt')

@section('title', 'Tambah Iuran')

@section('content')

    <div class="tambah-kas">

        <div class="tambah-kas-header">
            <h4>Tambah Iuran</h4>
        </div>

        <form action="{{ route('admin.tambahIuran') }}" method="post">
            @csrf
            <div class="form">
                <div class="input-tambah">
                    <label for="nama">Nama Iuran</label>
                    <input type="text" name="nama_iuran" id="nama" placeholder="Nama iuran" required autocomplete="off">
                    @error('nama_iuran')
                        <p class="message-error cp">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-tambah">
                    <label for="jumlah">Nominal Iuran</label>
                    <input type="number" name="jumlah" id="jumlah" placeholder="Contoh : 10000" required>
                    @error('jumlah')
                        <p class="message-error cp">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-tambah-flex">
                    <div class="input-tambah">
                        <label for="tanggal-mulai">Tanggal Awal</label>
                        <input type="date" name="tanggal_mulai" id="tanggal-mulai" placeholder="Tanggal Mulai" required>
                    </div>

                    <div class="input-tambah">
                        <label for="tanggal-akhir">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="tanggal-akhir" placeholder="Tanggal Akhir" required>
                    </div>

                </div>

                <div class="input-tambah-flex">
                    @error('tanggal_mulai')
                    <p class="message-error cp">{{ $message }}</p>
                    @enderror

                    @error('tanggal_akhir')
                    <p class="message-error cp">{{ $message }}</p>
                    @enderror
                </div>

                <div class="input-tambah">
                    <label for="jenis">Jenis Iuran</label>
                    <select name="jenis" id="jenis">
                        <option value="kk">Per-Keluarga</option>
                        <option value="perorangan">Perorangan</option>
                    </select>
                </div>

                <div class="input-tambah">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="5" cols="20" required>Deskripsi...</textarea>
                    @error('deskripsi')
                        <p class="message-error cp">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <input type="submit" name="submit" id="" value="Tambah Iuran" class="text-small" onclick="loading()">
        </form>
        <a href="{{ route('admin.kasiuran') }}" class="link-a-error big text-small text-center">Batal</a>

    </div>

@endsection
