<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Akun extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jenis', 'saldo_awal', 'id_keluarga'];

    public static function getAkun($id_keluarga)
    {
        return self::where('id_keluarga', $id_keluarga)->orderBy('id', 'desc')->get();
    }

    public static function createAkun($data, $id_keluarga)
    {
        return DB::transaction(function () use ($data, $id_keluarga) {
            try {
                $akun = new self();
                $akun->id_keluarga = $id_keluarga;
                $akun->nama = $data['nama'];
                $akun->jenis = $data['jenis'];
                $akun->saldo_awal = str_replace('.', '', $data['saldo_awal']);
                $akun->save();

                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                return false;
            }
        });
    }

    public static function updateAkun($id, $id_keluarga, $data)
    {
        return DB::transaction(function () use ($id, $id_keluarga, $data) {
            $akun = self::where('id', $id)->where('id_keluarga', $id_keluarga)->first();

            if (!$akun) {
                return false;
            }

            try {
                $akun->update($data);
                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                // Log error jika perlu
                Log::error($e->getMessage());
                return false;
            }
        });
    }

    public static function deleteAkun($id_keluarga, $id)
    {
        return DB::transaction(function () use ($id_keluarga, $id) {
            try {
                $akun = self::where('id_keluarga', $id_keluarga)->where('id', $id)->first();

                if ($akun) {
                    $akun->delete();
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
