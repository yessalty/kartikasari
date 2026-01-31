<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Villa extends Model
{
    use HasFactory;

    protected $table = 'villa';
    protected $primaryKey = 'id_villa';

    protected $fillable = [
        'nama_villa',
        'slug',
        'harga_villa',
        'deskripsi',
        'lokasi',
        'jumlah_kamar',
        'kamar_mandi',
        'id_kategori',
        'kapasitas_min',
        'kapasitas_max',
    ];

    protected static function booted()
    {
        static::creating(function ($villa) {
            $villa->slug = Str::slug($villa->nama_villa);
        });

        static::updating(function ($villa) {
            $villa->slug = Str::slug($villa->nama_villa);
        });
    }


    public function getRouteKeyName()
    {
        return 'id_villa';
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori_Villa::class, 'id_kategori');
    }

    public function fotos()
    {
        return $this->hasMany(VillaFoto::class, 'id_villa');
    }

    public function cover()
    {
        return $this->hasOne(VillaFoto::class, 'id_villa')
            ->where('is_cover', 1);
    }

    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'fasilitas_villa',
            'id_villa',
            'id_fasilitas'
        );
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_villa');
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'id_villa');
    }
}
