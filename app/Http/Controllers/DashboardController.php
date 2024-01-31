<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Tambahkan logika untuk mengambil data total pemasukan dan pengeluaran dari periode tertentu
        $bulan = date('n');
        $bulan = $this->ambil_bulan($bulan);
        $total_debit = 1000000; // Gantilah dengan logika sesuai kebutuhan
        $total_kredit = 4500000; // Gantilah dengan logika sesuai kebutuhan
        $total_saldo = $total_kredit - $total_debit; // Gantilah dengan logika sesuai kebutuhan
        $title = "Dashboard"; // Gantilah dengan logika sesuai kebutuhan

        return view('dashboard', compact('title', 'total_debit', 'total_kredit', 'total_saldo', 'bulan'));
    }

    public function ambil_bulan($bulan)
    {
        $data = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        return $data[$bulan];
    }
}
