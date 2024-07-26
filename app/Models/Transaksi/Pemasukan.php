<?php

namespace App\Models\Transaksi;

use App\Models\Master\Akun;
use App\Models\Master\Kategori;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pemasukan extends Model
{
    use HasFactory;


    protected $fillable = [
        'id_keluarga',
        'keterangan',
        'tgl_transaksi',
        'id_kategori',
        'id_akun',
        'id_pj',
        'total_transaksi',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pj', 'id');
    }

    public static function getPemasukan($id_keluarga, $bulan, $tahun)
    {
        $pemasukans = self::with(['akun', 'kategori', 'user'])
            ->where('id_keluarga', $id_keluarga)
            ->whereMonth('tgl_transaksi', $bulan)
            ->whereYear('tgl_transaksi', $tahun)
            ->orderBy('id', 'desc')
            ->get(['id', 'id_user', 'id_keluarga', 'keterangan', 'tgl_transaksi', 'id_kategori', 'id_akun', 'id_pj', 'total_transaksi']);
        return $pemasukans;
    }

    public static function createPemasukan($data, $id_user, $id_keluarga)
    {

        return DB::transaction(
            function () use ($data, $id_user, $id_keluarga) {
                try {
                    $pemasukan = new self();
                    $pemasukan->id_user = $id_user;
                    $pemasukan->id_keluarga = $id_keluarga;
                    $pemasukan->keterangan = $data['keterangan'];
                    $pemasukan->tgl_transaksi = date('Y-m-d', strtotime($data['tgl_transaksi']));
                    $pemasukan->id_kategori = $data['id_kategori'];
                    $pemasukan->id_akun = $data['id_akun'];
                    $pemasukan->id_pj = $data['id_pj'];
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
    public static function updatePemasukan($id, $id_keluarga, $data)
    {
        return DB::transaction(
            function () use ($id, $id_keluarga, $data) {

                $pemasukan = self::where('id', $id)->where('id_keluarga', $id_keluarga)->first();
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

    public static function deletePemasukan($id_keluarga, $id)
    {
        return DB::transaction(function () use ($id_keluarga, $id) {
            try {
                $pemasukan = self::where('id_keluarga', $id_keluarga)->where('id', $id)->first();

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
