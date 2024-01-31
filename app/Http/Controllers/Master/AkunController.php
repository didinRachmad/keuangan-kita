<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Akun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AkunController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $akun = Akun::getAkun($userId);
        $title = 'Data Akun';
        return view('Master.Akun', compact('akun', 'title'));
    }

    public function tambah_akun(Request $request)
    {
        $saldoAwal = str_replace('.', '', $request->input('saldo_awal'));
        $request->merge(['saldo_awal' => $saldoAwal]);
        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'saldo_awal' => 'required|numeric'
        ]);

        $user_id = Auth::id();
        $result = Akun::createAkun($validatedData, $user_id);

        if ($result) {
            return redirect()->route('Akun.index')->with('sukses', 'menambahkan akun.');
        } else {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan akun.');
        }
    }

    public function ubah_akun(Request $request, $id)
    {
        $user_id = Auth::id();

        $saldoAwal = str_replace('.', '', $request->input('saldo_awal'));
        $request->merge(['saldo_awal' => $saldoAwal]);

        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'saldo_awal' => 'required|numeric'
        ]);

        try {
            $result = Akun::updateAkun($id, $user_id, $validatedData);

            if ($result) {
                return redirect()->route('Akun.index')->with('sukses', 'Akun berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Akun tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('gagal', 'Akun tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui akun.');
        }
    }

    public function hapus_akun($id)
    {
        $user_id = Auth::id();
        $result = Akun::deleteAkun($user_id, $id);

        if ($result) {
            return redirect()->route('Akun.index')->with('sukses', 'menghapus akun.');
        } else {
            return redirect()->back()->with('gagal', 'Gagal menghapus akun.');
        }
    }
}
