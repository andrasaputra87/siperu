<?php

namespace App\Models;

use App\Models\RoomImages;
use App\Models\RoomReservation;
use App\Models\Building;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function roomReservations()
    {
        return $this->hasMany(RoomReservation::class, 'room_id','id');
    }

    public function roomImages()
    {
        return $this->hasMany(RoomImages::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id','id' );
    }
}
