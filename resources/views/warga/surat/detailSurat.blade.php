@extends('layouts.warga')

@section('title', 'Detail Surat Pengajuan')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <div class="back">
                <a href="{{route('warga.surat')}}"><h4><i class="ri-arrow-left-long-line small-icon"></i> Detail {{ $surat->jenisSurat->nama_jenis }}</h4></a>
            </div>

            @if ($surat->status == 'diproses')
                <p class="text-small text-center link-a-warning" style="width: 100%;">{{ $surat->status }}</p>
            @elseif ($surat->status == 'disetujui')
                <p class="text-small text-center link-a-success" style="width: 100%;">{{ $surat->status }}</p>
            @elseif ($surat->status == 'ditolak')
                <p class="text-small text-center link-a-error" style="width: 100%;">{{ $surat->status }}</p>
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
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="" rows="1" disabled>{{ Auth::user()?->warga?->kartuKeluarga?->alamat }}</textarea>
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


            </div>
        </form>
    </div>

@endsection
