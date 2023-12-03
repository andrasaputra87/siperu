<?php

namespace App\Models;

use App\Models\User;
use App\Models\room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuildingView extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->hasMany(Room::class);
    }

    public function getRoomCount()
    {
        return $this->room->count();
    }
}
