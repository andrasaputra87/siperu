<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class BuildingViewConditionalController extends Controller
{
    //
    public function index(Request $request)
    {
       $hasil = DB::table('buildings as u')
        ->select('u.*', DB::raw('COUNT(uh.building_id) AS jumlah_ruang'))
        ->where('u.building_name', 'like', "%" . $request->keyword . "%")
        ->leftJoin('rooms as uh', 'u.id', '=', 'uh.building_id')
        ->groupBy('u.id', 'u.building_name','u.checkfloor','u.floor','u.thumbnail','u.created_at','u.updated_at','u.id_user') 
        ->orderBy('jumlah_ruang')
        ->get();
    

        return view('content.dashboard.building_view_conditonal', [
            // 'rooms' => Building::latest()->where('building_name', 'like', "%" . $request->keyword . "%")->get(),
            'total_ruang' => $hasil,
            'total_ruang_tersedia' => Room::where('availability',1)->count()

        ]);
    }
}
