<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Room;
use App\Models\User;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Models\RoomReservation;

class Dashboard extends Controller
{
  public function index()
  {
    if(in_array(auth()->user()->role, ['admin','head_baak', 'head_bm', 'staff_bm'])) {
      return view('content.dashboard.dashboard', [
        'rooms' => Room::with(['roomReservations' => function ($query) {
                                $query->where('status', 'approved');
                              }])
                        ->withCount(['roomReservations' => function ($query) {
                                $query->where('status', 'approved');
                              }])
                        ->orderBy('room_reservations_count', 'desc')
                        ->orderBy('id', 'desc')
                        ->limit(7)
                        ->get(),
        'total_ruangan' => Room::count(),
        'total_pengguna' => User::count(),
        'departments' => Department::with('users')->get(),
        'total_department' => Department::count(),
        'total_reservation' => RoomReservation::where('status', 'approved')->count(),
      ]);
    } else {
      return view('content.dashboard.dashboard_user', [
        'ruangan_tersedia' => Room::where('availability', '1')->count(),
        'peminjaman' => RoomReservation::where('user_id', auth()->user()->id)->get(),
      ]);
    }

  }
}
