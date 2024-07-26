<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Akun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AkunController extends Controller
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
        $akun = Akun::getAkun($this->id_keluarga);
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

        try {
            $result = Akun::createAkun($validatedData, $this->id_keluarga);

            if ($result) {
                return redirect()->route('Akun.index')->with('sukses', 'menambahkan akun.');
            } else {
                return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan akun.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'akun tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambah akun.');
        }
    }

    public function ubah_akun(Request $request, $id)
    {
        $saldoAwal = str_replace('.', '', $request->input('saldo_awal'));
        $request->merge(['saldo_awal' => $saldoAwal]);

        $validatedData = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'saldo_awal' => 'required|numeric'
        ]);

        try {
            $result = Akun::updateAkun($id, $this->id_keluarga, $validatedData);

            if ($result) {
                return redirect()->route('Akun.index')->with('sukses', 'Akun berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Akun tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'akun tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui akun.');
        }
    }

    public function hapus_akun($id)
    {
        try {
            $result = Akun::deleteAkun($this->id_keluarga, $id);

            if ($result) {
                return redirect()->route('Akun.index')->with('sukses', 'menghapus akun.');
            } else {
                return redirect()->back()->with('gagal', 'Gagal menghapus akun.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'akun tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menghapus akun.');
        }
    }
}
