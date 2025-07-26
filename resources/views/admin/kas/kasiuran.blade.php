@extends('layouts.rt')

@section('title', 'Kas & Iuran')

@section('content')

    @if (session('success'))
        <p class="message-success cp" id="message-success">{{ session('success') }}</p>
    @endif

    <div class="kas">

        <div class="kas-section">
            <h6>Kas</h6>

            @if ($kas->isEmpty())
                <p class="cp-gray text-center">Belum ada kas untuk saat ini.</p>
            @else
                @foreach ($kas as $k)
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <div class="card-title">
                                    <i class="ri-wallet-3-line card-icon"></i>
                                    <h6>{{ $k->nama_kas }}</h6>
                                    <div class="">
                                        <form action="{{ route('admin.hapusKas', $k->id) }}" method="post"
                                            onsubmit="return confirm('Yakin ingin menghapus kas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="small-icon delete-btn"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card-info">
                                <p class="cp">diperbarui pada : {{ $k->updated_at->format('d M Y') }}</p>
                                <h3>Saldo : {{ 'Rp. ' . number_format($k->saldo, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="card-menu">

                            <div class="card-nav">
                                <a href="{{ route('admin.detailkas', ['id' => $k->id]) }}"
                                    class="link-a-disable text-small text-center">Detail</a>
                                <a href="{{ route('admin.kelolaKas', ['id' => $k->id]) }}"
                                    class="link-a-secondary text-small text-center">Kelola</a>
                            </div>
                        </div>

                    </div>
                @endforeach
            @endif
        </div>

        <div class="kas-section">
            <h6>Iuran</h6>

            @if ($k_iurans->isEmpty())
                <p class="cp-gray text-center">Belum ada iuran untuk saat ini.</p>
            @else
                @foreach ($k_iurans as $iuran)
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <div class="card-title">
                                    <i class="ri-wallet-3-line card-icon"></i>
                                    <h6>{{ $iuran->nama_iuran }}</h6>
                                    <div class="">
                                        <form action="{{ route('admin.hapusIuran', $iuran->id) }}" method="post"
                                            onsubmit="return confirm('Yakin ingin menghapus iuran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="small-icon delete-btn"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card-info">
                                <p class="cp">Berakhir tanggal {{ Carbon\Carbon::parse($iuran->tanggal_akhir)->format('d M Y') }}</p>
                                <h3>{{ 'Rp. ' . number_format($iuran->jumlah, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="card-menu">
                            <div class="card-nav">
                                <a href="" class="link-a-disable text-small text-center">Detail</a>
                                <a href="{{ route('admin.kelolaIuran', ['id' => $iuran->id]) }}"
                                    class="link-a-secondary text-small text-center">Kelola</a>
                                {{-- <form action="{{ route('admin.hapusIuran', ['id' => $iuran->id]) }}" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus iuran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" name="" id="" value="Hapus"
                                        class="link-a-error text-small text-center">
                                </form> --}}
                            </div>
                        </div>
                        {{-- <div class="more-action" id="more-action">
                            <form action="{{ route('admin.hapusKas', $iuran->id) }}" method="post"
                                onsubmit="return confirm('Yakin ingin menghapus kas ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="submit" name="" id="" value="Hapus"
                                    class="delete-btn text-small text-center">
                            </form>
                        </div> --}}
                    </div>
                @endforeach
            @endif

        </div>

    </div>

    <div class="navigasi">
        <a href="{{ route('admin.formTambahKas') }}" class="link-a-active big text-center text-small tombol">Tambah Kas</a>
        <a href="{{ route('admin.formTambahIuran') }}" class="link-a-active big text-center text-small tombol">Tambah
            Iuran</a>
    </div>

@endsection
