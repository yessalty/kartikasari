<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasVilla extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_villa',
        'id_fasilitas',
    ];

    public function fasvilla(){
        return $this->belongsTo(Villa::class, 'id_villa');
    }

    public function fasilitas(){
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas');
    }
}
