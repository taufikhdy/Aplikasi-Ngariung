@extends('layouts.warga')

@section('title', 'Surat Pengajuan')

@section('content')

    @if (session('success'))
        <p class="message-success cp" id="message-success">{{ session('success') }}</p>
    @endif

    <div class="form-box">
        <div class="form-header">
            <h4>Ajukan Surat</h4>
        </div>

        {{-- disini form ubah --}}
        <h6 class="text-center">Surat Pengajuan SKCK</h6>
        <form action="{{ route('warga.ajukanSkck') }}" method="post">
            @csrf
            <div class="input-group">

                <input type="hidden" name="jenis_surat_id" value="1"> {{-- id SKCK --}}

                <div class="input-box">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ Auth::user()->warga->nama }}"
                        placeholder="Nama" autocomplete="off" required>
                </div>

                <div class="input-box">
                    <label for="nik">NIK</label>
                    <input type="number" name="nik" id="nik" value="{{ Auth::user()->warga->nik }}"
                        placeholder="Nomor Induk Kependudukan" autocomplete="off" required>
                </div>

                <div class="input-box">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="" cols="" rows="" required autocomplete="off">{{ Auth::user()->warga->kartuKeluarga->alamat }}</textarea>
                </div>

                <div class="input-box">
                    <label for="keperluan">Keperluan</label>
                    <input type="text" name="keperluan" id="" placeholder="Keperluan" required
                        autocomplete="off" value="{{ old('keperluan') }}"">
                </div>

                <div class="input-box">
                    <label for="tujuan">Tujuan SKCK</label>
                    <input type="text" name="tujuan_skck" id="" value="{{ old('tujuan_skck') }}"
                        autocomplete="off" placeholder="Tujuan Pengajuan SKCK">
                </div>

            </div>

            <input type="submit" name="" id="" value="Ajukan Surat" class="text-small">
        </form>
    </div>


    <div class="surat">
        <h6>Riwayat Surat Pengajuan</h6>

        <div class="surat-section">

            @foreach ($riwayat_surat as $riwayat)
                <div class="lite-card">

                    <div class="header">
                        <p class="text-small link-a-error">Ditolak</p>
                    </div>

                    <p class="text-small">{{$riwayat->jenisSurat->nama_jenis}}</p>

                    <div class="menu">
                        <p class="cp-gray">{{ Carbon\Carbon::parse($riwayat->created_at)->format('d M Y') }}</p>
                        <a href="{{ route('warga.detailSurat') }}" class="text-small">Detail</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


@endsection
