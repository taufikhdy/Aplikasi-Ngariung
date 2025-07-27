@extends('layouts.rt')

@section('title', 'Profile')

@section('content')

    <div class="form-box">
        <div class="form-header">
            <h6 class="text-center">Profil</h6>
        </div>

        {{-- disini form ubah --}}
        <form action="" method="post">
            @csrf
            <div class="input-group">

                <div class="input-box">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="name" id="nama" placeholder="Nama" autocomplete="off" disabled value="{{Auth::user()?->warga?->nama}}">
                </div>

                <div class="input-box">
                    <label for="nik">Nomor Kartu Keluarga</label>
                    <input type="number" name="nik" id="nik" placeholder="Nomor Kartu Keluarga"
                        autocomplete="off" disabled value="{{Auth::user()?->warga?->kartuKeluarga?->no_kk}}">
                </div>

                <div class="input-box">
                    <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                    <input type="number" name="nik" id="nik" placeholder="Nomor Induk Kependudukan"
                        autocomplete="off" disabled value="{{Auth::user()?->warga?->nik}}">
                </div>

                <div class="input-box">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="" rows="1" disabled>{{Auth::user()?->warga?->kartuKeluarga?->alamat}}</textarea>
                </div>

            </div>
        </form>
    </div>

    <div class="data-list">
        <hr>
        {{-- search-box --}}
        <div class="search-box">
            <form action="" method="post">
                <input type="text" name="" id="" placeholder="Cari Warga">
            </form>
        </div>

        <div class="data">
            <div class="data-caption">
                <p class="cp">Data Keluarga</p>
            </div>

            <div class="row">

                @if ($keluargas->isEmpty())
                    <p class="cp-gray text-center">Data tidak tersedia</p>
                @else
                    @foreach ($keluargas as $keluarga)
                        <div class="item">
                            <p class="text-regular">{{ $keluarga->nama }}</p>
                            <p class="text-regular">{{ $keluarga->status_keluarga }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

@endsection
