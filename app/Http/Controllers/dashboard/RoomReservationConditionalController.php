<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomReservation;
use App\Models\Department;
use Carbon\Carbon;
use Irfa\HariLibur\Facades\HariLibur;
use App\Models\Session;


class RoomReservationConditionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('content.dashboard.room_reservation_conditional', [
            'rooms' => Room::latest()->where('name', 'like', "%" . $request->keyword . "%")
              ->orWhere('ownership', 'like', "%" . $request->keyword . "%")
              ->orWhere('location', 'like', "%" . $request->keyword . "%")->get(),
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $today = Carbon::today()->format('Y-m-d');
        $room = Room::findOrFail($id);

        return view('content.dashboard.room_reservation_conditional_create', [
        'room' => $room,
        'departments' => Department::all(),
        'list_reservation' => RoomReservation::latest()->where('room_id', $id)->where('reservation_date', $today)->where(function ($query) {
            $query->where('status', 'pending')
            ->orWhere('status', 'approved');
        })->get()
        ]);
    }

    public function get(Request $request){
        $date = Carbon::parse($request->date)->format('d-m-Y');
        $dayName = strtolower(substr(Carbon::parse($date)->dayName,0,3));
        if(HariLibur::date($date)->isHoliday() )
        {
          return response()->json([
            'success' => false,
            'data'    => 'Tanggal yang dipilih tanggal merah yaitu "'.HariLibur::date($date)->getInfo().'"' 
          ]);
        } elseif($dayName=='sun'){
          return response()->json([
            'success' => false,
            'data'    => 'Tanggal yang dipilih tanggal merah yaitu Hari Minggu' 
          ]);
        } else{
          $get = RoomReservation::leftjoin('sessions','room_reservations.start_time','=','sessions.id')
          ->where('reservation_date', '=', $request->date)
          ->get(['sessions.id']);   
          $data = Session::select('*')->whereIn('id',RoomReservation::leftjoin('sessions','room_reservations.start_time','=','sessions.id')
                                                  ->where('reservation_date', '=', $request->date)
                                                  ->get(['sessions.id']))
                                      ->where($dayName,'=','1')
                                      ->get();
    
          return response()->json([
            'success' => true,
            'data'    => $data  
          ]);
        }
    
        
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
