@extends('layouts.warga')

@section('title', 'Kas & Iuran')

@section('content')

    <div class="kas">

        <div class="kas-section">
            <h4>Kas</h4>

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
                                </div>
                            </div>

                            <div class="card-info">
                                <p class="cp">diperbarui pada : {{ $k->updated_at->format('d M Y') }}</p>
                                <h3>Saldo : {{ 'Rp. ' . number_format($k->saldo, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="card-menu">

                            <div class="card-nav">
                                <a href="{{ route('warga.detailkas', ['id' => $k->id]) }}"
                                    class="link-a-disable text-small text-center">Detail</a>
                                {{-- <a href="{{ route('admin.kelolaKas', ['id' => $k->id]) }}"
                                    class="link-a-secondary text-small text-center">Kelola</a> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="kas-section">
            <h4>Iuran</h4>

            {{-- ini iuran yang lagi aktif di controller pakai iurans untuk tgl yang aktif kalau k_iurans semua iuran --}}
            @if ($iuranNew->isEmpty())
                <p class="cp-gray text-center">Belum ada iuran untuk saat ini.</p>
            @else
                @foreach ($iuranNew as $iuran)
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <div class="card-title">
                                    <i class="ri-wallet-3-line card-icon"></i>
                                    <h6>{{ $iuran->nama_iuran }}</h6>
                                </div>
                            </div>

                            <div class="card-info">
                                <p class="cp">Berakhir tanggal {{ Carbon\Carbon::parse($iuran->tanggal_akhir)->format('d M Y') }}</p>
                                <h3>{{ 'Rp. ' . number_format($iuran->jumlah, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="card-menu">
                            @if ($iuran->iuran->isEmpty())
                                <div class="card-status-warning">
                                    <p class="cp">Belum Bayar</p>
                                    <p class="cp">{{ 'Rp. ' . number_format($iuran->jumlah, 0, ',', '.') }}</p>
                                </div>
                                <div class="card-nav">
                                    <a href="" class="link-a-disable text-small text-center">Detail</a>

                                    <a href="{{route('warga.formBayarIuran', ['id' => $iuran->id] )}}" class="link-a-secondary text-small text-center"><i class="ri-arrow-right-line"></i> Bayar</a>
                                    {{-- <form action="{{ route('warga.bayarIuran', ['id' => $iuran->id]) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="kategori_iuran_id" id="" value="{{$iuran->id}}">
                                        <button type="submit" name="" id=""
                                            class="link-a-secondary-full text-small text-center"><i class="ri-arrow-right-line"></i> Bayar</button>
                                    </form> --}}
                                </div>
                            @else
                                <div class="card-status-success">
                                    <p class="cp">Sudah Bayar</p>
                                    <p class="cp">{{ Carbon\Carbon::parse($iuran->iuran->first()->tanggal_bayar)->format('d M Y') }}</p>
                                </div>
                                <div class="card-nav">
                                    <a href="{{route('warga.detailIuran', ['id' => $iuran->id] )}}" class="link-a-disable text-small text-center">Detail</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

    </div>

@endsection
