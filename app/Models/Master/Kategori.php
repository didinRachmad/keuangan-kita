<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jenis', 'user_id'];

    public static function getKategori($userId)
    {
        return self::where('user_id', $userId)->get();
    }

    public static function createKategori($data, $user_id)
    {
        return DB::transaction(function () use ($data, $user_id) {
            try {
                $kategori = new self();
                $kategori->user_id = $user_id;
                $kategori->nama = $data['nama'];
                $kategori->jenis = $data['jenis'];
                $kategori->save();

                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                return false;
            }
        });
    }

    public static function updateKategori($id, $userId, $data)
    {
        return DB::transaction(function () use ($id, $userId, $data) {
            $kategori = self::where('id', $id)->where('user_id', $userId)->first();

            if (!$kategori) {
                return false;
            }

            try {
                $kategori->update($data);
                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                // Log error jika perlu
                Log::error($e->getMessage());
                return false;
            }
        });
    }

    public static function deleteKategori($user_id, $id)
    {
        return DB::transaction(function () use ($user_id, $id) {
            try {
                $kategori = self::where('user_id', $user_id)->where('id', $id)->first();

                if ($kategori) {
                    $kategori->delete();
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
