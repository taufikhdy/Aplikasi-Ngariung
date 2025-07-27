@extends('layouts.rt')

@section('title', 'Dashboard')

@section('content')

    @if (session('surat'))
        <p class="message-success cp" id="message">{{ session('surat') }}</p>
    @endif

    {{-- {{Auth::user()->nik}} --}}

    <div class="bg">
        {{-- search-box --}}
        <div class="search-box">
            {{-- <form action="" method="post">
                <input type="text" name="" id="" placeholder="Cari Layanan">
            </form> --}}
            <p class="text-small">RT/RW 001/001 Kampung Sukaresmi Desa Cibingbin</p>
        </div>


        <div class="overflow">

            @if ($kas->isEmpty() && !$k_iuran)
                <p class="cp text-center text-white">Belum ada data kas dan iuran</p>
            @else
                @foreach ($kas as $k)
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <div class="card-title">
                                    <i class="ri-wallet-3-line card-icon"></i>
                                    <h6>{{ $k->nama_kas }}</h6>
                                </div>
                            </div>

                            <div class="card-info">
                                <p class="cp">diperbarui pada : {{ $k->updated_at->format('d M Y') }}</p>
                                <h3>Saldo : {{ 'Rp. ' . number_format($k->saldo, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="card-menu">

                            <div class="card-nav">
                                <a href="{{ route('admin.detailkas', $k->id) }}"
                                    class="link-a-disable text-small text-center">Detail</a>
                                <a href="{{ route('admin.kelolaKas', $k->id) }}"
                                    class="link-a-secondary text-small text-center">Kelola</a>
                                <form action="{{ route('admin.hapusKas', $k->id) }}" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus kas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" name="" id=""
                                        class="link-a-error text-small text-center" value="Hapus">
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($k_iuran)
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <div class="card-title">
                                    <i class="ri-wallet-3-line card-icon"></i>
                                    <h6>{{ $k_iuran->nama_iuran }}</h6>
                                </div>
                            </div>

                            <div class="card-info">
                                <p class="cp">Berakhir tanggal
                                    {{ Carbon\Carbon::parse($k_iuran->tanggal_akhir)->format('d M Y') }}</p>
                                <h3>{{ 'Rp. ' . number_format($k_iuran->jumlah, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="card-menu">
                            <div class="card-nav">
                                <a href="" class="link-a-disable text-small text-center">Detail</a>
                                <a href="{{ route('admin.kelolaIuran', $k_iuran->id) }}"
                                    class="link-a-secondary text-small text-center">Kelola</a>
                                <form action="{{ route('admin.hapusIuran', $k_iuran->id) }}" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus iuran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" name="" id=""
                                        class="link-a-error text-small text-center" value="Hapus">
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

            @endif

        </div>
    </div>

    <div class="news-section">
        <div class="news-menu">
            <h6>Berita</h6>
            <a href="{{ route('admin.berita') }}" class="text-small">Lihat semua</a>
        </div>

        @if ($beritas->isEmpty())
            <p class="cp text-center">Belum ada berita.</p>
        @else
            @foreach ($beritas as $berita)
                <div class="news-group">

                    <div class="news">
                        <div class="image">
                            @if (!$berita->gambar)
                                <p class="text-center">Tidak ada gambar mini.</p>
                            @else
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="img berita">
                            @endif
                        </div>

                        <div class="detail">
                            <h4>{{ $berita->judul }}</h4>

                            <p class="text-small text-justify isi">{{ $berita->isi }}</p>

                            <div class="news-menu">
                                <p class="cp">{{ Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</p>

                                <a href="{{ route('admin.detailBerita', ['id' => $berita->id]) }}" class="text-small">Lihat
                                    detail</a>
                            </div>


                        </div>
                    </div>

                </div>
            @endforeach

        @endif

    </div>

@endsection
