<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'hubungan', 'user_id', 'tgl_lahir', 'email', 'no_telp'];

    public static function getAnggota($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public static function createAnggota($data, $user_id)
    {
        return DB::transaction(function () use ($data, $user_id) {
            try {
                $anggota = new self();
                $anggota->user_id = $user_id;
                $anggota->nama = $data['nama'];
                $anggota->hubungan = $data['hubungan'];
                $anggota->tgl_lahir = $data['tgl_lahir'];
                $anggota->email = $data['email'];
                $anggota->no_telp = $data['no_telp'];
                $anggota->save();

                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return false;
            }
        });
    }

    public static function updateAnggota($id, $userId, $data)
    {
        return DB::transaction(function () use ($id, $userId, $data) {
            $anggota = self::where('id', $id)->where('user_id', $userId)->first();

            if (!$anggota) {
                return false;
            }

            try {
                $anggota->update($data);
                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return false;
            }
        });
    }

    public static function deleteAnggota($user_id, $id)
    {
        return DB::transaction(function () use ($user_id, $id) {
            try {
                $anggota = self::where('user_id', $user_id)->where('id', $id)->first();

                if ($anggota) {
                    $anggota->delete();
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
