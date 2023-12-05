<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class BuildingViewController extends Controller
{
    //
    public function index(Request $request)
    {
       $hasil = DB::table('buildings as u')
        ->select('u.*', DB::raw('COUNT(uh.building_id) AS jumlah_ruang'))
        ->where('u.building_name', 'like', "%" . $request->keyword . "%")
        ->leftJoin('rooms as uh', 'u.id', '=', 'uh.building_id')
        ->groupBy('u.id', 'u.building_name','u.checkfloor','u.floor','u.thumbnail','u.created_at','u.updated_at') 
        ->orderBy('jumlah_ruang')
        ->get();
    

        return view('content.dashboard.building_view', [
            // 'rooms' => Building::latest()->where('building_name', 'like', "%" . $request->keyword . "%")->get(),
            'total_ruang' => $hasil,

        ]);
    }
}
