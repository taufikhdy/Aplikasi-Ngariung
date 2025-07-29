@extends('layouts.rt')

@section('title', 'Edit Data Warga')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <h6 class="text-center">Edit Data Warga</h6>
        </div>

        {{-- disini form ubah --}}
        <form action="{{ route('admin.updateWarga', $warga->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="input-group">

                <div class="input-box">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama" autocomplete="off"
                        value="{{ old('nama', $warga->nama) }}">
                </div>

                <div class="input-box">
                    <label for="no_kk">Nomor Kartu Keluarga</label>
                    <select name="kk_id" id="no_kk" placeholder="Nomor Kartu Keluarga" autocomplete="off">
                        <option value="" disabled selected>-- Pilih No KK --</option>

                        @foreach ($no_kk as $kk)
                            <option value="{{ $kk->id }}" {{ $kk->id == $warga->kk_id ? 'selected' : '' }}>
                                {{ $kk->no_kk }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-box">
                    <label for="nik">Nomor Induk Kependudukan</label>
                    <input type="number" name="nik" id="nik" placeholder="Nomor Induk Kependudukan"
                        autocomplete="off" value="{{old('nik', $warga->nik)}}">
                </div>

                <div class="input-box">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" placeholder="Jenis Kelamin" autocomplete="off">

                        <option value="{{old('jenis_kelamin', $warga->jenis_kelamin)}}" selected>{{old('jenis_kelamin', $warga->jenis_kelamin)}}</option>

                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="lahir">Tempat, Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="lahir" placeholder="Nomor Induk Kependudukan"
                        autocomplete="off" value="{{old('tanggal_lahir', $warga->tanggal_lahir)}}">
                </div>

                <div class="input-box">
                    <label for="agama">Agama</label>
                    <select name="agama" id="agama" placeholder="Agama" autocomplete="off">

                        <option value="{{old('agama', $warga->agama)}}" selected>{{old('agama', $warga->agama)}}</option>

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
                    <input type="text" name="pendidikan" id="pendidikan" placeholder="Pendidikan" autocomplete="off" value="{{old('pendidikan', $warga->pendidikan)}}">
                </div>

                <div class="input-box">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" placeholder="Pekerjaan" autocomplete="off" value="{{old('pekerjaan', $warga->pekerjaan)}}">
                </div>

                <div class="input-box">
                    <label for="status_perkawinan">Status Perkawinan</label>
                    <select name="status_perkawinan" id="status_perkawinan" placeholder="Status Perkawinan"
                        autocomplete="off">

                        <option value="{{old('status_perkawinan', $warga->status_perkawinan)}}" selected>{{old('status_perkawinan', $warga->status_perkawinan)}}</option>

                        <option value="belum_kawin">Belum Kawin</option>
                        <option value="kawin">Kawin</option>
                        <option value="cerai hidup">Cerai Hidup</option>
                        <option value="cerai mati">Cerai Mati</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="status_keluarga">Status Keluarga</label>
                    <select name="status_keluarga" id="status_keluarga" placeholder="Status Keluarga" autocomplete="off">

                        <option value="{{old('status_keluarga', $warga->status_keluarga)}}" selected>{{old('status_keluarga', $warga->status_keluarga)}}</option>

                        <option value="kepala">Kepala Keluarga</option>

                        <option value="anggota">Anggota</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="telepon">Telepon</label>
                    <input type="number" name="telepon" id="telepon" placeholder="Nomor Telepon" autocomplete="off" value="{{old('telepon', $warga->telepon)}}">
                </div>

            </div>

            <input type="submit" name="" id="" value="Edit Data Warga" class="text-small">
        </form>

        <a href="{{ route('admin.dataWarga') }}" class="link-a-error big text-small text-center">Batal</a>
    </div>

@endsection
