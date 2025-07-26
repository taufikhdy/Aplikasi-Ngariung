<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

// MODEL
use App\Models\KartuKeluarga;
use App\Models\Warga;
use App\Models\User;

use App\Models\Kas;
use App\Models\TransaksiKas;

use App\Models\Iuran;
use App\Models\KategoriIuran;
use App\Models\TransaksiIuran;

use App\Models\Berita;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\SuratSKCK;

// TANGGAL
use Carbon\Carbon;

use Illuminate\Http\RedirectResponse;

class adminController extends Controller
{
    protected function hanyaUntukAdmin()
    {
        if (!Auth::check() or Auth::user()?->role_id !== 1) {
            abort(403, 'Akses ditolak');
        }
    }

    public function dashboard(): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::all();
        $k_iuran = KategoriIuran::latest()->first();

        $beritas = Berita::latest()->get();
        return view('admin.dashboard', compact('kas', 'k_iuran', 'beritas'));
    }


    //Profile
    public function profile(): View
    {
        $this->hanyaUntukAdmin();
        $keluargas = Warga::where('kk_id', Auth::user()?->warga?->kk_id)->orderBy('status_keluarga', 'desc')->get();
        // PR
        return view('admin.profile', compact('keluargas'));
    }



    public function riwayatBayar(): View
    {
        $this->hanyaUntukAdmin();
        return view('admin.kas.riwayatBayar');
    }

    public function buktiBayar(): View
    {
        $this->hanyaUntukAdmin();
        return view('admin.kas.buktiBayar');
    }


    public function detailSurat(): View
    {
        $this->hanyaUntukAdmin();
        return view('admin.surat.detailSurat');
    }




    //FUNGSI WARGA
    public function dataWarga(): View
    {
        $this->hanyaUntukAdmin();

        $wargas = Warga::with('kartuKeluarga')->get();
        return view('admin.warga.dataWarga', compact('wargas'));
    }

    public function tambahWarga(): View
    {
        $this->hanyaUntukAdmin();

        $no_kk = KartuKeluarga::all();
        return view('admin.warga.tambahWarga', compact('no_kk'));
    }

    public function simpanWarga(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kk_id' => 'required|exists:kartu_keluarga,id',
            'nik' => 'required|numeric|unique:warga,nik',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required|string',
            'status_keluarga' => 'required|string',
            'telepon' => 'required|string'
        ]);

        $warga = Warga::create($request->all());

        User::create([
            'nik' => $warga->nik,
            'password' => Hash::make('password123'),
            'warga_id' => $warga->id,
            'role_id' => 2,
        ]);

        return redirect()->route('admin.dataWarga')->with('success', 'Data Warga berhasil ditambahkan.');
    }


    public function editWarga($id): View
    {
        $this->hanyaUntukAdmin();

        $warga = Warga::findOrFail($id);
        $no_kk = KartuKeluarga::all();
        return view('admin.warga.editWarga', compact('warga', 'no_kk'));
    }


    public function updateWarga(Request $request, $id): RedirectResponse
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'kk_id' => 'required|exists:kartu_keluarga,id',
        //     'nik' => 'required|numeric',
        //     'tanggal_lahir' => 'required|date',
        //     // validasi tambahan sesuai kebutuhan
        // ]);

        $warga = Warga::findOrFail($id);
        $warga->update($request->all());

        return redirect()->route('admin.dataWarga')->with('success', 'Data warga berhasil diperbarui.');
    }


    public function hapuswarga($id){
        User::where('warga_id', $id)->delete();
        Warga::findOrFail($id)->delete();
        return redirect()->route('admin.dataWarga')->with('success', 'Data warga berhasil dihapus');
    }







    // KAS

    public function kasiuran(): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::all();
        $k_iurans = KategoriIuran::orderBy('created_at', 'desc')->get();

        return view('admin.kas.kasiuran', compact('kas', 'k_iurans'));
    }





    //DETAIL KAS
    public function detailkas($id): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::findOrFail($id);
        return view('admin.kas.detailkas', compact('kas'));
    }


    // PROSES TAMBAH KAS
    public function formTambahKas(): View
    {
        $this->hanyaUntukAdmin();
        return view('admin.kas.tambahKas');
    }

    public function tambahKas(Request $request)
    {
        $this->hanyaUntukAdmin();

        $request->validate([
            'nama_kas' => 'required|string|max:100',
            'saldo' => 'required|integer|min:0',
            'deskripsi_kas' => 'nullable|string'
        ], [
            'nama_kas.required' => 'Nama Kas wajib diisi.'
        ]);

        Kas::create($request->all());

        return redirect()->route('admin.kasiuran')->with('success', 'Kas berhasil ditambahkan.');
    }




    // EDIT KAS ?




    // PROSES HAPUS KAS
    public function hapusKas($id)
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::findOrFail($id);

        if($kas->transaksi()->exists()){
            return back()->with('error', 'Tidak bisa menghapus kas yang memiliki transaksi');
        }

        $kas->delete();

        return back()->with('success', 'Kas berhasil dihapus');
    }

    //Kelola Kas
    public function kelolaKas($id): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::findOrFail($id);
        return view('admin.kas.kelolaKas', compact('kas'));
    }

    public function tambahTransaksiKas(Request $request)
    {
        $this->hanyaUntukAdmin();

        $request->validate([
            'kas_id' => 'required|exists:kas,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $kas = Kas::findOrFail($request->kas_id);

        TransaksiKas::create([
            'kas_id' => $request->kas_id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan
        ]);

        if ($request->jenis === 'masuk') {
            $kas->saldo += $request->jumlah;
        } elseif ($request->jenis === 'keluar') {
            $kas->saldo -= $request->jumlah;
        }

        $kas->save();


        // return redirect()->route('admin.kelolaKas', ['id' => $kas->id]);
        return redirect()->route('admin.kasiuran');
    }



    //TRANSAKSI / DATA PENGELUARAN KEUANGAN
    public function pengeluaranKas($id): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::findOrFail($id);
        $pengeluarans = TransaksiKas::where('kas_id', $id)->where('jenis', 'keluar')->orderByDesc('tanggal')->get();

        $total_pengeluaran = $pengeluarans->sum('jumlah');
        $total_pemasukan = TransaksiKas::where('kas_id', $id)->where('jenis', 'masuk')->sum('jumlah');

        $saldo_akhir = $total_pemasukan - $total_pengeluaran;

        return view('admin.kas.pengeluaranKas', compact('kas', 'pengeluarans', 'total_pengeluaran', 'saldo_akhir'));
    }









    // PROSES IURAN
    public function formTambahIuran(): view
    {
        $this->hanyaUntukAdmin();
        return view('admin.iuran.tambahIuran');
    }

    public function tambahIuran(Request $request)
    {
        $this->hanyaUntukAdmin();

        $request->validate([
            'nama_iuran' => 'required|string|max:225',
            'jumlah' => 'required|integer|min:500',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_iuran.required' => 'Nama Iuran wajib diisi.',
            'jumlah.required' => 'Nominal Iuran wajib diisi',
            'jumlah.min' => 'Nominal Minimal Rp. 500',
            'deskripsi.required' => 'Deskripsi Iuran Wajib Diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi',
            'tanggal_akhir.required' => 'Tanggal akhir wajib diisi',
        ]);

        KategoriIuran::create([
            'nama_iuran' => $request->nama_iuran,
            'jumlah' => $request->jumlah,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.kasiuran')->with('success', 'Iuran Berhasil Ditambahkan');
    }

    public function hapusIuran($id)
    {
        $this->hanyaUntukAdmin();

        $iuran = KategoriIuran::findOrFail($id);

        // if($iuran->transaksi()->exists()){
        //     return back()->with('error', 'Tidak bisa menghapus kas yang memiliki transaksi');
        // }

        $iuran->delete();

        return back()->with('success', 'Iuran berhasil dihapus');
    }


    // KELOLA IURAN

    public function kelolaIuran($id): View
    {
        $this->hanyaUntukAdmin();

        $warga = Warga::with(['user'])->get();

        $kategori = KategoriIuran::findOrFail($id);
        $transaksi = TransaksiIuran::where('kategori_iuran_id', $kategori->id)->with('warga')->get();

        return view('admin.iuran.kelolaIuran', compact('warga', 'kategori', 'transaksi'));
    }



    //KONFIRMASI IURAN WARGA


    public function konfirmasiIuran($iuran_id)
    {
        $this->hanyaUntukAdmin();

        $transaksi = TransaksiIuran::with(['warga', 'kategoriIuran'])->findOrFail($iuran_id);

        if($transaksi->status === 'terkonfirmasi'){
            return back()->with('info', 'Iuran sudah dikonfirmasi sebelumnya');
        }

        $transaksi->update([
            'status' => 'terkonfirmasi',
        ]);

        $jenis = 'masuk';

        $kas = Kas::latest()->take(1)->first();

        TransaksiKas::create([
            'kas_id' => $kas->id,
            'jenis' => $jenis,
            'jumlah' => $transaksi->kategoriIuran->jumlah,
            'keterangan' => 'Pembayaran Iuran oleh : ' . $transaksi->warga->nama,
            'tanggal' => now(),
        ]);


        $pemasukan = TransaksiKas::where('jenis', 'masuk')->sum('jumlah');


        $kas->saldo += $pemasukan;

        $kas->save();


        return back()->with('success', 'Iuran berhasil dikonfirmasi dan dicatat di kas.');
    }







    // BERITA

    public function berita(): View
    {
        $this->hanyaUntukAdmin();

        $beritas = Berita::latest()->get();
        return view('admin.berita.berita', compact('beritas'));
    }

    // DETAIL BERITA
    public function detailBerita($id)
    {
        $this->hanyaUntukAdmin();

        $berita = Berita::findOrFail($id);
        return view('admin.berita.detailBerita', compact('berita'));
    }

    public function formTambahBerita(): View
    {
        $this->hanyaUntukAdmin();
        return view('admin.berita.formTambahBerita');
    }

    public function tambahBerita(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'isi.required' => 'Isi berita wajib diisi',
        ]);

        $pathGambar = null;

        if($request->hasFile('gambar')){
            $pathGambar = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tanggal' => $request->tanggal,
            'gambar' => $pathGambar,
        ]);

        return redirect()->route('admin.berita')->with('success', 'Berita Berhasil Dibuat');
    }


    //EDIT MAU GA?


    public function hapusBerita($id)
    {
        $berita = Berita::findOrFail($id);
        $pathGambar = $berita->gambar;
        if($pathGambar){
            Storage::disk('public')->delete($pathGambar);
            $berita->delete();
        }

        $berita->delete();

        return redirect()->route('admin.berita')->with('success', 'Berita berhasil dihapus');
    }









    // PROSES SURAT
    public function surat(): View
    {
        $this->hanyaUntukAdmin();

        $surats = Surat::with('jenisSurat', 'warga')->latest()->get();

        return view('admin.surat.surat', compact('surats'));
    }
}
