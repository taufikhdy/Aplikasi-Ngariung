@extends('layouts.rt')

@section('title', 'Tambah Warga')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <h6 class="text-center">Tambah Warga</h6>
        </div>

        {{-- disini form ubah --}}
        <form action="{{ route('admin.simpanWarga') }}" method="post">
            @csrf
            <div class="input-group">


                {{-- Cek Data KK --}}
                <div class="input-box">
                    <label for="opsiKK">Apakah KK sudah ada?</label>
                    <select name="" id="opsiKK">
                        <option value="ada">Ya, pilih dari KK yang sudah ada.</option>
                        <option value="baru">Belum, buat KK baru.</option>
                    </select>
                </div>

                {{-- KK jika ada --}}
                <div class="input-box" id="pilih">
                    <label for="no_kk">Nomor Kartu Keluarga</label>
                    <select name="kk_id" id="no_kk" placeholder="Nomor Kartu Keluarga" autocomplete="off">
                        <option value="" disabled selected>-- Pilih No KK --</option>

                        @foreach ($no_kk as $kk)
                            <option value="{{ $kk->id }}">{{ $kk->no_kk }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- KK jika belum ada --}}
                <div class="kkbaru" id="buat" style="display: none;">
                    <div class="input-box">
                        <label for="nomor_kk">Nomor Kartu Keluarga</label>
                        <input type="number" name="nomor_kk" id="no_kk" placeholder="Nomor Kartu Keluarga">
                    </div>

                    <br>

                    <div class="input-box">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" cols="" rows=""></textarea>
                    </div>

                    <br>

                    <div class="input-box">
                        <label for="rt">RT</label>
                        <input type="number" name="rt" placeholder="RT">
                    </div>

                    <br>

                    <div class="input-box">
                        <label for="rw">RW</label>
                        <input type="number" name="rw" placeholder="RW">
                    </div>

                    <br>
                    <hr>
                </div>


                <div class="input-box">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama" autocomplete="off">
                </div>


                <div class="input-box">
                    <label for="nik">Nomor Induk Kependudukan</label>
                    <input type="number" name="nik" id="nik" placeholder="Nomor Induk Kependudukan"
                        autocomplete="off">
                </div>

                <div class="input-box">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" placeholder="Jenis Kelamin" autocomplete="off">

                        <option value="">-- Jenis Kelamin --</option>

                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="lahir">Tempat, Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="lahir" placeholder="Nomor Induk Kependudukan"
                        autocomplete="off">
                </div>

                <div class="input-box">
                    <label for="agama">Agama</label>
                    <select name="agama" id="agama" placeholder="Agama" autocomplete="off">

                        <option value="" disabled selected>-- Pilih Agama --</option>

                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="pendidikan">Pendidikan</label>
                    <input type="text" name="pendidikan" id="pendidikan" placeholder="Pendidikan" autocomplete="off">
                </div>

                <div class="input-box">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" placeholder="Pekerjaan" autocomplete="off">
                </div>

                <div class="input-box">
                    <label for="status_perkawinan">Status Perkawinan</label>
                    <select name="status_perkawinan" id="status_perkawinan" placeholder="Status Perkawinan"
                        autocomplete="off">

                        <option value="" disabled selected>-- Status Perkawinan --</option>

                        <option value="belum_kawin">Belum Kawin</option>
                        <option value="kawin">Kawin</option>
                        <option value="cerai hidup">Cerai Hidup</option>
                        <option value="cerai mati">Cerai Mati</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="status_keluarga">Status Keluarga</label>
                    <select name="status_keluarga" id="status_keluarga" placeholder="Status Keluarga"
                        autocomplete="off">

                        <option value="" disabled selected>-- Status Keluarga --</option>

                        <option value="kepala">Kepala Keluarga</option>

                        <option value="anggota">Anggota</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="telepon">Telepon</label>
                    <input type="number" name="telepon" id="telepon" placeholder="Nomor Telepon" autocomplete="off">
                </div>

            </div>

            <input type="submit" name="" id="" value="Tambah Warga" class="text-small" onclick="loading()">
        </form>

        <a href="{{ route('admin.dataWarga') }}" class="link-a-error big text-small text-center">Batal</a>

    </div>

@endsection
