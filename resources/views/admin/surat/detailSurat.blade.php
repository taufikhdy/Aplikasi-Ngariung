@extends('layouts.rt')

@section('title', 'Detail Surat Pengajuan')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <h4>Detail {{ $surat->jenisSurat->nama_jenis }}</h4>

            @if ($surat->status == 'diproses')
                <p class="text-small link-a-warning" style="width: max-content;">{{ $surat->status }}</p>
            @elseif ($surat->status == 'disetujui')
                <p class="text-small link-a-success" style="width: max-content;">{{ $surat->status }}</p>
            @elseif ($surat->status == 'ditolak')
                <p class="text-small link-a-error" style="width: max-content;">{{ $surat->status }}</p>
            @endif

        </div>

        {{-- disini form ubah --}}
        <form action="" method="post">
            @csrf
            <div class="input-group">

                <div class="input-box">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama" autocomplete="off" disabled
                        value="{{ $surat->warga->nama }}">
                </div>

                <div class="input-box">
                    <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                    <input type="number" name="nik" id="nik" placeholder="Nomor Induk Kependudukan"
                        autocomplete="off" disabled value="{{ $surat->warga->nik }}">
                </div>

                <div class="input-box">
                    <label for="keperluan">Keperluan</label>
                    <input type="text" name="keperluan" id="keperluan" placeholder="Keperluan" autocomplete="off" disabled
                        value="{{ $surat->skck->keperluan }}">
                </div>

                <div class="input-box">
                    <label for="tujuan">Tujuan</label>
                    <input type="text" name="tujuan_skck" id="tujuan" placeholder="Tujuan" autocomplete="off" disabled
                        value="{{ $surat->skck->tujuan_skck }}">
                </div>

                <div class="input-box">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="" rows="1" disabled>{{ Auth::user()?->warga?->kartuKeluarga?->alamat }}</textarea>
                </div>

            </div>
        </form>

        <div class="form-surat">
            @if ($surat->status == 'diproses')
                <form action="{{ route('admin.setujuiSurat', $surat->id) }}" method="post">
                <form action="" method="post">
                    @csrf
                    <input type="submit" name="" id="" value="Setujui" class="text-small" onclick="loading()">
                </form>
                <br>
                <hr>
                <br>
                <form action="{{ route('admin.tolakSurat', $surat->id) }}" method="post">
                    @csrf
                    <input type="text" name="alasan" id="" placeholder="Alasan Penolakan" required
                        class="alasan">
                    <button type="submit" class="text-small tolak" onclick="loading()">Tolak</button>
                </form>
            @endif
        </div>
    </div>

@endsection
