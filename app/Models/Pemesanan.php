<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_villa',
        'id_user',
        'tanggal_masuk',
        'tanggal_keluar',
        'jml_penginap',
        'jml_kendaraan',
        'status_pemesanan',
        'alasan_ditolak',
        'total_harga',
        'dp',
        'sisa_pembayaran',
        'jumlah_dibayar',
        'jenis_pembayaran',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function villa(){
        return $this->belongsTo(Villa::class, 'id_villa');
    }

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function pembayaran(){
        return $this->hasMany(Pembayaran::class, 'id_pemesanan');
    }

    public function ulasan(){
        return $this->hasOne(Ulasan::class, 'id_pemesanan');
    }

    public function extras(){
        return $this->belongsToMany(ExtraSewa::class, 
        'pesan_extra',
        'id_pemesanan',
        'id_extra'
        )->withPivot('jumlah');
    }
}
