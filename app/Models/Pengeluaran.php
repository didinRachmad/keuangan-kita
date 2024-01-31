<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pengeluaran extends Model
{
    use HasFactory;

    public static function getPengeluaran($userId, $bulan, $tahun)
    {
        return self::where('user_id', $userId)
            ->whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->get(['id', 'keterangan', 'tanggal_transaksi', 'total_transaksi']);
    }

    public static function createPengeluaran($data, $user_id)
    {
        return DB::transaction(
            function () use ($data, $user_id) {
                try {
                    $pengeluaran = new self();
                    $pengeluaran->user_id = $user_id;
                    $pengeluaran->keterangan = $data['keterangan'];
                    $pengeluaran->tanggal_transaksi = date('Y-m-d', strtotime($data['tanggal_transaksi']));
                    $pengeluaran->total_transaksi = str_replace('.', '', $data['total_transaksi']);
                    $pengeluaran->save();

                    return true;
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return false;
                }
            }
        );
    }
    public static function updatePengeluaran($id, $userId, $data)
    {
        return DB::transaction(
            function () use ($id, $userId, $data) {

                $pengeluaran = self::where('id', $id)->where('user_id', $userId)->first();

                if (!$pengeluaran) {
                    return false;
                }

                try {
                    $pengeluaran->update($data);
                    return true;
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return false;
                }
            }
        );
    }

    public static function deletePengeluaran($user_id, $id)
    {
        return DB::transaction(function () use ($user_id, $id) {
            try {
                $pengeluaran = self::where('user_id', $user_id)->where('id', $id)->first();

                if ($pengeluaran) {
                    $pengeluaran->delete();
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return false;
            }
        });
    }
}
