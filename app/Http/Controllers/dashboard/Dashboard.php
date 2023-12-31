<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Room;
use App\Models\User;
use App\Models\Department;
use App\Models\Building;
use App\Http\Controllers\Controller;
use App\Models\RoomReservation;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
  public function index()
  {
    if (in_array(auth()->user()->role, ['admin'])) {
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
        'total_gedung' => Building::count(),
        'total_ruangan' => Room::count(),
        'total_pengguna' => User::count(),
        'departments' => Department::with('users')->get(),
        'total_department' => Department::count(),
        'total_reservation' => RoomReservation::where('status', 'approved')->count(),
      ]);
    } elseif(in_array(auth()->user()->role, ['admin_fakultas','head_baak'])){
      return view('content.dashboard.dashboard_user', [
        'ruangan_tersedia' => Room::where('availability', '1')
        ->leftjoin('buildings','buildings.id','building_id')
        ->leftjoin('users','users.id','id_user')
        ->where('users.faculty_id',auth()->user()->faculty_id)->count(),
        // 'peminjaman' => RoomReservation::where('user_id', auth()->user()->id)->get(),
        'peminjaman' => RoomReservation::where('user_id', auth()->user()->id)->with('session')->get(),
      ]);
    } else {
      //   $hasil = DB::table('room_reservations')
      // ->select('room_reservations.*', 'sessions.start')
      // ->join('sessions', 'room_reservations.start_time', '=', 'sessions.id')
      // ->where('room_reservations.user_id', '=', 3)
      // ->get();


      return view('content.dashboard.dashboard_user', [
        'ruangan_tersedia' => Room::where('availability', '1')->count(),
        // 'peminjaman' => RoomReservation::where('user_id', auth()->user()->id)->get(),
        'peminjaman' => RoomReservation::where('user_id', auth()->user()->id)->with('session')->get(),
      ]);
    }
  }
}
