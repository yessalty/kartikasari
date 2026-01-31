<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillaFoto extends Model
{
    protected $table = 'villa_foto';

    protected $fillable = [
        'id_villa',
        'foto',
        'is_cover'
    ];

    public function villa(){
        return $this->belongsTo(Villa::class, 'id_villa');
    }
}
