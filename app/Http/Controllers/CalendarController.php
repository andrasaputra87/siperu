<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomReservation;

class CalendarController extends Controller
{
    public function index()
    {
        return view('content.calendar');
    }

    public function events(){

    }
}
