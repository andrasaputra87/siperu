<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomReservation;

class ReservationConditionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $reservations = RoomReservation::with(['user', 'room', 'termohon'])->where('conditional','!=',0)->orderBy('status', 'asc')->orderBy('id', 'asc')->get();
            $reservation_total = RoomReservation::count();
            $reservation_approved = RoomReservation::where('status', 'approved')->count();
            $reservation_not_approved = RoomReservation::where('status', 'not approved')->count();
            $reservation_cancelled = RoomReservation::where('status', 'cancelled')->count();
            $reschedule = RoomReservation::where('status','reschedule')->count();
          } elseif (auth()->user()->role == 'head_baak' || auth()->user()->role == 'staff_baak') {
            $reservations = RoomReservation::with(['user', 'room','session'])->whereHas('room', function ($query) {
              $query->where('ownership', 'baak');
            })->orderBy('id', 'desc')->get();
            $reservation_total = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'baak');
            })->count();
            $reservation_approved = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'baak');
            })->where('status', 'approved')->count();
            $reservation_not_approved = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'baak');
            })->where('status', 'not approved')->count();
            $reservation_cancelled = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'baak');
            })->where('status', 'cancelled')->count();
            $reschedule = RoomReservation::whereHas('room', function($query){
              $query->where('ownership', 'baak');
            })->where('status', 'reschedule')->count();
          } else {
            $reservations = RoomReservation::with(['user', 'room','session'])->whereHas('room', function ($query) {
              $query->where('ownership', 'bm');
            })->orderBy('id', 'desc')->get();
            $reservation_total = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'bm');
            })->count();
            $reservation_approved = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'bm');
            })->where('status', 'approved')->count();
            $reservation_not_approved = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'bm');
            })->where('status', 'not approved')->count();
            $reservation_cancelled = RoomReservation::whereHas('room', function ($query) {
              $query->where('ownership', 'bm');
            })->where('status', 'cancelled')->count();
            $reschedule = RoomReservation::whereHas('room', function($query){
              $query->where('ownership', 'bm');
            })->where('status', 'reschedule')->count();
          }
      
          return view('content.dashboard.reservation_conditonal_data', [
            'reservations' => $reservations,
            'reservation_total' => $reservation_total,
            'reservation_approved' => $reservation_approved,
            'reservation_not_approved' => $reservation_not_approved,
            'reservation_cancelled' => $reservation_cancelled,
            'reschedule' => $reschedule,
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

    public function approve_conditional($id)
  {
    echo $reservation = RoomReservation::findOrFail($id);
    $result = RoomReservation::where('id', $reservation->termohon)->update([
        'status' => 'cancelled',
        'key_status' => 'cancelled'
    ]);
    $reservation->update(['status' => 'approved']);
    return redirect('/reservation_conditonal')->with('message', 'Reservasi berhasil disetujui!👍');
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
        //
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
