<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'jenis',
        'nilai',
        'minimal',
        'maksimal',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];
}
