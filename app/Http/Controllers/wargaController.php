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

use App\Models\JamOperasional;

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

    public function dashboard(): view
    {
        $this->hanyaUntukWarga();

        $kas = Kas::all();
        $warga = Auth::user()->warga;
        $kkId = Auth::user()->warga->kk_id;

        // $iuranNew = KategoriIuran::latest()->first();


        // PEMBATASAN IURAN PER DATA WARGA DIBUAT
        $tanggalMasukWarga = $warga->created_at;
        $tanggalMasukKK = $warga->KartuKeluarga->created_at ?? $tanggalMasukWarga;

        $iuranPerorang = KategoriIuran::where('jenis', 'perorangan')->where('created_at', '>=', $tanggalMasukWarga)->orderBy('created_at', 'desc')->latest()->first(); //take(1)->get();

        $iuranPerKK = KategoriIuran::where('jenis', 'kk')->where('created_at', '>=', $tanggalMasukKK)->orderBy('created_at', 'desc')->latest()->first(); //->take(1)->get();

        // if ($iuranNew) {
        //     if ($iuranNew->jenis === 'kk') {
        //         $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranNew->id)->where('kartu_keluarga_id', $kkId)->latest()->first();
        //     } else if ($iuranNew->jenis === 'perorangan') {
        //         $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranNew->id)->where('warga_id', $wargaId)->latest()->first();
        //     }

        // $iurans = $iuranPerorang->merge($iuranPerKK)->sortByDesc('created_at')->values();

        $iurans = []; //deklarasi untuk nyimpen data transaksi


        $transaksi = '';
        // if ($iurans) {


        if ($iuranPerKK) {
            // $idKK = $iuranPerKK->first();
            $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranPerKK->id)->where('kartu_keluarga_id', $kkId)
                ->latest()->first();

            // if ($transaksi) {
            //     $iurans->setAttribute('status_bayar', $transaksi->status);
            // } else {
            //     $iurans->setAttribute('status_bayar', 'pending');
            // }
            // INI TADINYA KALO COLLECTION DARI HASIL MERGE


            if ($transaksi) {
                $iuranPerKK->status_bayar = $transaksi->status;
            }else{
                $iuranPerKK->status_bayar = 'pending';
            }

            $iurans[] = $iuranPerKK;
        } else if ($iuranPerorang) {
            // $idWarga = $iuranPerorang->first();
            $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranPerorang->id)->where('warga_id', $warga->id)
                ->latest()->first();

            if ($transaksi) {
                $iuranPerorang->status_bayar = $transaksi->status;
            }else{
                $iuranPerorang->status_bayar = 'pending';
            }

            $iurans[] = $iuranPerorang;
        }

        // } INI PENUTUP IF $IURANS

        $user = Auth::user();

        if ($user->role->nama_role === 'warga') {
            $wargaId = $user->warga->id;

            if ($adaSuratDisetujui = Surat::where('warga_id', $wargaId)->where('status', 'disetujui')->exists()) {
                session()->flash('surat', 'Ada surat kamu yang sudah dikonfirmasi RT. Yuk cek sekarang.');
            };

            $adaIuranBaru = KategoriIuran::where('created_at', '>=', $tanggalMasukWarga)->whereMonth('tanggal_mulai', now()->month)->whereYear('tanggal_mulai', now()->year)->exists();

            if ($adaIuranBaru) {
                session()->flash('iuran', 'Ada iuran baru  yang harus kamu bayar, yuk bayar sekarang.');
            };
        }



        // Jam Operasional

        $hariIni = now()->locale('id')->isoFormat('dddd');

        $jam = JamOperasional::where('hari', $hariIni)->first();

        // jam

        $beritas = Berita::latest()->get();
        return view('warga.dashboard', compact('kas', 'iurans', 'jam', 'transaksi', 'beritas'));
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

        $warga = Auth::user()->warga;
        $kkId = $warga->kk_id;


        // AMBIL IURAN BUAT WARGA

        // $iuranNew = KategoriIuran::latest()->get();


        // foreach ($iuranNew as $iuran) {
        //     $transaksi = null;

        //     if ($iuran->jenis === 'kk') {
        //         $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuran->id)->where('kartu_keluarga_id', $kkId)
        //             ->latest()->first();
        //     } else if ($iuran->jenis === 'perorangan') {
        //         $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuran->id)->where('warga_id', $warga->id)
        //             ->latest()->first();
        //     }

        //     if ($transaksi) {
        //         $iuran->status_bayar = $transaksi->status;
        //     } else {
        //         $iuran->status_bayar = 'pending';
        //     }
        // }

        // PEMBATASAN IURAN PER DATA WARGA DIBUAT
        $tanggalMasukWarga = $warga->created_at;
        $tanggalMasukKK = $warga->KartuKeluarga->created_at ?? $tanggalMasukWarga;

        $iuranPerorangs = KategoriIuran::where('jenis', 'perorangan')->where('created_at', '>=', $tanggalMasukWarga)->orderBy('created_at', 'desc')->latest()->get(); //take(1)->get();

        $iuranPerKKs = KategoriIuran::where('jenis', 'kk')->where('created_at', '>=', $tanggalMasukKK)->orderBy('created_at', 'desc')->latest()->get(); //->take(1)->get();

        // if ($iuranNew) {
        //     if ($iuranNew->jenis === 'kk') {
        //         $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranNew->id)->where('kartu_keluarga_id', $kkId)->latest()->first();
        //     } else if ($iuranNew->jenis === 'perorangan') {
        //         $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranNew->id)->where('warga_id', $wargaId)->latest()->first();
        //     }

        // $iurans = $iuranPerorang->merge($iuranPerKK)->sortByDesc('created_at')->values();

        $iuranNew = []; //deklarasi untuk nyimpen data transaksi


        $transaksi = '';
        // if ($New) {


        foreach ($iuranPerKKs as $iuranPerKK) {
            // $idKK = $iuranPerKK->first();
            $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranPerKK->id)->where('kartu_keluarga_id', $kkId)
                ->latest()->first();

            // if ($transaksi) {
            //     $New->setAttribute('status_bayar', $transaksi->status);
            // } else {
            //     $iurans->setAttribute('status_bayar', 'pending');
            // }
            // INI TADINYA KALO COLLECTION DARI HASIL MERGE


            if ($transaksi) {
                $iuranPerKK->status_bayar = $transaksi->status;
            }else{
                $iuranPerKK->status_bayar = 'pending';
            }

            $iuranNew[] = $iuranPerKK;
        }

        foreach ($iuranPerorangs as $iuranPerorang) {
            // $idWarga = $iuranPerorang->first();
            $transaksi = TransaksiIuran::where('kategori_iuran_id', $iuranPerorang->id)->where('warga_id', $warga->id)
                ->latest()->first();

            if ($transaksi) {
                $iuranPerorang->status_bayar = $transaksi->status;
            }else{
                $iuranPerorang->status_bayar = 'pending';
            }

            $iuranNew[] = $iuranPerorang;

        }

        // $riwayat = TransaksiIuran::where('warga_id', $warga->id)->orWhere('kartu_keluarga_id', $warga->kk_id)->get();

        return view('warga.kas.kasiuran', compact('kas', 'iuranNew'));
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

        $transaksis = TransaksiKas::where('kas_id', $id)->latest()->orderByDesc('tanggal')->get();

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
    public function formBayarIuran($id)
    {
        $this->hanyaUntukWarga();

        $iuran = KategoriIuran::findOrFail($id);

        return view('warga.iuran.bayarIuran', compact('iuran'));
    }




    // public function bayarIuran(Request $request)
    public function bayarIuran(Request $request, $id)
    {
        $this->hanyaUntukWarga();

        // $user = Auth::user();
        // $warga = Warga::find($user->warga_id); //Cari di tabel user kolom warga_id samakan dengan tabel warga
        // $kategori = KategoriIuran::findOrFail($id);
        // // $warga = Auth::user()->warga;


        // if ($kategori->jenis === 'kk') {
        //     $bayar = TransaksiIuran::where('kategori_iuran_id', $id)->where('kartu_keluarga_id', $warga->kk_id)->first();
        // } else if ($kategori->jenis === 'perorangan') {
        //     $bayar = TransaksiIuran::where('kategori_iuran_id', $id)->where('warga_id', $warga->id)->first();
        // }


        // if ($bayar && $bayar->status === 'pending') {
        //     $data = [
        //         'status' => 'pending',
        //         'tanggal_bayar' => now()
        //     ];

        //     if ($request->hasFile('bukti_bayar')) {
        //         // $file = $request->file('bukti_bayar');
        //         // $path = $file->store('bukti_bayar_iuran', 'public');
        //         // $data['bukti_bayar'] = $path;

        //         $data['bukti_bayar'] = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        //     }

        //     $bayar->update($data);

        //     return redirect()->back()->with('success', 'Pembayaran menunggu konfirmasi');
        // }

        // return redirect()->back()->with('error', 'Iuran sudah pernah dibayar');

        $iuran = KategoriIuran::findOrFail($id);

        $warga = Auth::user()->warga;

        $request->validate([
            // 'warga_id' => 'required|exists:warga,id',

            // 'kartu_keluarga_id' => 'required|exists:kartu_keluarga,id',

            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $pathBukti = $request->file('bukti_bayar')->store('bukti_bayar_iuran', 'public');


        // if ($kategori->jenis === 'kk'){
        //     $sudahBayar = TransaksiIuran::where('kategori_iuran_id', $kategori->id)->where('kartu_keluarga_id', $warga->kk_id)->whereIn('status', ['pending', 'terkonfirmasi'])->exists();
        // } else {
        //     $sudahBayar = TransaksiIuran::where('kategori_iuran_id', $kategori->id)->where('warga_id', $warga->id)->whereIn('status', ['pending', 'terkonfirmasi'])->exists();
        // }

        // if ($sudahBayar) {
        //     return redirect()->back()->with('success', 'Iuran ini sudah dibayar atau menunggu konfirmasi');
        // }

        $data = [
            'kategori_iuran_id' => $iuran->id,
            'kartu_keluarga_id' => $warga->kk_id,
            'jumlah_bayar' => $iuran->jumlah,
            'tanggal_bayar' => now(),
            'status' => 'pending',
            'bukti_bayar' => $pathBukti
        ];

        // TransaksiIuran::create([
        //     'kategori_iuran_id' => $id, // ini dari kategori iuran
        //     'warga_id' => $iuran->jenis === 'perorangan' ? $warga->id : null,

        //     'kartu_keluarga_id' => $warga->kk_id,

        //     'jumlah_bayar' => null, //ini kosong terisi jika dikonfirmasi RT nilai diambil di RT
        //     'tanggal_bayar' => now(),
        //     'status' => 'pending',
        //     'bukti_bayar' => $pathBukti //$pathBukti,
        // ]);

        if ($iuran->jenis === 'perorangan') {
            $data['warga_id'] = $warga->id;
        }

        // JADI KALO PER KK ID WARGA JADI NULL
        TransaksiIuran::create($data);

        return redirect()->route('warga.kasiuran')->with('success', 'Bukti bayar telah dikirim, tunggu konfirmasi dari RT.');
    }



    // DETAIL IURAN
    public function detailIuran($id): View
    {
        $this->hanyaUntukWarga();

        $iuran = KategoriIuran::findOrFail($id);
        $riwayat = TransaksiIuran::with('kategoriIuran')->where('kategori_iuran_id', $id)->where('warga_id', Auth::user()->warga->id)->first();

        $total_warga = Warga::count();
        // $kategoriIuran = KategoriIuran::findOrFail($id)->first();

        $sudah_bayar = TransaksiIuran::where('kategori_iuran_id', $id)->where('status', 'terkonfirmasi')->count(); //buat berapa orang
        $total_masuk = TransaksiIuran::where('kategori_iuran_id', $id)->sum('jumlah_bayar');

        $target = $total_warga * $iuran->jumlah;

        return view('warga.iuran.detailIuran', compact(
            'iuran',
            'riwayat',
            'total_warga',
            'sudah_bayar',
            'total_masuk',
            'target'
        ));
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

        return view('warga.surat.surat', compact('warga', 'riwayat_surat'));
    }

    public function detailSurat($id)
    {

        $surat = Surat::with('warga', 'jenisSurat', 'skck')->findOrFail($id);

        if (Auth::user()?->warga->id !== $surat->warga->id) {
            abort(403, 'Akses ditolak');
        }

        return view('warga.surat.detailSurat', compact('surat'));
    }


    public function ajukanSkck(Request $request)
    {
        $this->hanyaUntukWarga();

        $request->validate([
            // 'nama' => 'required|string|max:100',
            // 'nik' => 'required|string|max:20',
            // 'alamat' => 'required|string',
            // 'keperluan' => 'required|string|max:255',
            // 'tujuan_skck' => 'nullable|string|max:255',
            // 'jenis_surat_id' => 'required|exists:jenis_surat,id',
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


    // Jam operasional

    public function jamOperasional(){
        $jams = JamOperasional::all();

        return view('warga.jam.jamOperasional', compact('jams'));
    }
}
