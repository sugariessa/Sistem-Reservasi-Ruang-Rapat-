<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'nama', 'kapasitas', 'lokasi', 'deskripsi', 'status'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

