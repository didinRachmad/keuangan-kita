<?php

namespace App\Console\Commands;

use App\Models\Transaksi\Pemasukan;
use App\Models\Transaksi\Pengeluaran;
use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class InsertSaldoAwal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:saldo-awal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert saldo awal ke tabel Pemasukan pada tanggal 1 setiap bulan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bulan_lalu = Carbon::now()->subMonth()->month;

        // Dapatkan semua kel$keluarga, di-groupBy berdasarkan id_keluarga
        $keluargas = User::groupBy('id_keluarga')->get();

        foreach ($keluargas as $keluarga) {
            // Hitung total pemasukan bulan lalu untuk kel$keluarga ini
            $total_pemasukan = Pemasukan::where('id_keluarga', $keluarga->id_keluarga)
                ->whereMonth('tgl_transaksi', $bulan_lalu)
                ->sum('total_transaksi');

            // Hitung total pengeluaran bulan lalu untuk kel$keluarga ini
            $total_pengeluaran = Pengeluaran::where('id_keluarga', $keluarga->id_keluarga)
                ->whereMonth('tgl_transaksi', $bulan_lalu)
                ->sum('total_transaksi');

            // Hitung saldo awal
            $saldo_awal = $total_pemasukan - $total_pengeluaran;

            // Insert saldo awal ke tabel Pemasukan
            Pemasukan::create([
                'id_keluarga' => $keluarga->id,
                'keterangan' => 'Saldo awal bulan',
                'tgl_transaksi' => Carbon::now()->startOfMonth(),
                'total_transaksi' => $saldo_awal,
            ]);
        }

        $this->info('Saldo awal berhasil diinsert untuk semua pengguna');
        return 0;
    }
}
