<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan_Extra extends Model
{
    use HasFactory;

    protected $table = 'pesan_extra';

    protected $fillable = [
        'id_pemesanan',
        'id_extra',
        'jumlah',
    ];

    public function pemesanan(){
        return $this->belongsTo(Pemesanan::class, 'pesan_extra');
    }
}
