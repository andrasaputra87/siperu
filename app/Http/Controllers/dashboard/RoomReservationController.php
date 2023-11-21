<?php

namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\RoomReservation;
use App\Exports\ReservationExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreRoomReservationRequest;
use App\Http\Requests\UpdateRoomReservationRequest;

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
   * @param  \App\Http\Requests\StoreRoomReservationRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRoomReservationRequest $request)
  {
    if ($request->has('baak')) {
      $data = $request->validate([
        'reservation_date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'necessary' => 'required',
        'guarantee' => 'required',
        'room_id' => 'required',
      ]);
      $data['user_id'] = Auth()->user()->id;
    } else {
      $data = $request->validate([
        'reservation_date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'necessary' => 'required',
        'guarantee' => 'required',
        'room_id' => 'required',
        'organization_name' => 'required',
        'total_participants' => 'required'
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

    RoomReservation::create($data);

    // $room = Room::findOrFail($data['room_id']);
    // $room->availability = 0;
    // $room->save();

    return redirect('room_reservation')->with('message', 'Berhasil meminjam ruangan! Silahkan menunggu untuk dikonfirmasi.');
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

    return view('content.dashboard.room_reservation_create', [
      'room' => $room,
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
