@extends('layouts.warga')

@section('title', 'Dashboard')

@section('content')

    @if (session('surat'))
        <p class="message-success cp" id="message">{{ session('surat') }}</p>
    @endif

    @if (session('iuran'))
        <p class="message-success cp" id="message-iuran">{{ session('iuran') }}</p>
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

            @if ($kas->isEmpty() && !$iurans)
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
                                <a href="{{ route('warga.pengeluaranKas', ['id' => $k->id]) }}"
                                    class="link-a-error-full cp">Lihat Data
                                    Pengeluaran</a>
                            </div>
                        </div>

                        <div class="card-menu">
                            <div class="card-nav">
                                <a href="{{ route('warga.detailkas', $k->id) }}"
                                    class="link-a-disable text-small text-center">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($iurans as $iuranNew)
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <div class="card-title">
                                    <i class="ri-wallet-3-line card-icon"></i>
                                    <h6>{{ $iuranNew->nama_iuran }}</h6>
                                </div>
                            </div>

                            <div class="card-info">
                                <p class="cp">Berakhir tanggal
                                    {{ Carbon\Carbon::parse($iuranNew->tanggal_akhir)->format('d M Y') }}</p>
                                <h3>{{ 'Rp. ' . number_format($iuranNew->jumlah, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="card-menu">
                            @if ($iuranNew->status_bayar === 'pending' or $iuranNew->status === 'pending')
                                <div class="card-status-warning">
                                    <p class="cp">Belum Bayar</p>
                                    <p class="cp">{{ 'Rp. ' . number_format($iuranNew->jumlah, 0, ',', '.') }}</p>
                                </div>
                                <div class="card-nav">
                                    <a href="{{ route('warga.detailIuran', ['id' => $iuranNew->id]) }}"
                                        class="link-a-disable text-small text-center">Detail</a>

                                    <a href="{{ route('warga.formBayarIuran', ['id' => $iuranNew->id]) }}"
                                        class="link-a-secondary text-small text-center"><i class="ri-arrow-right-line"></i>
                                        Bayar</a>
                                </div>
                            @elseif ($iuranNew->status_bayar === 'terkonfirmasi' or $iuranNew->status === 'terkonfirmasi')
                                <div class="card-status-success">
                                    <p class="cp">Sudah Bayar</p>
                                    <p class="cp">
                                        {{ Carbon\Carbon::parse($iuranNew->tanggal_bayar)->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="card-nav">
                                    <a href="{{ route('warga.detailIuran', ['id' => $iuranNew->id]) }}"
                                        class="link-a-disable text-small text-center">Detail</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach ($iuranNew)

            @endif

        </div>
    </div>

    <div class="data-list" style="padding-bottom: 20px;">

        <div class="data">
            <div class="data-caption">
                {{-- <p class="cp">Data Jam Operasional RT</p> --}}
                <h6>Jam Operasional RT</h6>
            </div>

            <div class="row">

                @if (!$jam)
                    <p class="cp-gray text-center">Data jam operasional belum tersedia</p>
                @elseif ($jam && !$jam->libur)
                    <div class="item">
                        <p class="text-regular">{{ $jam->hari }}</p>
                        <p class="text-regular">Pukul {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }}</p>
                        <p class="text-regular">Sampai {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}</p>
                    </div>
                @elseif ($jam && $jam->libur)
                    <div class="item">
                        <p class="text-regular">{{ $jam->hari }}</p>
                        <p class="text-regula">Hari ini libur</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="news-section">
        <div class="news-menu">
            <h6>Berita</h6>
            <a href="{{ route('warga.berita') }}" class="text-small">Lihat semua</a>
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

                                <a href="{{ route('warga.detailBerita', ['id' => $berita->id]) }}" class="text-small">Lihat
                                    detail</a>
                            </div>


                        </div>
                    </div>

                </div>
            @endforeach

        @endif

    </div>

@endsection
