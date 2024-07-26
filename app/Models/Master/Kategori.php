<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jenis', 'id_keluarga'];

    public static function getKategori($id_keluarga)
    {
        return self::where('id_keluarga', $id_keluarga)->orderBy('id', 'desc')->get();
    }

    public static function createKategori($data, $id_keluarga)
    {
        return DB::transaction(function () use ($data, $id_keluarga) {
            try {
                $kategori = new self();
                $kategori->id_keluarga = $id_keluarga;
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

    public static function updateKategori($id, $id_keluarga, $data)
    {
        return DB::transaction(function () use ($id, $id_keluarga, $data) {
            $kategori = self::where('id', $id)->where('id_keluarga', $id_keluarga)->first();

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

    public static function deleteKategori($id_keluarga, $id)
    {
        return DB::transaction(function () use ($id_keluarga, $id) {
            try {
                $kategori = self::where('id_keluarga', $id_keluarga)->where('id', $id)->first();

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
