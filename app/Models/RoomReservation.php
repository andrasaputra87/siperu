<?php

namespace App\Models;

use App\Models\User;
use App\Models\Session;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomReservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function termohon()
    {
        return $this->belongsTo(User::class);
    }
    
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id','id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class,'start_time','id');
    }

    public function faculty()
    {
        return $this->belongsTo(Session::class,'start_time','id');
    }
}
