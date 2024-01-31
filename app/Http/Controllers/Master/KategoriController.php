<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $kategori = Kategori::getKategori($userId);
        $title = 'Data Kategori';
        return view('Master.Kategori', compact('kategori', 'title'));
    }

    public function tambah_kategori(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required'
        ]);

        $user_id = Auth::id();
        $result = Kategori::createKategori($validatedData, $user_id);

        if ($result) {
            return redirect()->route('Kategori.index')->with('sukses', 'menambahkan kategori.');
        } else {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan kategori.');
        }
    }

    public function ubah_kategori(Request $request, $id)
    {
        $user_id = Auth::id();
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required'
        ]);

        try {
            $result = Kategori::updateKategori($id, $user_id, $validatedData);

            if ($result) {
                return redirect()->route('Kategori.index')->with('sukses', 'Kategori berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Kategori tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('gagal', 'Kategori tidak ditemukan.');
        } catch (\Exception $e) {
            // Handle other exceptions if necessary
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui kategori.');
        }
    }

    public function hapus_kategori($id)
    {
        $user_id = Auth::id();
        $result = Kategori::deleteKategori($user_id, $id);

        if ($result) {
            return redirect()->route('Kategori.index')->with('sukses', 'menghapus kategori.');
        } else {
            return redirect()->back()->with('gagal', 'Gagal menghapus kategori.');
        }
    }
}
