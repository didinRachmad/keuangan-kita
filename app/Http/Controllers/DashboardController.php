<?php

namespace App\Http\Controllers;

use App\Models\Transaksi\Pengeluaran;
use App\Models\Transaksi\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id_keluarga = Auth::user()->id_keluarga;
        $getMonth = date('m');
        $getYear = date('Y');
        $bulan = $this->ambil_bulan($getMonth);

        $total_kredit_bulan = Pemasukan::where('id_keluarga', $id_keluarga)->whereMonth('tgl_transaksi', $getMonth)->sum('total_transaksi');
        $total_debit_bulan = Pengeluaran::where('id_keluarga', $id_keluarga)->whereMonth('tgl_transaksi', $getMonth)->sum('total_transaksi');
        $total_saldo_bulan = $total_kredit_bulan - $total_debit_bulan;

        $total_kredit_tahun = Pemasukan::where('id_keluarga', $id_keluarga)->whereYear('tgl_transaksi', $getYear)->sum('total_transaksi');
        $total_debit_tahun = Pengeluaran::where('id_keluarga', $id_keluarga)->whereYear('tgl_transaksi', $getYear)->sum('total_transaksi');
        $total_saldo_tahun = $total_kredit_tahun - $total_debit_tahun;
        $title = "Dashboard";

        return view('Dashboard', compact('title', 'total_debit_bulan', 'total_kredit_bulan', 'total_saldo_bulan', 'total_debit_tahun', 'total_kredit_tahun', 'total_saldo_tahun', 'bulan'));
    }

    public function ambil_bulan($bulan)
    {
        $data = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        return $data[$bulan];
    }
}
