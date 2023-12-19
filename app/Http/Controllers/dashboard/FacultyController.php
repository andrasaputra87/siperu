<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.faculties', [
            'faculties' => Faculty::orderBy('id', 'desc')->get(),
            'faculty_edit' => '',
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'dekan' => 'required',
        ]);

        Faculty::create($data);

        return redirect('faculties')->with('message', 'Data berhasil dimasukkan!👍');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        if ($faculty) {
            return view('content.dashboard.faculties', [
                'faculty_edit' => $faculty,
                'faculties' => Faculty::orderBy('id', 'desc')->get(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        $data = $request->validate([
            'name' =>'required',
            'dekan' =>'required',
        ]);

        $faculty->update($data);

        return redirect('faculties')->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        $data = Faculty::findOrFail($faculty->id);

        $data->delete();

        return redirect('faculties')->with('message', 'Data berhasil dihapus!🙌');
    }
}
