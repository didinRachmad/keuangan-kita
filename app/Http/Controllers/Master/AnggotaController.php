<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnggotaController extends Controller
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
        $anggota = User::getAnggota($this->id_keluarga);
        $title = 'Data Anggota';
        return view('Master.Anggota', compact('anggota', 'title'));
    }

    public function tambah_anggota(Request $request)
    {
        $tgl_lahir = date('Y-m-d', strtotime($request->input('tgl_lahir')));
        $request->merge(['tgl_lahir' => $tgl_lahir]);
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'id_keluarga' => 'required|exists:keluargas,id',
            'hubungan' => 'required|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'no_telp' => 'nullable|string|max:20',
            'role' => 'required', 'string', 'in:Anggota,Admin',
        ]);

        try {
            $result = User::createAnggota($validatedData);

            if ($result) {
                return redirect()->route('Anggota.index')->with('sukses', 'menambahkan anggota.');
            } else {
                return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan anggota.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'anggota tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambah anggota.');
        }
    }

    public function ubah_anggota(Request $request, $id)
    {
        $tgl_lahir = date('Y-m-d', strtotime($request->input('tgl_lahir')));
        $request->merge(['tgl_lahir' => $tgl_lahir]);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'hubungan' => 'required|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'no_telp' => 'nullable|string|max:20',
            'role' => 'required', 'string', 'in:Anggota,Admin',
        ]);

        try {
            $result = User::updateAnggota($id, $validatedData);

            if ($result) {
                return redirect()->route('Anggota.index')->with('sukses', 'Anggota berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Anggota tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'anggota tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui anggota.');
        }
    }

    public function hapus_anggota($id)
    {
        try {
            $result = User::deleteAnggota($id);

            if ($result) {
                return redirect()->route('Anggota.index')->with('sukses', 'menghapus anggota.');
            } else {
                return redirect()->back()->with('gagal', 'Gagal menghapus anggota.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'anggota tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal.', ['exception' => $e]);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menghapus anggota.');
        }
    }
}
