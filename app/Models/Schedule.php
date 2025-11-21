<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'jam_mulai',
        'jam_selesai', 
        'hari_kerja'
    ];

    protected $casts = [
        'hari_kerja' => 'array'
    ];
}