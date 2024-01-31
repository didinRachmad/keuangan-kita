<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Akun extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jenis', 'saldo_awal', 'user_id'];

    public static function getAkun($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public static function createAkun($data, $user_id)
    {
        return DB::transaction(function () use ($data, $user_id) {
            try {
                $akun = new self();
                $akun->user_id = $user_id;
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

    public static function updateAkun($id, $userId, $data)
    {
        return DB::transaction(function () use ($id, $userId, $data) {
            $akun = self::where('id', $id)->where('user_id', $userId)->first();

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

    public static function deleteAkun($user_id, $id)
    {
        return DB::transaction(function () use ($user_id, $id) {
            try {
                $akun = self::where('user_id', $user_id)->where('id', $id)->first();

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
