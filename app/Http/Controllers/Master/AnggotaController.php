<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $anggota = Anggota::getAnggota($userId);
        $title = 'Data Anggota';
        return view('Master.Anggota', compact('anggota', 'title'));
    }

    public function tambah_anggota(Request $request)
    {
        $tgl_lahir = date('Y-m-d', strtotime($request->input('tgl_lahir')));
        $request->merge(['tgl_lahir' => $tgl_lahir]);
        $validatedData = $request->validate([
            'nama' => 'required',
            'hubungan' => 'required',
            'tgl_lahir' => 'nullable|date',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string|max:20'
        ]);

        $user_id = Auth::id();
        $result = Anggota::createAnggota($validatedData, $user_id);

        if ($result) {
            return redirect()->route('Anggota.index')->with('sukses', 'menambahkan anggota.');
        } else {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan anggota.');
        }
    }

    public function ubah_anggota(Request $request, $id)
    {
        $user_id = Auth::id();
        $validatedData = $request->validate([
            'nama' => 'required',
            'hubungan' => 'required',
            'tgl_lahir' => 'nullable|date',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string|max:20'
        ]);

        try {
            $result = Anggota::updateAnggota($id, $user_id, $validatedData);

            if ($result) {
                return redirect()->route('Anggota.index')->with('sukses', 'Anggota berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Anggota tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('gagal', 'Anggota tidak ditemukan.');
        } catch (\Exception $e) {
            // Handle other exceptions if necessary
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui anggota.');
        }
    }

    public function hapus_anggota($id)
    {
        $user_id = Auth::id();
        $result = Anggota::deleteAnggota($user_id, $id);

        if ($result) {
            return redirect()->route('Anggota.index')->with('sukses', 'menghapus anggota.');
        } else {
            return redirect()->back()->with('gagal', 'Gagal menghapus anggota.');
        }
    }
}
