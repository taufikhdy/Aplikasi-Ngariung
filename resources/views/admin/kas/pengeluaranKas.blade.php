@extends('layouts.rt')

@section('title', 'Detail Pengeluaran')

@section('content')

    <div class="pengeluaran-section">
        <h6>Pengeluaran</h6>

        @if ($pengeluarans->isEmpty())
            <p class="cp text-center">Belum ada transaksi pengeluaran.</p>
        @else
            @foreach ($pengeluarans as $pengeluaran)
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
            @endforeach
    </div>

    @endif

    </div>

@endsection
