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
                            <p class="cp">Transaksi {{ $transaksi->jenis }}</p>

                            <div class="saldo-detail">
                                <p class="cp">{{ $transaksi->keterangan }}</p>

                                @if ($transaksi->jenis == 'masuk')
                                    <p class="cp masuk">{{ '+ Rp. ' . number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                                @elseif ($transaksi->jenis == 'keluar')
                                    <p class="cp keluar">{{ '- Rp. ' . number_format($transaksi->jumlah, 0, ',', '.') }}</p>
                                @endif

                            </div>

                            <a href="#popup-{{ $transaksi->id }}" class="text-small">Lihat bukti</a>

                            <div id="popup-{{ $transaksi->id }}" class="popup-overlay">
                                <a href="#" class="popup-content">
                                    <img src="{{ asset('storage/' . $transaksi->bukti_transaksi) }}" alt="bukti bayar">
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach
    </div>

    @endif

    <div class="navigasi">
        <div class="rincian-menu">
            <p class="box-a-error text-small">
                Total Pengeluaran {{ 'Rp. ' . number_format($total_keluar, 0, ',', '.') }}
            </p>

            <p class="box-a-disable text-small">
                Total Saldo Akhir {{ 'Rp. ' . number_format($saldo_akhir, 0, ',', '.') }}
            </p>

            <form action="{{ route('admin.hapusRiwayatKas') }}" method="post"
                onsubmit="return confirm('Yakin ingin menghapus semua riwayat transaksi kas?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-small text-center tolak">Hapus Semua Riwayat Transaksi</button>
            </form>
        </div>
    </div>

@endsection
