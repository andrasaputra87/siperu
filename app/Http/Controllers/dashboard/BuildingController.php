<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Building;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    //
    public function index(){
        return view('content.dashboard.buildings', [
            'building' => Building::orderBy('id', 'desc')->get(),
            'building_edit' => '',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            // 'checkfloor' =>'required',
            // 'floor' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            
        ]);
        
        $data['building_name'] = $request->name;
        $data['checkfloor'] = $request->input('checkfloor',1);
        $data['floor'] = $request->input('lantai');

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
            return view('content.dashboard.buildings', [
                'building_edit' => $building,
                'building' => Building::orderBy('id', 'desc')->get(),
                
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
