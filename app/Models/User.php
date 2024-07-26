<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Keluarga;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_keluarga', 'hubungan', 'tgl_lahir', 'no_telp', 'role', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id_keluarga');
    }

    public static function getAnggota($id_keluarga)
    {
        return self::where('id_keluarga', $id_keluarga)->orderBy('id', 'desc')->get();
    }

    public static function createAnggota($data)
    {
        return DB::transaction(function () use ($data) {
            try {
                $user = new User();
                $user->name = $data['nama'];
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                $user->id_keluarga = $data['id_keluarga'];
                $user->hubungan = $data['hubungan'];
                $user->tgl_lahir = $data['tgl_lahir'];
                $user->no_telp = $data['no_telp'];
                $user->role = $data['role'];
                $user->remember_token = Str::random(60);
                $user->save();

                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return false;
            }
        });
    }

    public static function updateAnggota($id, $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $anggota = self::where('id', $id)->first();

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

    public static function deleteAnggota($id)
    {
        return DB::transaction(function () use ($id) {
            try {
                $anggota = self::where('id', $id)->first();

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
