<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PemasukanController extends Controller
{
    public function index()
    {
        $bulan = session('bulanPenjualan', date('n'));
        $tahun = session('tahunPenjualan', date('Y'));

        $userId = Auth::user()->id;

        $pemasukan = Pemasukan::getPemasukan($userId, $bulan, $tahun);

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
            'tanggal_transaksi' => 'required|date',
            'total_transaksi' => 'required|numeric'
        ]);

        $user_id = Auth::id();
        $result = Pemasukan::createPemasukan($validatedData, $user_id);

        if ($result) {
            return redirect()->route('Pemasukan.index')->with('sukses', 'menambahkan pemasukan.');
        } else {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan pemasukan.');
        }
    }

    public function ubah_pemasukan(Request $request, $id)
    {
        $user_id = Auth::id();
        $saldoAwal = str_replace('.', '', $request->input('total_transaksi'));
        $request->merge(['total_transaksi' => $saldoAwal]);
        $tanggal_transaksi = date('Y-m-d', strtotime($request->input('tanggal_transaksi')));
        $request->merge(['tanggal_transaksi' => $tanggal_transaksi]);
        $validatedData = $request->validate([
            'keterangan' => 'required',
            'tanggal_transaksi' => 'required|date',
            'total_transaksi' => 'required|numeric'
        ]);

        try {
            $result = Pemasukan::updatePemasukan($id, $user_id, $validatedData);

            if ($result) {
                return redirect()->route('Pemasukan.index')->with('sukses', 'Pemasukan berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Pemasukan tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('gagal', 'Pemasukan tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui pemasukan.');
        }
    }

    public function hapus_pemasukan($id)
    {
        $user_id = Auth::id();
        $result = Pemasukan::deletePemasukan($user_id, $id);

        if ($result) {
            return redirect()->route('Pemasukan.index')->with('sukses', 'menghapus pemasukan.');
        } else {
            return redirect()->back()->with('gagal', 'Gagal menghapus pemasukan.');
        }
    }
}
