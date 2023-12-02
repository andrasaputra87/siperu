<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomReservation;

class CalendarController extends Controller
{
    public function index()
    {
        $events = [];
 
        $appointments = RoomReservation::with(['user', 'session'])->get();
 
        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => 'ABC',
                'start' => '17:00:00',
                'end' => '18:00:00',
            ];
        }
 
        return view('content.calendar', compact('events'));
    }
}
