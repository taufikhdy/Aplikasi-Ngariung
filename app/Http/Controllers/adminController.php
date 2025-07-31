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

        $user = Auth::user();

        if ($user->role->nama_role === 'rt') {

            if (Surat::where('status', 'diproses')->exists()) {
                session()->flash('surat', 'Ada surat baru dari warga yang perlu dikonfirmasi');
            };

            if (TransaksiIuran::where('status', 'pending')->exists()) {
                session()->flash('iuran', 'Ada transaksi iuran dari warga yang perlu dikonfirmasi');
            };
        }

        return view('admin.dashboard', compact('kas', 'k_iuran', 'beritas'));
    }


    //Profile
    public function profile(): View
    {
        $this->hanyaUntukAdmin();
        $keluargas = Warga::where('kk_id', Auth::user()?->warga?->kk_id)->orderBy('status_keluarga', 'asc')->get();
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
            // 'kk_id' => 'required|exists:kartu_keluarga,id',
            'nik' => 'required|numeric|unique:warga,nik',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required|string',
            'status_keluarga' => 'required|string',
            'telepon' => 'required|string'
        ]);

        if ($request->filled('kk_id')) {
            $kkId = $request->kk_id;
        } else {
            $request->validate([
                'nomor_kk' => 'required|unique:kartu_keluarga,no_kk',
                'alamat' => 'required|string',
                'rt' => 'required|numeric',
                'rw' => 'required|numeric'
            ]);

            $kk = KartuKeluarga::create([
                'no_kk' => $request->nomor_kk,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
            ]);


            $kkId = $kk->id;
        }

        $warga = Warga::create([
            'kk_id' => $kkId,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'status_perkawinan' => $request->status_perkawinan,
            'status_keluarga' => $request->status_keluarga,
            'telepon' => $request->telepon,
        ]);

        User::create([
            'nik' => $warga->nik,
            'password' => Hash::make('password123'),
            'warga_id' => $warga->id,
            'role_id' => 2,
        ]);

        return redirect()->route('admin.dataWarga')->with('success', 'Data Warga berhasil ditambahkan.');
    }

    public function resetSandi($id)
    {
        $user = User::where('warga_id', $id)->first();

        if ($user) {
            $user->password = Hash::make('password123');
            $user->save();

            return redirect()->back()->with('success', 'Kata sandi warga berhasil direset');
        }

        return redirect()->back()->with('with', 'Akun tidak ditemukan');
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


    public function hapuswarga($id)
    {
        User::where('warga_id', $id)->delete();
        Warga::findOrFail($id)->delete();
        return redirect()->route('admin.dataWarga')->with('success', 'Data warga berhasil dihapus');
    }







    // KAS

    public function kasiuran(): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::all();
        $k_iurans = KategoriIuran::latest()->get(); //latest

        return view('admin.kas.kasiuran', compact('kas', 'k_iurans'));
    }





    //DETAIL KAS
    public function detailkas($id): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::findOrFail($id);


        $transaksis = TransaksiKas::where('kas_id', $id)->orderByDesc('tanggal')->get();

        $pemasukans = $transaksis->where('jenis', 'masuk');
        $pengeluarans = $transaksis->where('jenis', 'keluar');

        $total_masuk = $pemasukans->sum('jumlah');
        $total_keluar = $pengeluarans->sum('jumlah');

        $saldo_akhir = $total_masuk - $total_keluar;

        return view('admin.kas.detailkas', compact(
            'kas',
            'total_masuk',
            'total_keluar',
            'saldo_akhir'
        ));
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

        if ($kas->transaksi()->exists()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus kas yang memiliki transaksi. Silahkan cek kembali data transaksi terlebih dahulu.');
        }

        $kas->delete();

        return redirect()->back()->with('success', 'Kas berhasil dihapus');
    }


    public function hapusRiwayatKas()
    {
        TransaksiKas::whereNotNull('id')->delete();

        return redirect()->route('admin.kasiuran')->with('success', 'Semua riwayat transaksi berhasil dihapus.');
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
            'keterangan' => 'nullable|string',
            'bukti_transaksi' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pathBukti = $request->file('bukti_transaksi')->store('bukti_transaksi_kas', 'public');

        $kas = Kas::findOrFail($request->kas_id);

        TransaksiKas::create([
            'kas_id' => $request->kas_id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'bukti_transaksi' => $pathBukti
        ]);

        if ($request->jenis === 'masuk') {
            $kas->saldo += $request->jumlah;
        } elseif ($request->jenis === 'keluar') {
            $kas->saldo -= $request->jumlah;
        }

        $kas->save();


        // return redirect()->route('admin.kelolaKas', ['id' => $kas->id]);
        return redirect()->route('admin.kasiuran')->with('success', 'Berhasil menambahkan transaksi.');
    }



    //TRANSAKSI / DATA PENGELUARAN KEUANGAN
    public function pengeluaranKas($id): View
    {
        $this->hanyaUntukAdmin();

        $kas = Kas::findOrFail($id);

        $transaksis = TransaksiKas::where('kas_id', $id)->latest()->orderByDesc('tanggal')->get();

        $pemasukans = $transaksis->where('jenis', 'masuk');
        $pengeluarans = $transaksis->where('jenis', 'keluar');

        $total_masuk = $pemasukans->sum('jumlah');
        $total_keluar = $pengeluarans->sum('jumlah');

        $saldo_akhir = $total_masuk - $total_keluar;

        return view('admin.kas.pengeluaranKas', compact(
            'kas',
            'transaksis',
            'total_masuk',
            'total_keluar',
            'saldo_akhir',
        ));
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

            'jenis' => 'required|in:kk,perorangan', // jenis iuran

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

        $buatIuran = KategoriIuran::create([
            'nama_iuran' => $request->nama_iuran,
            'jumlah' => $request->jumlah,

            'jenis' => $request->jenis,

            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'deskripsi' => $request->deskripsi,
        ]);

        // if ($buatIuran->jenis === 'kk'){
        //     $kks = KartuKeluarga::all();
        //         foreach($kks as $kk){
        //             TransaksiIuran::create([
        //                 'kategori_iuran_id' => $buatIuran->id,
        //                 'kartu_keluarga_id' => $kk->id,
        //                 'status' => 'pending',
        //             ]);
        //         }
        // } else if ($buatIuran->jenis === 'perorangan'){
        //     $wargas = Warga::all();
        //         foreach($wargas as $warga){
        //             TransaksiIuran::create([
        //                 'kategori_iuran_id' => $buatIuran->id,
        //                 'warga_id' => $warga->id,
        //                 'status_pending',
        //             ]);
        //         }
        // }

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

        // $warga = Warga::with(['user'])->get();

        // $kategori = KategoriIuran::findOrFail($id);
        // $transaksi = TransaksiIuran::where('kategori_iuran_id', $kategori->id)->with('kategoriIuran', 'warga', 'kk')->get();

        // return view('admin.iuran.kelolaIuran', compact('kategori', 'transaksi'));

        $kategori = KategoriIuran::findOrFail($id);

        if ($kategori->jenis === 'kk'){
            $transaksi = TransaksiIuran::where('kategori_iuran_id', $kategori->id)->with('kk')->latest()->get();
        } else if ($kategori->jenis === 'perorangan'){
            $transaksi = TransaksiIuran::where('kategori_iuran_id', $kategori->id)->with('warga')->latest()->get();
        }

        return view('admin.iuran.kelolaIuran', compact(
            'kategori',
            'transaksi'
        ));
    }




    //KONFIRMASI IURAN WARGA

    public function konfirmasiIuran(Request $request, $iuran_id)
    {
        $this->hanyaUntukAdmin();

        // $transaksi = TransaksiIuran::with(['warga', 'kategoriIuran'])->findOrFail($iuran_id);

        // if ($transaksi->status === 'terkonfirmasi') {
        //     return back()->with('info', 'Iuran sudah dikonfirmasi sebelumnya');
        // }

        // // REVISI BISA PER ORANGAN ATAU PER KK

        // if($transaksi->kategoriIuran->jenis === 'kk'){

        //     TransaksiIuran::where('kartu_keluarga_id', $transaksi->kartu_keluarga_id)->where('kategori_iuran_id', $transaksi->kategoriIuran->id)->update([
        //         'jumlah_bayar' => $transaksi->kategoriIuran->jumlah,
        //         'status' => 'terkonfirmasi',
        //     ]);
        // }

        // else if($transaksi->kategoriIuran->jenis === 'perorangan') {
        //     $transaksi->update([
        //         'jumlah_bayar' => $transaksi->kategoriIuran->jumlah,
        //         'status' => 'terkonfirmasi',
        //     ]);
        // };


        // $kas = Kas::latest()->first();

        // $uang = TransaksiKas::create([
        //     'kas_id' => $kas->id,
        //     'jenis' => 'masuk',
        //     'jumlah' => $transaksi->kategoriIuran->jumlah,
        //     'keterangan' => 'Transaksi Masuk Dari ' . $transaksi->kategoriIuran->nama_iuran, // NAMA WARGA MASUK DARI SINI //REVISI GANTI NAMA IURAN AJA
        //     'tanggal' => now(),

        //     //BUKTI HARUS MASUK KE PENGELUARAN
        //     'bukti_transaksi' => $request->bukti_bayar //MASIH SALAH BELUM ADA PATH
        // ]);


        // $pemasukan = $uang->jumlah;

        // $kas->saldo += $pemasukan;

        // $kas->save();

        // TransaksiIuran::where('id', $iuran_id)->update([
        //     'status' => 'terkonfirmasi',
        //     'tanggal_bayar' => now(),
        // ]);



        $transaksi = TransaksiIuran::with('kategoriIuran')->findOrFail($iuran_id);
        $transaksi->status = 'terkonfirmasi';
        $transaksi->save();

        $kas = Kas::latest()->first();

        $uangKas = TransaksiKas::create([
            'kas_id' => $kas->id,
            'jenis' => 'masuk',
            'jumlah' => $transaksi->kategoriIuran->jumlah,
            'keterangan' => 'Transaksi masuk dari ' . $transaksi->kategoriIuran->nama_iuran,
            'tanggal' => now()
        ]);

        $pemasukanKas = $uangKas->jumlah;

        $kas->saldo += $pemasukanKas;

        $kas->save();


        return back()->with('success', 'Iuran berhasil dikonfirmasi dan dicatat di kas.');
    }



    // DETAIL IURAN
    public function detailIuran($id): View
    {
        $this->hanyaUntukAdmin();

        $iuran = KategoriIuran::findOrFail($id);
        $semuaRiwayat = TransaksiIuran::with('warga', 'kategoriIuran', 'kk')->where('kategori_iuran_id', $iuran->id)->where('status', 'terkonfirmasi')->latest()->get();

        $total_warga = Warga::count();
        // $kategoriIuran = KategoriIuran::findOrFail($id)->first();

        $sudah_bayar = TransaksiIuran::where('kategori_iuran_id', $id)->count(); //buat berapa orang
        $total_masuk = TransaksiIuran::where('kategori_iuran_id', $id)->sum('jumlah_bayar');

        $target = $total_warga * $iuran->jumlah;

        return view('admin.iuran.detailIuran', compact(
            'iuran',
            'semuaRiwayat',
            'total_warga',
            'sudah_bayar',
            'total_masuk',
            'target'
        ));
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

        if ($request->hasFile('gambar')) {
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
        if ($pathGambar) {
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

        $surats = Surat::with('jenisSurat', 'warga')
            ->orderByRaw("status = 'diproses' DESC")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.surat.surat', compact('surats'));
    }


    public function detailSurat($id)
    {
        $surat = Surat::with('warga', 'jenisSurat', 'skck')->findOrFail($id);

        return view('admin.surat.detailSurat', compact('surat'));
    }

    public function setujuiSurat($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->status = 'disetujui';
        $surat->save();

        return redirect()->back()->with('success', 'Surat disetujui.');
    }

    public function tolakSurat(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        $surat->status = 'ditolak';
        $surat->keterangan = $request->alasan;
        $surat->save();

        return redirect()->back()->with('success', 'Surat ditolak.');
    }
}
