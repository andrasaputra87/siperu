<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Building;
use App\Models\Faculty;
use App\Models\Room;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    //
    public function index(){
        if (auth()->user()->role == 'admin') {
            $building = Building::leftjoin('users','users.id','id_user')
                ->leftjoin('faculties','faculties.id','faculty_id')
                ->orderBy('buildings.id', 'desc')->get(['buildings.*','faculties.name as nama_fakultas']);
            $pengelola = User::with('faculty')->where('role', 'pengelola_gedung')->get();
        }else{

            $building = Building::leftjoin('users','users.id','id_user')
                ->leftjoin('faculties','faculties.id','faculty_id')
                ->where('faculty_id',auth()->user()->faculty_id)
                ->orderBy('buildings.id', 'desc')->get(['buildings.*','faculties.name as nama_fakultas']);
            $pengelola = User::with('faculty')->where('role', 'pengelola_gedung')->where('faculty_id',auth()->user()->faculty_id)->get();
        }
        // var_dump($building);
        return view('content.dashboard.buildings', [
            'building' => $building,
            'pengelola' => $pengelola,
            'building_edit' => '',
            'faculties' => Faculty::orderBy('id', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'id_user' =>'required',
            // 'floor' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            
        ]);
        
        $data['building_name'] = $request->name;
        $data['checkfloor'] = $request->input('checkfloor',1);
        $data['floor'] = $request->input('lantai');
        // $data['id_user'] = $request->input('pengelola_id');

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('building_images'), $thumbnailName);
            
            $data['thumbnail'] = 'building_images/' . $thumbnailName;
        }
        
        // var_dump($data);
        Building::create($data);

        return redirect('building')->with('message', 'Data berhasil dimasukkan!👍');
    }

    public function destroy(Building $building)
    {
        $data = Building::findOrFail($building->id);

            if ($data->thumbnail) {
                // Hapus gambar lama dari sistem penyimpanan;
                if (file_exists(public_path($data->thumbnail))) {
                    unlink(public_path($data->thumbnail));
                }
            }

        $data->delete();

        return redirect('building')->with('message', 'Data berhasil dihapus!🙌');
    }

    public function edit(Building $building)
    {
        if ($building) {
            if (auth()->user()->role == 'admin') {
                $buildings = Building::leftjoin('users','users.id','id_user')
                    ->leftjoin('faculties','faculties.id','faculty_id')
                    ->orderBy('buildings.id', 'desc')->get(['buildings.*','faculties.name as nama_fakultas']);
                $pengelola = User::with('faculty')->where('role', 'pengelola_gedung')->get();
            }else{
    
                $buildings = Building::leftjoin('users','users.id','id_user')
                    ->leftjoin('faculties','faculties.id','faculty_id')
                    ->where('faculty_id',auth()->user()->faculty_id)
                    ->orderBy('buildings.id', 'desc')->get(['buildings.*','faculties.name as nama_fakultas']);
                $pengelola = User::with('faculty')->where('role', 'pengelola_gedung')->where('faculty_id',auth()->user()->faculty_id)->get();
            }
            return view('content.dashboard.buildings', [
                'building_edit' => $building,
                'building' => $buildings,
                'pengelola' => $pengelola,
                'faculties' => Faculty::orderBy('id', 'desc')->get(),
                'building_edit' => $building,
            ]);
        }
    }

    public function update(Request $request, Building $building)
    {
        $data = $request->validate([
            'name' => 'required',
            // 'checkfloor' =>'required',
            // 'floor' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $data['building_name'] = $request->name;
        $data['checkfloor'] = $request->input('checkfloor',1);
        $data['floor'] = $request->input('lantai');
        $data['id_user'] = $request->input('id_user');

        if ($request->hasFile('thumbnail')) {
           // Hapus gambar lama jika ada
            if ($building->thumbnail) {
                // Hapus gambar lama dari sistem penyimpanan;
                if (file_exists(public_path($building->thumbnail))) {
                    unlink(public_path($building->thumbnail));
                }
            }
            
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('building_images'), $thumbnailName);
            
            $data['thumbnail'] = 'building_images/' . $thumbnailName;
        }
        // var_dump($data);
        $building->update($data);

        return redirect('building')->with('message', 'Data berhasil diubah!');
    }

    
}
