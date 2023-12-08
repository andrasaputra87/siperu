<?php

namespace App\Models;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user','id');
    }

    public function room()
    {
        return $this->hasMany(Room::class,'building_id','id');
    }
    
}
