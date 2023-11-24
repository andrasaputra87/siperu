<?php

namespace App\Http\Controllers\dashboard;

use App\Models\TahunAjaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class YearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.years', [
            'tahun_ajaran' => TahunAjaran::orderBy('id', 'desc')->get(),
            'tahun_ajaran_edit' => '',
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
            'tahun_ajaran' => 'required',
            'start_tahun_ajaran' => 'required',
            'end_tahun_ajaran' => 'required',
        ]);

        TahunAjaran::create($data);

        return redirect('years')->with('message', 'Data berhasil dimasukkan!👍');
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
    public function edit($id)
    {
        if ($id) {
            return view('content.dashboard.years', [
                'tahun_ajaran_edit' => TahunAjaran::find($id),
                'tahun_ajaran' => TahunAjaran::orderBy('id', 'desc')->get(),
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
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tahun_ajaran' =>'required',
        ]);
        $post = TahunAjaran::find($id);
        $post->tahun_ajaran = $request->tahun_ajaran;
        $post->update();

        return redirect('years')->with('message', 'Data berhasil diubah!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function set(Request $request, $id)
    {
        $post = TahunAjaran::find($id);
        $post->status = 1;
        $post->update();

        TahunAjaran::where('id', '!=', $id)->update(['status' => 0]);

        return redirect('years')->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = TahunAjaran::findOrFail($id);

        $data->delete();

        return redirect('years')->with('message', 'Data berhasil dihapus!🙌');
    }
}
