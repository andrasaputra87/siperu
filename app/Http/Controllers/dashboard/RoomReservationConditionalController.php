<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Building;
use App\Models\RoomReservation;
use App\Models\Department;
use App\Models\User;
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

  public function allruangan(Request $request, $id, $floor=NULL)
  {
    $building = Building::find($id);
    if($floor!=NULL){
      return view('content.dashboard.room_reservation', [
        'rooms' => Room::latest()->where('building_id', $id)->where('location',$floor)->get(),
        'building_id'=>$id,
        'building'=>$building
      ]);
    }else{
      return view('content.dashboard.room_reservation', [
        'rooms' => Room::latest()->where('building_id', $id)->get(),
        'building_id'=>$id,
        'building'=>$building
      ]);
    }
    
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
    if ($request->has('baak')) {
      $data = $request->validate([
        'reservation_date' => 'required',
        'start_time' => 'required',
        'necessary' => 'required',
        'room_id' => 'required',
        'sks' => 'required',
      ]);
      $data['user_id'] = Auth()->user()->id;
    } else {
      $data = $request->validate([
        'reservation_date' => 'required',
        'start_time' => 'required',
        'necessary' => 'required',
        'room_id' => 'required',
        'organization_name' => 'required',
        'total_participants' => 'required',
        'sks' => 'required',
      ]);

      $data['user_id'] = Auth()->user()->id;
      $data['building_officer'] = $request->building_officer;
      $data['security_officer'] = $request->security_officer;
      $data['clean_officer'] = $request->clean_officer;
      $data['logistic_officer'] = $request->logistic_officer;
      $data['etc_officer'] = $request->etc_officer;
      $data['note'] = $request->note;

      if ($request->has('signature')) {
        $request->validate([
          'signature' => 'required',
        ]);

        $folderPath = public_path('signature/');

        $image_parts = explode(';base64', $request->signature);
        $image_type_aux = explode('image/', $image_parts[0]);

        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $filename = uniqid() . '.' . $image_type;
        $file = $folderPath . $filename;
        file_put_contents($file, $image_base64);

        $data_user["signature"] = 'signature/' . $filename;

        $user = User::findOrFail(auth()->user()->id);
        $user->update($data_user);
      }
    }
    $start_time = Session::findOrFail($request->start_time);
    if ($request->sks == 2) {
      $end_time = Carbon::parse($start_time->start)->addMinutes(90)->toTimeString();
    } elseif ($request->sks == 3) {
      $end_time = Carbon::parse($start_time->start)->addMinutes(135)->toTimeString();
    } else {
      $end_time = Carbon::parse($start_time->start)->addMinutes(180)->toTimeString();
    }
    $temp_date = $request->reservation_date;
    $data['end_time'] = $end_time;
    $data['conditional'] = true;
    $data['termohon'] = RoomReservation::where('reservation_date', $request->reservation_date)->where('status', '!=', 'cancelled')->first()->id;
    // if ( $request->has('recurring')) {
    //   $tahun_ajaran = TahunAjaran::findOrFail($start_time->id_tahun_ajaran);
    //   $recurring = $request->reservation_date;

    //   for ($i=0; $temp_date < $tahun_ajaran->end_tahun_ajaran; $i++) { 
    //     if(RoomReservation::where('reservation_date',$temp_date)->where('start_time',$request->start_time)->count()==0){
    //       $data['reservation_date'] = $temp_date;
    //       $data['recurring'] = $recurring;
    //       RoomReservation::create($data);
    //     }
    //     // var_dump($data);
    //     $temp_date = Carbon::parse($temp_date)->addDays(7)->toDateString();
    //   }
    //   return redirect('room_reservation')->with('message', 'Berhasil meminjam ruangan! Silahkan menunggu untuk dikonfirmasi.');
    // }else{
    RoomReservation::create($data);
    return redirect('building_view_conditonal')->with('message', 'Berhasil meminjam ruangan! Silahkan menunggu untuk dikonfirmasi.');
    // }
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

  public function get(Request $request)
  {
    $date = Carbon::parse($request->date)->format('d-m-Y');
    $dayName = strtolower(substr(Carbon::parse($date)->dayName, 0, 3));
    if (HariLibur::date($date)->isHoliday()) {
      return response()->json([
        'success' => false,
        'data'    => 'Tanggal yang dipilih tanggal merah yaitu "' . HariLibur::date($date)->getInfo() . '"'
      ]);
    } elseif ($dayName == 'sun') {
      return response()->json([
        'success' => false,
        'data'    => 'Tanggal yang dipilih tanggal merah yaitu Hari Minggu'
      ]);
    } else {
      $get = RoomReservation::leftjoin('sessions', 'room_reservations.start_time', '=', 'sessions.id')
        ->where('reservation_date', '=', $request->date)
        ->get(['sessions.id']);
      $data = Session::select('*')->whereIn('id', RoomReservation::leftjoin('sessions', 'room_reservations.start_time', '=', 'sessions.id')
        ->where('reservation_date', '=', $request->date)
        ->where('room_id', '=', $request->id_room)
        ->get(['sessions.id']))
        ->where($dayName, '=', '1')
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
