<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pemasukan extends Model
{
    use HasFactory;

    public static function getPemasukan($userId, $bulan, $tahun)
    {
        return self::where('user_id', $userId)
            ->whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->get(['id', 'keterangan', 'tanggal_transaksi', 'total_transaksi']);
    }

    public static function createPemasukan($data, $user_id)
    {
        return DB::transaction(
            function () use ($data, $user_id) {
                try {
                    $pemasukan = new self();
                    $pemasukan->user_id = $user_id;
                    $pemasukan->keterangan = $data['keterangan'];
                    $pemasukan->tanggal_transaksi = date('Y-m-d', strtotime($data['tanggal_transaksi']));
                    $pemasukan->total_transaksi = str_replace('.', '', $data['total_transaksi']);
                    $pemasukan->save();

                    return true;
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return false;
                }
            }
        );
    }
    public static function updatePemasukan($id, $userId, $data)
    {
        return DB::transaction(
            function () use ($id, $userId, $data) {

                $pemasukan = self::where('id', $id)->where('user_id', $userId)->first();

                if (!$pemasukan) {
                    return false;
                }

                try {
                    $pemasukan->update($data);
                    return true;
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error($e->getMessage());
                    return false;
                }
            }
        );
    }

    public static function deletePemasukan($user_id, $id)
    {
        return DB::transaction(function () use ($user_id, $id) {
            try {
                $pemasukan = self::where('user_id', $user_id)->where('id', $id)->first();

                if ($pemasukan) {
                    $pemasukan->delete();
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
