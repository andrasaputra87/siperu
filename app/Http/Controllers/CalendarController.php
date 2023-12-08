<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomReservation;
use App\Models\Building;
use App\Models\Room;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        if($cari){
            $buildings = Building::with(['user','room'])
                ->where('building_name','like',"%".$cari."%")
                ->orderBy('building_name','asc')->paginate(8);
        }else{
            $buildings = Building::with(['user','room'])->orderBy('building_name','asc')->paginate(8);
        }
        // var_dump(count($buildings->room));
        return view('content.building', compact('buildings','cari'));
    }

    public function calendar(Request $request, $id){
        $events = [];
        $room = Room::find($id);
        $cari = $request->cari;

        $reservations = RoomReservation::with(['room', 'user', 'session'])
            ->leftjoin('users','users.id','=','user_id')
            ->leftjoin('departments','departments.id','=','department_id')
            ->leftjoin('rooms','rooms.id','=','room_id')
            ->leftjoin('buildings','buildings.id','=','building_id')
            ->where('status','!=','not approved')
            ->where('status','!=','cancelled')
            ->where('status','!=','wait')
            ->where('room_id',$id)
            ->get(['*','departments.name as dapartment_name','buildings.building_name as building_name', 'room_reservations.id as rr_id']);
        $opened = RoomReservation::with(['room', 'user', 'session'])
            ->leftjoin('rooms','rooms.id','=','room_id')
            ->leftjoin('buildings','buildings.id','=','building_id')
            ->where('reservation_date',Carbon::today()->format('Y-m-d'))
            ->where('status','opened')
            ->where('room_id',$id)
            ->get(['*','buildings.building_name as building_name']);

        $off_day = RoomReservation::with(['room', 'user', 'session'])
            ->leftjoin('rooms','rooms.id','=','room_id')
            ->leftjoin('buildings','buildings.id','=','building_id')
            ->where('reservation_date',Carbon::today()->format('Y-m-d'))
            ->where('status','off-day')
            ->where('room_id',$id)
            ->get(['*','buildings.building_name as building_name']);
           
        foreach ($reservations as $reservation) {
            $events[] = [
                'id' =>  $reservation->rr_id,
                'title' => ucwords($reservation->user->fullname),
                'start' => $reservation->reservation_date.' '.$reservation->session->start,
                'end' => $reservation->reservation_date.' '.$reservation->end_time,
                'backgroundColor'  => $reservation->status=='approved'? '#1ce852' : ($reservation->status=='pending'? '#c70e0e' : ($reservation->status=='opened'? '#11baed' : ($reservation->status=='off-day'? 'yellow' : ($reservation->status=='reschedule'? '#ed11b2' : ($reservation->status=='returned'? '##0d9482' :'black'))))),
            ];
        }
    
        return view('content.calendar', compact('events','reservations', 'opened', 'off_day', 'room','cari'));
    }

    public function room(Request $request, $id){
        $cari = $request->cari;
        $building = Building::find($id);
        if($cari){
            $rooms = Room::with(['roomReservations'])
                ->where('building_id',$id)
                ->where('name','like',"%".$cari."%")
                ->orderBy('name','asc')->paginate(8);
        }else{
            $rooms = Room::with(['roomReservations'])->where('building_id',$id)->orderBy('name','asc')->paginate(8);
        }
        // var_dump(count($buildings->room));
        return view('content.room', compact('rooms','cari','building'));
    }

}
