<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomReservation;

class Session extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function room_reservations()
    {
        return $this->hasMany(RoomReservation::class);
    }

}
