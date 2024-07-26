<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    protected $id_keluarga;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id_keluarga = Auth::user()->id_keluarga;
            return $next($request);
        });
    }

    public function index()
    {
        $kategori = Kategori::getKategori($this->id_keluarga);
        $title = 'Data Kategori';
        return view('Master.Kategori', compact('kategori', 'title'));
    }

    public function tambah_kategori(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required'
        ]);

        $result = Kategori::createKategori($validatedData, $this->id_keluarga);

        if ($result) {
            return redirect()->route('Kategori.index')->with('sukses', 'menambahkan kategori.');
        } else {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan kategori.');
        }
    }

    public function ubah_kategori(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required'
        ]);

        try {
            $result = Kategori::updateKategori($id, $this->id_keluarga, $validatedData);

            if ($result) {
                return redirect()->route('Kategori.index')->with('sukses', 'Kategori berhasil diperbarui.');
            } else {
                Log::error('Gagal.', ['exception' => $e]);
                return redirect()->back()->with('gagal', 'Kategori tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Kategori tidak ditemukan.');
        } catch (\Exception $e) {
            // Handle other exceptions if necessary
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui kategori.');
        }
    }

    public function hapus_kategori($id)
    {
        $result = Kategori::deleteKategori($this->id_keluarga, $id);

        if ($result) {
            return redirect()->route('Kategori.index')->with('sukses', 'menghapus kategori.');
        } else {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Gagal menghapus kategori.');
        }
    }
}
