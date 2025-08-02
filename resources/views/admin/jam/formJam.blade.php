@extends('layouts.rt')

@section('title', 'Jam Operasional RT')

@section('content')

    @if (session('success'))
        <p class="message-success cp" id="message">{{ session('success') }}</p>
    @endif

    <div class="tambah-kas">

        <div class="tambah-kas-header">
            <h4>Jam Operasional</h4>
        </div>

        <form action="{{ route('admin.tambahJam') }}" method="post">
            @csrf
            <div class="form">
                <div class="input-tambah-flex">

                    <div class="input-tambah">
                        <label for="hari">Hari</label>
                        <select name="hari" id="hari" required>
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                            <option value="minggu">Minggu</option>
                        </select>
                    </div>

                    <div class="input-tambah">
                        <label for="jam-mulai">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam-mulai" placeholder="Jam Mulai" required>
                    </div>

                    <div class="input-tambah">
                        <label for="jam-selesai">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam-selesai" placeholder="Jam Selesai" required>
                    </div>

                </div>

                <div class="input-tambah-flex">
                    <label for="libur">Hari libur</label>
                    <input type="checkbox" name="libur" id="libur" style="width: max-content"
                        onchange="free()">
                </div>
            </div>

            <input type="submit" name="submit" id="" value="Simpan Jam Operasional" class="text-small"
                onclick="loading()">
        </form>

    </div>


    <div class="data-list">
        <h4 class="text-center">Jam Operasional RT</h4>

        <div class="data">
            <div class="data-caption">
                {{-- <p class="cp">Data Jam Operasional RT</p> --}}
            </div>

            <div class="row">

                @if ($jams->isEmpty())
                    <p class="cp-gray text-center">Data jam operasional belum tersedia</p>
                @else
                    @foreach ($jams as $jam)
                        <div class="item">
                            @if (!$jam->libur)
                                <p class="text-regular">{{ $jam->hari }}</p>
                                <p class="text-regular">Pukul {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }}
                                </p>
                                <p class="text-regular">Sampai {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}
                                </p>
                                <form action="{{ route('admin.hapusJam', $jam->id) }}" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus jam ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="small-icon delete-btn" onclick="loading()"><i
                                            class="ri-delete-bin-line"></i></button>
                                </form>
                            @elseif($jam->libur)
                                <p class="text-regular">{{ $jam->hari }}</p>
                                <p class="text-regular">Hari {{ $jam->hari }} libur</p>
                                <form action="{{ route('admin.hapusJam', $jam->id) }}" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus jam ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="small-icon delete-btn" onclick="loading()"><i
                                            class="ri-delete-bin-line"></i></button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


@endsection
