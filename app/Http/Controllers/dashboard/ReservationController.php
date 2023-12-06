<?php

namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Department;
use App\Models\TahunAjaran;
use App\Models\Session;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\RoomReservation;
use App\Events\ReservationApproved;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{

  public function index()
  {
    if (auth()->user()->role == 'admin') {
      $reservations = RoomReservation::with(['user', 'room'])->where('conditional',0)->orderBy('status', 'asc')->orderBy('id', 'asc')->get();
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

    return view('content.dashboard.reservation_data', [
      'reservations' => $reservations,
      'reservation_total' => $reservation_total,
      'reservation_approved' => $reservation_approved,
      'reservation_not_approved' => $reservation_not_approved,
      'reservation_cancelled' => $reservation_cancelled,
      'reschedule' => $reschedule,
    ]);
  }

  public function approve($id)
  {
    $reservation = RoomReservation::findOrFail($id);

    // Pengecekan apakah ada reservasi yang sudah diapprove pada rentang tanggal yang sama
    // $existingApprovedReservations = RoomReservation::where('status', 'approved')
    //   ->where('key_status', null)
    //   ->where('room_id', $reservation->room_id)
    //   ->where(function ($query) use ($reservation) {
    //     $query->where(function ($subquery) use ($reservation) {
    //       $subquery->where('start_time', '>=', $reservation->start_time)
    //         ->where('start_time', '<=', $reservation->end_time);
    //     })->orWhere(function ($subquery) use ($reservation) {
    //       $subquery->where('end_time', '>=', $reservation->start_time)
    //         ->where('end_time', '<=', $reservation->end_time);
    //     })->orWhere(function ($subquery) use ($reservation) {
    //       $subquery->where('reservation_date', $reservation->reservation_date);
    //     });
    //   })
    //   ->exists();

    // if (!$existingApprovedReservations) {
      if($reservation->recurring!=NULL){
        RoomReservation::whereIn('id',RoomReservation::where('recurring', $reservation->reservation_date)->get(['id']))
          ->update(['status' => 'approved']);
        return redirect('/reservation')->with('message', 'Reservasi berhasil disetujui!👍');
      }else{
        $reservation->update(['status' => 'approved']);
        return redirect('/reservation')->with('message', 'Reservasi berhasil disetujui!👍');
      }
    // } else {
    //   $reservation->update(['status' => 'reschedule']);
    //   return redirect('/reservation')
    //     ->with('message_error', 'Reservasi gagal di setujui karena ada reservasi lain yang sudah di setujui pada rentang tanggal yang sama.')
    //     ->withInput();
    // }
  }

  public function open($id)
  {
    $reservation = RoomReservation::findOrFail($id);
    $reservation->update(['status' => 'opened']);
    return redirect('/reservation')->with('message', 'Reservasi berhasil dibuka!👍');
      
  }

  public function offday($id)
  {
    $reservation = RoomReservation::findOrFail($id);
    $reservation->update(['status' => 'off-day']);
    return redirect('/reservation')->with('message', 'Reservasi berhasil dibatalkan!👍');
      
  }

  public function not_approve(Request $request)
  {
    $validatedData = $request->validate([
      'note_admin' => 'nullable'
    ]);

    $validatedData['status'] = 'not approved';

    RoomReservation::findOrFail($request->input('reservation_id'))->update($validatedData);
    return redirect('/reservation')->with('message', 'Peminjaman berhasil di tolak!👍');
  }

  public function returned($id)
  {
    $reservation = RoomReservation::findOrFail($id);
    $reservation->update(['status' => 'returned']);

    return redirect('/reservation')->with('message', 'Anda Sudah Menerima Kunci!👍');
  }


  public function my_reservation()
  {
    return view('content.dashboard.my_reservation', [
      'reservations' => RoomReservation::with(['user', 'room','session'])->orderBy('id', 'desc')->where('user_id', Auth()->user()->id)->get(),
      'reservations_approved' => RoomReservation::where('user_id', Auth()->user()->id)->where('status', 'approved')->count(),
      'reservations_not_approved' => RoomReservation::where('user_id', Auth()->user()->id)->where('status', 'not approved')->count(),
      'reservations_cancelled' => RoomReservation::where('user_id', Auth()->user()->id)->where('status', 'cancelled')->count(),
      'reschedule' => RoomReservation::where('user_id', Auth()->user()->id)->where('status','reschedule')->count(),
    ]);
  }

  public function detail($date, $start_time)
  {
    return view('content.dashboard.detail', [
      'reservations' => RoomReservation::with(['user', 'room','session'])->orderBy('id', 'desc')->where('recurring', $date)->where('start_time',$start_time)->get(),
      'reservations_approved' => RoomReservation::where('user_id', Auth()->user()->id)->where('status', 'approved')->count(),
      'reservations_not_approved' => RoomReservation::where('user_id', Auth()->user()->id)->where('status', 'not approved')->count(),
      'reservations_cancelled' => RoomReservation::where('user_id', Auth()->user()->id)->where('status', 'cancelled')->count(),
      'reschedule' => RoomReservation::where('user_id', Auth()->user()->id)->where('status','reschedule')->count(),
    ]);
  }


  public function return($id, $room_id)
  {
    $reservation = RoomReservation::findOrFail($id);
    $reservation->status = 'wait';
    $reservation->key_status = 'returned';
    $reservation->save();

    $room = Room::findOrFail($room_id);
    $room->availability = '1';
    $room->save();
    return redirect('/my_reservation')->with('message', 'Anda berhasil mengembalikan ruangan! Kembalikan Kunci Ke Tempat Asal👍');
  }



  public function cancel($id, $room_id)
  {
    $reservation = RoomReservation::findOrFail($id);
    $reservation->status = 'cancelled';
    $reservation->key_status = 'cancelled';
    $reservation->save();

    if($reservation->recurring!=null){
      RoomReservation::whereIn('id',RoomReservation::where('recurring', $reservation->reservation_date)->get(['id']))
        ->update(['status' => 'cancelled','key_status' => 'cancelled']);
      return redirect('/my_reservation')->with('message', 'Reservasi berhasil disetujui!👍');
    }else{
      $room = Room::findOrFail($room_id);
      $room->availability = '1';
      $room->save();
      return redirect('/my_reservation')->with('message', 'Anda berhasil membatalkan pinjam ruangan!👍');
    }
  }

  public function history()
  {
    return view('content.dashboard.history', [
      'reservations' => RoomReservation::with(['user', 'room'])->orderBy('id', 'desc')->where('user_id', Auth()->user()->id)->get(),
    ]);
  }

  public function show($id)
  {
    $today = Carbon::today()->format('Y-m-d');
    $room = RoomReservation::findOrFail($id);

    return view('content.dashboard.room_reservation_reschedule', [
      'reservation' => $room,
      'departments' => Department::all(),
      'list_reservation' => RoomReservation::latest()->where('room_id', $id)->where('reservation_date', $today)->where(function ($query) {
        $query->where('status', 'pending')
          ->orWhere('status', 'approved');
      })->get()
    ]);
  }

  public function change_sks($id)
  {
    $today = Carbon::today()->format('Y-m-d');
    $room = RoomReservation::findOrFail($id);

    return view('content.dashboard.room_reservation_change_sks', [
      'reservation' => $room,
      'departments' => Department::all(),
      'list_reservation' => RoomReservation::latest()->where('room_id', $id)->where('reservation_date', $today)->where(function ($query) {
        $query->where('status', 'pending')
          ->orWhere('status', 'approved');
      })->get()
    ]);
  }

  public function update(Request $request, $id)
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
    if($request->sks==2){
      $end_time = Carbon::parse($start_time->start)->addMinutes(90)->toTimeString();
    }elseif($request->sks==3){
      $end_time = Carbon::parse($start_time->start)->addMinutes(135)->toTimeString();
    }else{
      $end_time = Carbon::parse($start_time->start)->addMinutes(180)->toTimeString();
    }
    $temp_date = $request->reservation_date;

    $data['end_time'] = $end_time;
    $reservation = RoomReservation::findOrFail($id);
// var_dump($reservation->recurring);
    if ( $reservation->reservation_date == $reservation->recurring) {
      RoomReservation::whereIn('id',RoomReservation::where('recurring', $reservation->reservation_date)->get(['id']))
        ->update(['status' => 'cancelled','key_status' => 'cancelled']);
      $tahun_ajaran = TahunAjaran::findOrFail($start_time->id_tahun_ajaran);
      $recurring = $request->reservation_date;

      for ($i=0; $temp_date < $tahun_ajaran->end_tahun_ajaran; $i++) { 
        if(RoomReservation::where('reservation_date',$temp_date)->where('start_time',$request->start_time)->count()==0){
          $data['reservation_date'] = $temp_date;
          $data['recurring'] = $recurring;
          RoomReservation::create($data);
        }
        // var_dump($data);
        $temp_date = Carbon::parse($temp_date)->addDays(7)->toDateString();
      }
      return redirect('my_reservation')->with('message', 'Berhasil Mengatur Ulang Jadwal.');
    }else{
      $reservation = RoomReservation::findOrFail($id);
      $reservation->update(array_merge(['status' => 'pending'], $data)); 
  
      return redirect('my_reservation')->with('message', 'Berhasil Mengatur Ulang Jadwal.');
    }

  }

  public function update_sks(Request $request, $id)
  {

    if ($request->has('baak')) {

    } else {
      $data = $request->validate([
        'reservation_date' => 'required',
        'start_time' => 'required',
        // 'end_time' => 'required|after:start_time',
        'necessary' => 'required',
        // 'guarantee' => 'required',
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
    $reservation = RoomReservation::findOrFail($id);

    $start_time = Session::findOrFail($reservation->start_time);
    if($request->sks==2){
      $end_time = Carbon::parse($start_time->start)->addMinutes(90)->toTimeString();
    }elseif($request->sks==3){
      $end_time = Carbon::parse($start_time->start)->addMinutes(135)->toTimeString();
    }else{
      $end_time = Carbon::parse($start_time->start)->addMinutes(180)->toTimeString();
    }
    $data['end_time'] = $end_time;

    if($reservation->recurring!=null){
      RoomReservation::whereIn('id',RoomReservation::where('recurring', $reservation->reservation_date)->get(['id']))
        ->update(array_merge( $data));
      return redirect('/my_reservation')->with('message', 'Reservasi berhasil disetujui!👍');
    }else{
      $reservation->update(array_merge( $data));
      return redirect('my_reservation')->with('message', 'Berhasil Mengubah Data.');
    }
  }
}