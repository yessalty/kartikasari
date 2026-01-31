<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraSewa extends Model
{
    use HasFactory;

    protected $table = 'extra_sewa';
    protected $primaryKey = 'id_extra';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'nama_extra',
        'harga',
        'deskripsi',
        'satuan',
    ];

    public function getRouteKeyName()
    {
        return 'id_extra';
    }

    public function pemesanans(){
        return $this->belongsToMany
            (Pemesanan::class, 
            'pesan_extra',
            'id_extra',
            'id_pemesanan'
            )->withPivot('jumlah');
    }
}
