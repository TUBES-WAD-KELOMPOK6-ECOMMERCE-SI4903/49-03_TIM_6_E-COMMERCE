<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlamatPengiriman extends Model
{
    protected $table = 'alamat_pengiriman';

    protected $fillable = ['id_pelanggan', 'label', 'penerima', 'alamat'];

    public $timestamps = false;

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(ProfilPelanggan::class, 'id_pelanggan');
    }
}
