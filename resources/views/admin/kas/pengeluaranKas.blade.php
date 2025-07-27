@extends('layouts.rt')

@section('title', 'Detail Pengeluaran')

@section('content')

    <div class="riwayat-section">
        <div class="back">
            <a href="{{ url()->previous() }}">
                <h4><i class="ri-arrow-left-long-line regular-icon"></i>Riwayat Transaksi Kas</h4>
            </a>
        </div>

        @if ($transaksis->isEmpty())
            <p class="cp text-center">Belum ada transaksi.</p>
        @else
            {{-- @foreach ($pengeluarans as $pengeluaran)
                <div class="pengeluaran">

                    <div class="detail-pengeluaran">
                        <p class="text-small">Pengeluaran Tanggal {{ $pengeluaran->tanggal }}</p>
                        <div class="rincian">
                            <div class="saldo-keluar">
                                <p class="cp">{{ $pengeluaran->keterangan }}</p>
                                <p class="cp keluar">{{ $pengeluaran->jumlah }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="rincian-menu">
                        <p class="box-a-error text-small">
                            Total Pengeluaran<br>
                            {{ $total_pengeluaran }}
                        </p>

                        <p class="box-a-disable text-small">
                            Total Saldo Akhir <br>
                            {{ $saldo_akhir }}
                        </p>
                    </div>
                </div>
            @endforeach --}}

            @foreach ($transaksis as $transaksi)
                <div class="riwayat">

                    <div class="riwayat-detail">
                        <p class="text-small">Transaksi Tanggal :
                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}</p>
                        <div class="riwayat-rincian">
                            <p class="cp">{{ $transaksi->jenis }}</p>
                            <div class="saldo-keluar">
                                <p class="cp">{{ $transaksi->keterangan }}</p>
                                <p class="cp keluar">{{ 'Rp. ' . number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach
            <div class="rincian-menu">
                <p class="box-a-error text-small">
                    Total Pengeluaran<br>
                    {{ $total_keluar }}
                </p>

                <p class="box-a-disable text-small">
                    Total Saldo Akhir <br>
                    {{ $saldo_akhir }}
                </p>
            </div>
    </div>

    @endif

    </div>

@endsection
