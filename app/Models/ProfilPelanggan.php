<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfilPelanggan extends Model
{
    protected $table = 'profil_pelanggan';

    protected $fillable = ['nama_lengkap', 'email', 'no_telepon'];

    public $timestamps = false;

    public function alamat(): HasMany
    {
        return $this->hasMany(AlamatPengiriman::class, 'id_pelanggan');
    }
}
