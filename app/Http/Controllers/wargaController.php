<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


// MODEL
use App\Models\KartuKeluarga;
use App\Models\Warga;

use App\Models\Kas;
use App\Models\TransaksiKas;

use App\Models\KategoriIuran;
use App\Models\TransaksiIuran;

use App\Models\Berita;

use App\Models\JenisSurat;
use App\Models\Surat;
use App\Models\SuratSKCK;

use Illuminate\Http\RedirectResponse;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class wargaController extends Controller
{
    protected function hanyaUntukWarga()
    {
        if (!Auth::check() or Auth::user()?->role_id !== 2) {
            abort(403, 'Akses ditolak');
        }
    }

    public function dashboard(): View
    {
        $this->hanyaUntukWarga();

        $kas = Kas::all();
        $wargaId = Auth::user()->warga->id;

        $k_iurans = KategoriIuran::latest()->first();

        if ($k_iurans) {
            $transaksi = TransaksiIuran::where('kategori_iuran_id', $k_iurans->id)->where('warga_id', $wargaId)->first();
        } else {
            $transaksi = null;
        }

        $user = Auth::user();

        if($user->role->nama_role === 'warga'){
            $wargaId = $user->warga->id;

            if ($adaSuratDisetujui = Surat::where('warga_id', $wargaId)->where('status', 'disetujui')->exists())
                {
                    session()->flash('surat', 'Ada surat kamu yang sudah dikonfirmasi RT. Yuk cek sekarang.');
                };

            if ($adaIuranBaru = KategoriIuran::whereMonth('tanggal_mulai', now()->month)->whereYear('tanggal_mulai', now()->year)->exists())
                {
                    session()->flash('iuran', 'Ada iuran baru  yang harus kamu bayar, yuk bayar sekarang.');
                };

        }

        $beritas = Berita::latest()->get();
        return view('warga.dashboard', compact('kas', 'k_iurans', 'transaksi', 'beritas'));
    }


    // PROFILE
    public function profile(): View
    {
        $this->hanyaUntukWarga();

        $keluargas = Warga::where('kk_id', Auth::user()?->warga?->kk_id)->orderBy('status_keluarga', 'asc')->get();
        return view('warga.profile', compact('keluargas'));
    }




    // KAS & IURAN

    public function kasiuran(): View
    {
        $this->hanyaUntukWarga();

        $kas = Kas::all();


        // AMBIL IURAN BUAT WARGA

        $iuranNew = KategoriIuran::latest()->get();
        $riwayat = TransaksiIuran::where('warga_id', Auth::user()->warga->id)->get();

        return view('warga.kas.kasiuran', compact('kas', 'iuranNew', 'riwayat'));
    }

    //DETAIL KAS
    public function detailkas($id): View
    {
        $this->hanyaUntukWarga();

        $kas = Kas::findOrFail($id);


        $transaksis = TransaksiKas::where('kas_id', $id)->orderByDesc('tanggal')->get();

        $pemasukans = $transaksis->where('jenis', 'masuk');
        $pengeluarans = $transaksis->where('jenis', 'keluar');

        $total_masuk = $pemasukans->sum('jumlah');
        $total_keluar = $pengeluarans->sum('jumlah');

        $saldo_akhir = $total_masuk - $total_keluar;

        return view('warga.kas.detailkas', compact(
            'kas',
            'total_masuk',
            'total_keluar',
            'saldo_akhir'
        ));
    }


    public function pengeluaranKas($id): View
    {
        $this->hanyaUntukWarga();

        $kas = Kas::findOrFail($id);

        $transaksis = TransaksiKas::where('kas_id', $id)->orderByDesc('tanggal')->get();

        $pemasukans = $transaksis->where('jenis', 'masuk');
        $pengeluarans = $transaksis->where('jenis', 'keluar');

        $total_masuk = $pemasukans->sum('jumlah');
        $total_keluar = $pengeluarans->sum('jumlah');

        $saldo_akhir = $total_masuk - $total_keluar;

        return view('warga.kas.pengeluaranKas', compact(
            'kas',
            'transaksis',
            'total_masuk',
            'total_keluar',
            'saldo_akhir',
        ));
    }




    // BAYAR IURAN
    public function formBayarIuran($id){
        $this->hanyaUntukWarga();

        $iuran = KategoriIuran::findOrFail($id);

        return view('warga.iuran.bayarIuran', compact('iuran'));
    }


    // public function bayarIuran(Request $request)
    public function bayarIuran(Request $request, $id)
    {
        $this->hanyaUntukWarga();

        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $pathBukti = $request->file('bukti_bayar')->store('bukti_bayar_iuran', 'public');

        TransaksiIuran::create([
            'kategori_iuran_id' => $request->id,
            'warga_id' => $request->warga_id,
            'jumlah_bayar' => $request->jumlah,
            'tanggal_bayar' => now(),
            'status' => 'pending',
            'bukti_bayar' => $pathBukti //$pathBukti,
        ]);

        return redirect()->back()->with('success', 'Bukti bayar telah dikirim, tunggu konfirmasi dari RT.');
    }








    // BERITA WARGA

    public function berita(): View
    {
        $this->hanyaUntukWarga();

        $beritas = Berita::latest()->get();
        return view('warga.berita.berita', compact('beritas'));
    }

    // DETAIL BERITA
    public function detailBerita($id)
    {
        $this->hanyaUntukWarga();

        $berita = Berita::findOrFail($id);
        return view('warga.berita.detailBerita', compact('berita'));
    }



    // SURAT WARGA
    public function surat(): view
    {
        $this->hanyaUntukWarga();

        $warga = Auth::user()->warga;

        $riwayat_surat = Surat::with('jenisSurat')->where('warga_id', $warga->id)->latest()->get();

        return view('warga.surat.surat', compact('riwayat_surat'));
    }

    public function detailSurat($id)
    {
        $surat = Surat::with('warga', 'jenisSurat', 'skck')->findOrFail($id);

        return view('warga.surat.detailSurat', compact('surat'));
    }


    public function ajukanSkck(Request $request)
    {
        $this->hanyaUntukWarga();

        $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:20',
            'alamat' => 'required|string',
            'keperluan' => 'required|string|max:255',
            'tujuan_skck' => 'nullable|string|max:255',
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
        ]);

        $warga = Auth::user()->warga;

        $surat = Surat::create([
            'jenis_surat_id' => $request->jenis_surat_id,
            'warga_id' => $warga->id,
            'status' => 'diproses',
        ]);

        SuratSKCK::create([
            'surat_id' => $surat->id,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'keperluan' => $request->keperluan,
            'tujuan_skck' => $request->tujuan_skck,
        ]);

        return redirect()->back()->with('success', 'Pengajuan surat SKCK berhasil dikirim.');
    }
}
