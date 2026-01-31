<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_Villa extends Model
{
    use HasFactory;

    protected $table = 'kategori_villa';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'id_kategori';
    }

    protected $hidden = [];
}