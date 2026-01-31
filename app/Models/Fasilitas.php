<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'nama_fasilitas',
    ];

    public function villas(){
        return $this->belongsToMany(
            Villa::class,
            'fasilitas_villa',
            'id_fasilitas',
            'id_villa');
    }
}
