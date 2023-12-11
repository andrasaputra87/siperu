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
                    ->orderBy('id', 'desc')
                    ->get();
                // echo '<pre>' . var_export($reservations, true) . '</pre>';
            } elseif (auth()->user()->role == 'head_baak' || auth()->user()->role == 'staff_baak') {
                $reservations = RoomReservation::with(['room.building', 'user'])->whereHas('room', function ($query) {
                    $query->where('ownership', 'baak');
                })->orderBy('id', 'desc')->get();
            } else {
                $reservations = RoomReservation::with(['room.building', 'user'])->whereHas('room', function ($query) {
                    $query->where('ownership', 'bm');
                })->orderBy('id', 'desc')->get();
            }
        } else {
            if (auth()->user()->role == 'admin') {
                $reservations = RoomReservation::with(['room.building', 'user'])->whereBetween('reservation_date', [$startDate, $endDate])->orderBy('id', 'desc')->get();
            } elseif (auth()->user()->role == 'head_baak' || auth()->user()->role == 'staff_baak') {
                $reservations = RoomReservation::with(['room.building', 'user'])->whereBetween('reservation_date', [$startDate, $endDate])->whereHas('room', function ($query) {
                    $query->where('ownership', 'baak');
                })->orderBy('id', 'desc')->get();
            } else {
                $reservations = RoomReservation::with(['room.building', 'user'])->whereBetween('reservation_date', [$startDate, $endDate])->whereHas('room', function ($query) {
                    $query->where('ownership', 'bm');
                })->orderBy('id', 'desc')->get();
            }
        }

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
        } elseif (auth()->user()->role == 'head_baak') {
            return (new MultipleBAAKExport(Carbon::now()->year))->download('peminjaman_ruangan.xlsx');
        } else {
            return (new MultipleBMExport(Carbon::now()->year))->download('peminjaman_ruangan.xlsx');
        }
    }
}
