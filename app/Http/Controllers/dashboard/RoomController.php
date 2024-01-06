<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Building;
use App\Models\Room;
use App\Models\Faculty;
use App\Models\RoomImages;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $building = Building::orderBy('id', 'desc')->get();
            $room = Room::with(['building'])
            ->orderBy('id', 'desc')->get();
            $room_available = Room::where('availability', '1')->count();
            $room_not_available = Room::where('availability', '0')->count();
        }else{
            $query = User::where('faculty_id', auth()->user()->faculty_id)->where('role','pengelola_gedung')->first();

            $id_pengelola = $query==NULL ? '' : $query->id;
            $building = Building::where('id_user',$id_pengelola)
                ->orderBy('buildings.id', 'desc')->get();
            $room = Room::with(['building'])
            ->leftJoin('buildings','buildings.id','building_id')
            ->where('id_user',$id_pengelola)
            ->orderBy('rooms.id', 'desc')->get();
            $room_available = Room::where('availability', '1')->leftJoin('buildings','buildings.id','building_id')
            ->where('id_user',$id_pengelola)
            ->orderBy('rooms.id', 'desc')->count();
            $room_not_available = Room::where('availability', '0')->leftJoin('buildings','buildings.id','building_id')
            ->where('id_user',$id_pengelola)
            ->orderBy('rooms.id', 'desc')->count();
        }
        return view('content.dashboard.rooms', [
            'building' => $building,
            'rooms' => $room,
            'room_edit' => '',
            'room_available' => $room_available,
            'room_not_available' => $room_not_available,
        ]);
        // var_dump($building);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'capacity' => 'required',
            // 'location' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
        if ($request->input('location') == NULL) {
            $data['location'] = "";
        } else {
            $data['location'] = $request->input('location');
        }

        $data['building_id'] = $request->input('building');
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('room_images'), $thumbnailName);

            $data['thumbnail'] = 'room_images/' . $thumbnailName;
        }

        // var_dump($data);
        Room::create($data);

        return redirect('rooms')->with('message', 'Data berhasil dimasukkan!👍');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);

        return view('content.dashboard.room_detail', [
            'room' => $room,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        if ($room) {
            return view('content.dashboard.rooms', [
                'room_edit' => $room,
                'building' => Building::orderBy('id', 'desc')->get(),
                'rooms' => Room::with('building')->orderBy('id', 'desc')->get(),
                'room_available' => Room::where('availability', '1')->count(),
                'room_not_available' => Room::where('availability', '0')->count(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required',
            'capacity' => 'required',
            // 'location' => 'required',
            'description' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
        if ($request->input('location') == NULL) {
            $data['location'] = "";
        } else {
            $data['location'] = $request->input('location');
        }

        $data['building_id'] = $request->input('building');
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama jika ada
            if ($room->thumbnail) {
                // Hapus gambar lama dari sistem penyimpanan;
                if (file_exists(public_path($room->thumbnail))) {
                    unlink(public_path($room->thumbnail));
                }
            }

            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('room_images'), $thumbnailName);

            $data['thumbnail'] = 'room_images/' . $thumbnailName;
        }

        $room->update($data);

        return redirect('rooms')->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $data = Room::findOrFail($room->id);

        if ($data->thumbnail) {
            // Hapus gambar lama dari sistem penyimpanan;
            if (file_exists(public_path($data->thumbnail))) {
                unlink(public_path($data->thumbnail));
            }
        }

        $data->delete();

        return redirect('rooms')->with('message', 'Data berhasil dihapus!🙌');
    }

    public function add_slider($id)
    {
        return view('content.dashboard.add_slider', [
            'room' => Room::with(['roomImages' => function ($query) {
                $query->orderBy('id', 'desc');
            }])->findOrFail($id)
        ]);
    }

    public function upload_slider(Request $request, $id)
    {
        $image = $request->file('file');
        $imageName = time() . rand(1, 100) . '.' . $image->extension();
        $image->move(public_path('slider-images'), $imageName);

        $data = [
            'filename' => 'slider-images/' . $imageName,
            'room_id' => $id
        ];

        RoomImages::create($data);

        return response()->json(['success' => $imageName]);
    }

    public function delete_slider($id)
    {
        $data = RoomImages::findOrFail($id);

        if ($data->filename) {
            // Hapus gambar lama dari sistem penyimpanan;
            if (file_exists(public_path($data->filename))) {
                unlink(public_path($data->filename));
            }
        }

        $data->delete();

        return redirect()->back()->with('message', 'Foto slider berhasil dihapus');
    }
}
