<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PengeluaranController extends Controller
{
    public function index()
    {
        $bulan = session('bulanPenjualan', date('n'));
        $tahun = session('tahunPenjualan', date('Y'));

        $userId = Auth::user()->id;

        $pengeluaran = Pengeluaran::getPengeluaran($userId, $bulan, $tahun);

        return view('Transaksi.Pengeluaran', [
            'title' => 'Data Pengeluaran',
            'pengeluaran' => $pengeluaran
        ]);
    }

    public function cari_pengeluaran(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        Session::put('bulanPenjualan', $bulan);
        Session::put('tahunPenjualan', $tahun);

        return redirect()->route('Pengeluaran.index');
    }

    public function tambah_pengeluaran(Request $request)
    {
        $saldoAwal = str_replace('.', '', $request->input('total_transaksi'));
        $request->merge(['total_transaksi' => $saldoAwal]);
        $validatedData = $request->validate([
            'keterangan' => 'required',
            'tanggal_transaksi' => 'required|date',
            'total_transaksi' => 'required|numeric'
        ]);

        $user_id = Auth::id();
        $result = Pengeluaran::createPengeluaran($validatedData, $user_id);

        if ($result) {
            return redirect()->route('Pengeluaran.index')->with('sukses', 'menambahkan pengeluaran.');
        } else {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan pengeluaran.');
        }
    }

    public function ubah_pengeluaran(Request $request, $id)
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
            $result = Pengeluaran::updatePengeluaran($id, $user_id, $validatedData);

            if ($result) {
                return redirect()->route('Pengeluaran.index')->with('sukses', 'Pengeluaran berhasil diperbarui.');
            } else {
                return redirect()->back()->with('gagal', 'Pengeluaran tidak ditemukan atau gagal memperbarui.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('gagal', 'Pengeluaran tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat memperbarui pengeluaran.');
        }
    }

    public function hapus_pengeluaran($id)
    {
        $user_id = Auth::id();
        $result = Pengeluaran::deletePengeluaran($user_id, $id);

        if ($result) {
            return redirect()->route('Pengeluaran.index')->with('sukses', 'menghapus pengeluaran.');
        } else {
            return redirect()->back()->with('gagal', 'Gagal menghapus pengeluaran.');
        }
    }
}
