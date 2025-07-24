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
        $beritas = Berita::latest()->get();
        return view('warga.dashboard', compact('kas', 'k_iurans', 'transaksi', 'beritas'));
    }


    // PROFILE
    public function profile(): View
    {
        $this->hanyaUntukWarga();

        $keluargas = Warga::where('kk_id', Auth::user()?->warga?->kk_id)->get();
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
        return view('warga.kas.detailkas', compact('kas'));
    }


    public function pengeluaranKas($id): View
    {
        $this->hanyaUntukWarga();

        $kas = Kas::findOrFail($id);
        $pengeluarans = TransaksiKas::where('kas_id', $id)->where('jenis', 'keluar')->orderByDesc('tanggal')->get();

        $total_pengeluaran = $pengeluarans->sum('jumlah');
        $total_pemasukan = TransaksiKas::where('kas_id', $id)->where('jenis', 'masuk')->sum('jumlah');

        $saldo_akhir = $total_pemasukan - $total_pengeluaran;

        return view('warga.kas.pengeluaranKas', compact('kas', 'pengeluarans', 'total_pengeluaran', 'saldo_akhir'));
    }




    // BAYAR IURAN

    // public function bayarIuran(Request $request)
    public function bayarIuran(Request $request)
    {
        $this->hanyaUntukWarga();

        // $request->validate([
        //     'kategori_iuran_id' => 'required|exists:kategori_iuran,id',
        //     // 'jumlah' => 'required|numeric|min:1',
        //     // 'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        // ]);

        // $pathBukti = $request->file('bukti_bayar')->store('bukti_iuran', 'public');

        TransaksiIuran::create([
            'kategori_iuran_id' => $request->id,
            'warga_id' => Auth::user()->warga->id,
            'jumlah_bayar' => $request->jumlah,
            'tanggal_bayar' => now(),
            'status' => 'pending',
            'bukti_bayar' => null //$pathBukti,
        ]);

        return back()->with('success', 'Bukti bayar telah dikirim, tunggu konfirmasi dari RT.');
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

        return view('warga.surat.surat');
    }
}
