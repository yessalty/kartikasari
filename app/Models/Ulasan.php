<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_pemesanan',
        'id_villa',
        'id_user',
        'rating',
        'komentar',
        'status',
    ];

    public function pemesanan(){
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function villa(){
        return $this->belongsTo(Villa::class, 'id_villa');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
