<?php

namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\MultipleExport;
use App\Models\RoomReservation;
use App\Exports\MultipleBMExport;
use App\Exports\MultipleBAAKExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (empty($startDate) || empty($endDate)) {
            if (auth()->user()->role == 'admin') {
                // $reservations = RoomReservation::with(['user', 'room'])->orderBy('id', 'desc')->get();
                $reservations = RoomReservation::with(['room.building', 'user'])
                ->leftjoin('rooms','rooms.id','room_id')
                ->leftjoin('buildings','buildings.id','building_id')
                ->leftjoin('users','users.id','id_user')
                ->leftjoin('faculties','faculties.id','users.faculty_id')
                    ->orderBy('room_reservations.id', 'desc')
                    ->get(['*','room_reservations.id as id_rr','faculties.name as faculty_name']);
                // echo '<pre>' . var_export($reservations, true) . '</pre>';
            } elseif (auth()->user()->role == 'head_baak' || auth()->user()->role == 'admin_fakultas') {
                $reservations = RoomReservation::with(['room.building', 'user'])
                ->leftjoin('rooms','rooms.id','room_id')
                ->leftjoin('buildings','buildings.id','building_id')
                ->leftjoin('users','users.id','id_user')
                ->leftjoin('faculties','faculties.id','users.faculty_id')
                ->whereHas('room', function ($query) {
                    $query->leftjoin('buildings','buildings.id','building_id')->where('faculty_id', auth()->user()->faculty_id);
                })->orderBy('room_reservations.id', 'desc')->get();
            } 
        } else {
            if (auth()->user()->role == 'admin') {
                $reservations = RoomReservation::with(['room.building', 'user'])
                ->leftjoin('rooms','rooms.id','room_id')
                ->leftjoin('buildings','buildings.id','building_id')
                ->leftjoin('users','users.id','id_user')
                ->leftjoin('faculties','faculties.id','users.faculty_id')
                ->whereBetween('reservation_date', [$startDate, $endDate])->orderBy('room_reservations.id', 'desc')->get(['*','room_reservations.id as id_rr','faculties.name as faculty_name']);
            } elseif (auth()->user()->role == 'head_baak' || auth()->user()->role == 'admin_fakultas') {
                $reservations = RoomReservation::with(['room.building', 'user'])
                ->leftjoin('rooms','rooms.id','room_id')
                ->leftjoin('buildings','buildings.id','building_id')
                ->leftjoin('users','users.id','id_user')
                ->leftjoin('faculties','faculties.id','users.faculty_id')
                ->whereBetween('reservation_date', [$startDate, $endDate])->whereHas('room', function ($query) {
                    $query->leftjoin('buildings','buildings.id','building_id')->where('faculty_id', auth()->user()->faculty_id);
                })->orderBy('room_reservations.id', 'desc')->get(['*','room_reservations.id as id_rr','faculties.name as faculty_name']);
            }
        }
        // var_dump($reservations);
        return view('content.dashboard.report', [
            'reservations' => $reservations,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function export()
    {
        if (auth()->user()->role == 'admin') {
            return (new MultipleExport(Carbon::now()->year))->download('peminjaman_ruangan.xlsx');
        } elseif (auth()->user()->role == 'head_baak' || auth()->user()->role == 'admin_fakultas') {
            return (new MultipleBAAKExport(Carbon::now()->year))->download('peminjaman_ruangan.xlsx');
        }
    }
}
