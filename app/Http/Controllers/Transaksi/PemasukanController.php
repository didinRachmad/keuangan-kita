<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Akun;
use App\Models\Master\Kategori;
use App\Models\Transaksi\Pemasukan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PemasukanController extends Controller
{
    protected $id_user;
    protected $id_keluarga;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id_user = Auth::user()->id;
            $this->id_keluarga = Auth::user()->id_keluarga;
            return $next($request);
        });
    }

    public function index()
    {
        $bulan = session('bulanPenjualan', date('n'));
        $tahun = session('tahunPenjualan', date('Y'));

        $pemasukan = Pemasukan::getPemasukan($this->id_keluarga, $bulan, $tahun);
        // return response()->json($pemasukan);

        return view('Transaksi.Pemasukan', [
            'title' => 'Data Pemasukan',
            'pemasukan' => $pemasukan
        ]);
    }

    public function cari_pemasukan(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        Session::put('bulanPenjualan', $bulan);
        Session::put('tahunPenjualan', $tahun);

        return redirect()->route('Pemasukan.index');
    }

    public function tambah_pemasukan(Request $request)
    {
        $saldoAwal = str_replace('.', '', $request->input('total_transaksi'));
        $request->merge(['total_transaksi' => $saldoAwal]);
        $validatedData = $request->validate([
            'keterangan' => 'required',
            'tgl_transaksi' => 'required|date',
            'id_kategori' => 'required|integer',
            'id_akun' => 'required|integer',
            'id_pj' => 'required|integer',
            'total_transaksi' => 'required|numeric'
        ]);

        try {
            $result = Pemasukan::createPemasukan($validatedData, $this->id_user, $this->id_keluarga);

            if ($result) {
                return redirect()->route('Pemasukan.index')->with('sukses', 'menambahkan pemasukan.');
            } else {
                return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan pemasukan.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'pemasukan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan pemasukan.');
        }
    }

    public function getKategori(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Kategori::select('id', 'nama', 'jenis')->where('id_keluarga', $this->id_keluarga)->where('jenis', 'PEMASUKAN')->where('nama', 'LIKE', '%' . $term . '%')
            ->groupBy('jenis', 'nama', 'id')
            ->orderBy('nama', 'desc');

        $kategori = $query->paginate($perPage, ['*'], 'page', $page);

        $results = [];

        foreach ($kategori as $data) {
            $results[] = [
                'id' => $data->id,
                'text' => $data->nama,
                'jenis' => $data->jenis,
            ];
        }

        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $kategori->hasMorePages(),
            ],
        ];

        return response()->json($response);
    }

    public function getAkun(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Akun::select('id', 'nama', 'jenis')->where('id_keluarga', $this->id_keluarga)->where('nama', 'LIKE', '%' . $term . '%')
            ->groupBy('jenis', 'nama', 'id')
            ->orderBy('nama');

        $akun = $query->paginate($perPage, ['*'], 'page', $page);

        $results = [];

        foreach ($akun as $data) {
            $results[] = [
                'id' => $data->id,
                'text' => $data->nama,
                'jenis' => $data->jenis,
            ];
        }

        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $akun->hasMorePages(),
            ],
        ];

        return response()->json($response);
    }

    public function getPJ(Request $request)
    {
        $term = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        if (Gate::allows('role-admin')) {
            $query = User::where('id_keluarga', $this->id_keluarga)->where('name', 'LIKE', '%' . $term . '%')
                ->orderBy('name', 'desc');
        } else {
            $query = User::where('id_keluarga', $this->id_keluarga)->where('id', Auth::user()->id)->where('name', 'LIKE', '%' . $term . '%')
                ->orderBy('name', 'desc');
        }

        $pj = $query->paginate($perPage, ['*'], 'page', $page);

        $results = [];

        foreach ($pj as $data) {
            $results[] = [
                'id' => $data->id,
                'text' => $data->name . " (" . $data->hubungan . ")",
            ];
        }

        $response = [
            'results' => $results,
            'pagination' => [
                'more' => $pj->hasMorePages(),
            ],
        ];

        return response()->json($response);
    }

    public function ubah_pemasukan(Request $request, $id)
    {
        $saldoAwal = str_replace('.', '', $request->input('total_transaksi'));
        $request->merge(['total_transaksi' => $saldoAwal]);
        $tgl_transaksi = date('Y-m-d', strtotime($request->input('tgl_transaksi')));
        $request->merge(['tgl_transaksi' => $tgl_transaksi]);
        $validatedData = $request->validate([
            'keterangan' => 'required',
            'tgl_transaksi' => 'required|date',
            'id_kategori' => 'required|integer',
            'id_akun' => 'required|integer',
            'id_pj' => 'required|integer',
            'total_transaksi' => 'required|numeric'
        ]);
        try {
            $result = Pemasukan::updatePemasukan($id, $this->id_keluarga, $validatedData);

            if ($result) {
                return redirect()->route('Pemasukan.index')->with('sukses', 'Pemasukan berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Pemasukan tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'pemasukan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui pemasukan.');
        }
    }

    public function hapus_pemasukan($id)
    {
        try {
            $result = Pemasukan::deletePemasukan($this->id_keluarga, $id);

            if ($result) {
                return redirect()->route('Pemasukan.index')->with('sukses', 'menghapus pemasukan.');
            } else {
                return redirect()->back()->with('gagal', 'Gagal menghapus pemasukan.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'pemasukan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menghapus pemasukan.');
        }
    }
}
