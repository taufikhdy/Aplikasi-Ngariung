@extends('layouts.rt')

@section('title', 'Data Warga')

@section('content')

    @if (session('success'))
        <p class="message-success cp" id="message-success">{{ session('success') }}</p>
    @endif

    <div class="form-box">
        <div class="form-header">
            <h6 class="text-center">Data Warga</h6>
        </div>

        <div class="table">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>No KK</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Agama</th>
                    <th>Pendidikan</th>
                    <th>Pekerjaan</th>
                    <th>Status Perkawinan</th>
                    <th>Status Keluarga</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>

                @php
                    $no = 1;
                @endphp

                @foreach ($wargas as $warga)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $warga->nama }}</td>
                        <td>{{ $warga->nik }}</td>
                        <td>{{ $warga->kartuKeluarga->no_kk }}</td>
                        <td>{{ $warga->jenis_kelamin }}</td>
                        <td>{{ $warga->tanggal_lahir }}</td>
                        <td>{{ $warga->agama }}</td>
                        <td>{{ $warga->pendidikan }}</td>
                        <td>{{ $warga->pekerjaan }}</td>
                        <td>{{ $warga->status_perkawinan }}</td>
                        <td>{{ $warga->status_keluarga }}</td>
                        <td>{{ $warga->telepon }}</td>
                        <td class="aksi">
                            <a href="{{ route('admin.editWarga', $warga->id) }}" class="link-a-active text-small">Edit</a>

                            <form action="{{route('admin.hapusWarga', $warga->id)}}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data warga. Tindakan ini akan menghapus data warga beserta akunnya.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-a-error text-samall">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <a href="{{ route('admin.tambahWarga') }}" class="link-a-active big text-small text-center">Tambah Data Warga</a>
    </div>

@endsection
