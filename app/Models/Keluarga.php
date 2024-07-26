<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    protected $fillable = ['nama_keluarga'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_keluarga');
    }
}
