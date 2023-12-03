<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Room;

class BuildingViewController extends Controller
{
    //
    public function index(Request $request)
    {
        $room = Building::first();
        // echo "<prev>";
        // var_dump($room);
        // echo "</prev>";
        $total_ruang = Room::where('building_id',$room['id'])->count();
        return view('content.dashboard.building_view', [
            'rooms' => Building::latest()->where('building_name', 'like', "%" . $request->keyword . "%")->get(),
            'total_ruang' => $total_ruang,
         
        ]);
    }

}
