<?php

namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Building;
use App\Models\User;
use App\Models\Session;
use App\Models\Department;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Models\RoomReservation;
use App\Exports\ReservationExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreRoomReservationRequest;
use App\Http\Requests\UpdateRoomReservationRequest;
use Irfa\HariLibur\Facades\HariLibur;

class RoomReservationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return view('content.dashboard.room_reservation', [
      'rooms' => Room::latest()->where('name', 'like', "%" . $request->keyword . "%")
        // ->orWhere('ownership', 'like', "%" . $request->keyword . "%")
        ->orWhere('location', 'like', "%" . $request->keyword . "%")
      ->where('building_id', $request->building_id)->get(),
    ]);
  }

  public function allruangan(Request $request, $id, $floor=NULL)
  { 
    $building = Building::find($id);
    if($floor!=NULL){
      return view('content.dashboard.room_reservation', [
        'rooms' => Room::latest()->where('building_id', $id)->where('location',$floor)->where('availability',1)->get(),
        'building_id'=>$id,
        'building'=>$building
      ]);
    }else{
      return view('content.dashboard.room_reservation', [
        'rooms' => Room::latest()->where('building_id', $id)->where('availability',1)->get(),
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
   * @param  \App\Http\Requests\StoreRoomReservationRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRoomReservationRequest $request)
  {
    if ($request->has('baak')) {
      $data = $request->validate([
        'reservation_date' => 'required',
        'start_time' => 'required',
        'necessary' => 'required',
        'room_id' => 'required',
        'sks' => 'required',
      ]);
      // $data['jurusan'] = $request->jurusan_id;
      // $data['user_id'] = Auth()->user()->id; $userId = NamaModel::where('nama_kolom', $nilai)->pluck('id_user')->first();

      $data['user_id'] = User::where('department_id',$request->jurusan_id)->pluck('id')->first();
    } else {
      $data = $request->validate([
        'reservation_date' => 'required',
        'start_time' => 'required',
        'necessary' => 'required',
        'room_id' => 'required',
        'sks' => 'required',
      ]);

      $data['user_id'] = Auth()->user()->id;
      // $data['jurusan'] = $request->jurusan_id;
      $data['building_officer'] = $request->building_officer;
      $data['security_officer'] = $request->security_officer;
      $data['clean_officer'] = $request->clean_officer;
      $data['logistic_officer'] = $request->logistic_officer;
      $data['etc_officer'] = $request->etc_officer;
      $data['note'] = $request->note;
      $data['day'] = date('D',strtotime($request->reservation_date));


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

    // var_dump($request->hasFile('file_upload'));
      if ($request->hasFile('file_upload')) {
        $file_upload = $request->file('file_upload');
        $file_upload_name = time() . '_' . $file_upload->getClientOriginalName();
        $file_upload->move(public_path('storage'), $file_upload_name);
        $data['file_upload'] = 'storage/surat_permohonan/' . $file_upload_name;
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
    if ($request->has('recurring')) {
      $tahun_ajaran = TahunAjaran::where('id',$start_time->id_tahun_ajaran)->where('status','1')->first();
      // var_dump($tahun_ajaran);
      $recurring = $request->reservation_date;
      $recurring_time = $request->start_time;
      // echo "$tahun_ajaran->end_tahun_ajaran";
      for ($i = 0; $temp_date < $tahun_ajaran->end_tahun_ajaran; $i++) {
        if (RoomReservation::where('reservation_date', $temp_date)->where('start_time', $request->start_time)->count() == 0) {
          $data['reservation_date'] = $temp_date;
          $data['recurring'] = $recurring;
          $data['recurring_time'] = $recurring_time;
          RoomReservation::create($data);
        }
        // var_dump($data);
        $temp_date = Carbon::parse($temp_date)->addDays(7)->toDateString();
      }
      return redirect('building_view')->with('message', 'Berhasil meminjam ruangan! Silahkan menunggu untuk dikonfirmasi.');
    } else {
      // var_dump($data);
      RoomReservation::create($data);
      
      return redirect('building_view')->with('message', 'Berhasil meminjam ruangan! Silahkan menunggu untuk dikonfirmasi.');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\RoomReservation  $roomReservation
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $today = Carbon::today()->format('Y-m-d');
    $room = Room::findOrFail($id);
    $jurusan = Department::where('faculty_id',auth()->user()->faculty_id)->get();
    // echo auth()->user()->faculty_id;
    return view('content.dashboard.room_reservation_create', [
      'room' => $room,
      'jurusan' =>$jurusan,
      'departments' => Department::all(),
      'list_reservation' => RoomReservation::latest()->where('room_id', $id)->where('reservation_date', $today)->where(function ($query) {
        $query->where('status', 'pending')
          ->orWhere('status', 'approved');
      })->get()
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\RoomReservation  $roomReservation
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
  }

  public function get(Request $request)
  {
    $id_tahunajaran = TahunAjaran::where('status','1')->first();
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
      $data = Session::select('*')->whereNotIn('id', RoomReservation::leftjoin('sessions', 'room_reservations.start_time', '=', 'sessions.id')
        ->where('reservation_date', '=', $request->date)
        ->where('room_id', '=', $request->id_room)
        ->get(['sessions.id']))
        ->where($dayName, '=', '1')
        ->where('id_tahun_ajaran', $id_tahunajaran->id)
        ->get();

      return response()->json([
        'success' => true,
        'data'    => $data
      ]);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateRoomReservationRequest  $request
   * @param  \App\Models\RoomReservation  $roomReservation
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRoomReservationRequest $request, RoomReservation $roomReservation)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\RoomReservation  $roomReservation
   * @return \Illuminate\Http\Response
   */
  public function destroy(RoomReservation $roomReservation)
  {
    //
  }

  public function complete_personal_data(Request $request, $id)
  {

    $validatedData = $request->validate([
      'nim' => 'required',
      'phone_number' => 'required',
      'department_id' => 'required|exists:departments,id'
    ]);

    $user = User::findOrFail($id);
    $user->update($validatedData);

    return redirect()->back()->with('message', 'Berhasil mengubah data. Nikmati layanan kami!👍');
  }
}
