<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomReservation;
use App\Models\User;
use App\Models\Building;

class ReservationConditionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=NULL)
    {
        if (auth()->user()->role == 'admin') {
          if($id!=NULL){
            $reservations = RoomReservation::with(['user', 'room', 'termohon'])
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->leftjoin('faculty','faculty.id','faculty_id')
              ->leftjoin('users','users.id','user_id')
              ->leftjoin('room_reservations as b','b.id','room_reservations.termohon')
              ->leftjoin('users as termohon','termohon.id','b.user_id')
              ->where('room_reservations.conditional','!=',0)
              ->orderBy('room_reservations.status', 'asc')->orderBy('room_reservations.id', 'asc')
              ->get(['*','users.fullname as pemohon_name','users.avatar as pemohon_avatar',
            'users.slug as pemohon_slug',
            'termohon.fullname as termohon_name','users.nim as pemohon_nim',
            'termohon.nim as termohon_nim','room_reservations.status as status_conditional','room_reservations.id as id_rr']);
            $reservation_total = RoomReservation::where('conditional','!=',0)
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->where('buildings.id',$id)->count();
            $reservation_approved = RoomReservation::where('status', 'approved')->where('conditional','!=',0)
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->where('buildings.id',$id)->count();
            $reservation_not_approved = RoomReservation::where('status', 'not approved')->where('conditional','!=',0)
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->where('buildings.id',$id)->count();
            $reservation_cancelled = RoomReservation::where('status', 'cancelled')->where('conditional','!=',0)
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->where('buildings.id',$id)->count();
            $reschedule = RoomReservation::where('status','reschedule')->where('conditional','!=',0)
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->where('buildings.id',$id)->count();
          }else{
            $reservations = RoomReservation::with(['user', 'room'])
              ->leftjoin('users','users.id','user_id')
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->leftjoin('faculties','faculties.id','users.faculty_id')
              ->leftjoin('room_reservations as b','b.id','room_reservations.termohon')
              ->leftjoin('users as termohon','termohon.id','b.user_id')
              ->where('room_reservations.conditional','!=',0)
              ->orderBy('room_reservations.status', 'asc')->orderBy('room_reservations.id', 'asc')
              ->get(['*','users.fullname as pemohon_name','users.avatar as pemohon_avatar',
            'users.slug as pemohon_slug', 'room_reservations.necessary as pemohon_necessary', 
            'room_reservations.file_upload as pemohon_file_upload', 
            'termohon.fullname as termohon_name','users.nim as pemohon_nim',
            'termohon.nim as termohon_nim','room_reservations.status as status_conditional','room_reservations.id as id_rr']);
            $reservation_total = RoomReservation::where('conditional','!=',0)->count();
            $reservation_approved = RoomReservation::where('status', 'approved')->where('conditional','!=',0)->count();
            $reservation_not_approved = RoomReservation::where('status', 'not approved')->where('conditional','!=',0)->count();
            $reservation_cancelled = RoomReservation::where('status', 'cancelled')->where('conditional','!=',0)->count();
            $reschedule = RoomReservation::where('status','reschedule')->where('conditional','!=',0)->count();
            // var_dump($reservations);

          }
        }  else if (auth()->user()->role == 'pengelola_gedung') {
          $reservations = RoomReservation::with(['user', 'room'])
              ->leftjoin('users','users.id','user_id')
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->leftjoin('faculties','faculties.id','users.faculty_id')
              ->leftjoin('room_reservations as b','b.id','room_reservations.termohon')
              ->leftjoin('users as termohon','termohon.id','b.user_id')
              ->where('room_reservations.conditional','!=',0)
              ->where('buildings.id_user',auth()->user()->id)
              ->orderBy('room_reservations.status', 'asc')->orderBy('room_reservations.id', 'asc')
              ->get(['*','users.fullname as pemohon_name','users.avatar as pemohon_avatar',
            'users.slug as pemohon_slug', 'room_reservations.necessary as pemohon_necessary', 
            'termohon.fullname as termohon_name','users.nim as pemohon_nim',
            'termohon.nim as termohon_nim','room_reservations.status as status_conditional','room_reservations.id as id_rr']);

          $reservation_total = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',auth()->user()->id)
            ->count();
          $reservation_approved = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',auth()->user()->id)
            ->where('status', 'approved')->count();
          $reservation_not_approved = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',auth()->user()->id)
            ->where('status', 'not approved')->count();
          $reservation_cancelled = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',auth()->user()->id)->where('status', 'cancelled')->count();
          $reschedule = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',auth()->user()->id)->where('status','reschedule')->count();
        }else if (auth()->user()->role == 'admin_fakultas' || auth()->user()->role == 'head_baak') {
          $id_pengelola = User::where('faculty_id', auth()->user()->faculty_id)->where('role','pengelola_gedung')->first()->id;
          $reservations = RoomReservation::with(['user', 'room'])
              ->leftjoin('users','users.id','user_id')
              ->leftjoin('rooms','rooms.id','room_id')
              ->leftjoin('buildings','buildings.id','building_id')
              ->leftjoin('faculties','faculties.id','users.faculty_id')
              ->leftjoin('room_reservations as b','b.id','room_reservations.termohon')
              ->leftjoin('users as termohon','termohon.id','b.user_id')
              ->where('room_reservations.conditional','!=',0)
              ->where('buildings.id_user',$id_pengelola)
              ->orderBy('room_reservations.status', 'asc')->orderBy('room_reservations.id', 'asc')
              ->get(['*','users.fullname as pemohon_name','users.avatar as pemohon_avatar',
            'users.slug as pemohon_slug', 'room_reservations.necessary as pemohon_necessary', 
            'termohon.fullname as termohon_name','users.nim as pemohon_nim',
            'termohon.nim as termohon_nim','room_reservations.status as status_conditional','room_reservations.id as id_rr']);
          $reservation_total = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',$id_pengelola)
            ->count();
          $reservation_approved = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',$id_pengelola)
            ->where('status', 'approved')->count();
          $reservation_not_approved = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',$id_pengelola)
            ->where('status', 'not approved')->count();
          $reservation_cancelled = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',$id_pengelola)
            ->where('status', 'cancelled')->count();
          $reschedule = RoomReservation::
            leftjoin('rooms','room_reservations.room_id','=','rooms.id')
            ->leftjoin('buildings','rooms.building_id','=','buildings.id')
            ->where('conditional','!=',0)
            ->where('buildings.id_user',$id_pengelola)
            ->where('status','reschedule')->count();
        }
      
        return view('content.dashboard.reservation_conditonal_data', [
          'reservations' => $reservations,
          'reservation_total' => $reservation_total,
          'reservation_approved' => $reservation_approved,
          'reservation_not_approved' => $reservation_not_approved,
          'reservation_cancelled' => $reservation_cancelled,
          'reschedule' => $reschedule,
          'buildings' => Building::orderBy('id','desc')->get(),
          'buildingx' => Building::find($id),
          'id' => $id
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
    $reservation = RoomReservation::findOrFail($id);
    $result = RoomReservation::where('id', $reservation->termohon)->update([
        'status' => 'cancelled',
        'key_status' => 'cancelled'
    ]);
    $reservation->update(['status' => 'approved']);
    return redirect('/reservation_conditional')->with('message', 'Reservasi berhasil disetujui!👍');
  }

  public function not_approve_conditional(Request $request)
  {
    $validatedData = $request->validate([
      'note_admin' => 'nullable'
    ]);

    $validatedData['status'] = 'not approved';

    RoomReservation::findOrFail($request->input('reservation_id'))->update($validatedData);
    return redirect('/reservation_conditional')->with('message', 'Peminjaman berhasil di tolak!👍');
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
