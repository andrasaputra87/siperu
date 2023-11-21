<?php

namespace App\Models;

use App\Models\RoomImages;
use App\Models\RoomReservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function roomReservations()
    {
        return $this->hasMany(RoomReservation::class);
    }

    public function roomImages()
    {
        return $this->hasMany(RoomImages::class);
    }
}
