@extends('layouts.warga')

@section('title', 'Kas & Iuran')

@section('content')


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
                                <p class="text-regular">Pukul {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }}</p>
                                <p class="text-regular">Sampai {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }}
                                </p>
                            @elseif($jam->libur)
                                <p class="text-regular">{{ $jam->hari }}</p>
                                <p class="text-regular">Hari {{$jam->hari}} libur</p>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


@endsection
