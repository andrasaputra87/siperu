<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Session;
use App\Models\TahunAjaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('content.dashboard.sessions', [
            'tahun_ajarans' => TahunAjaran::latest()->where('tahun_ajaran', 'like', "%" . $request->keyword . "%")
              ->get(),
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
            'start' => 'required',
            'end' => 'required',
            'id_tahun_ajaran' => 'required'
        ]);
        
        if($request->start<$request->end){
            $start= $request->start;
            // $request->end;
            for ($i=1; Carbon::parse($start)->addMinutes(135)->toTimeString() < $request->end; $i++) { 
                $data2 = ([
                    'start' => $start,
                    'id_tahun_ajaran' => $request->id_tahun_ajaran,
                    'nama' => 'Sesi '.$i
                ]);
                // var_dump($data2);
                Session::create($data2);
                $time = Carbon::parse($start);
                $updatedTime = $time->addMinutes(135);
                $start = $updatedTime->toTimeString(); // Output: 13:45:00
            }
        }else{
                return redirect('sessions/'.$request->id_tahun_ajaran)->with('message_danger', 'Sesi waktu tutup harus lebih besar dari sesi waktu awal!');

        }
        return redirect('sessions/'.$request->id_tahun_ajaran)->with('message', 'Data berhasil dimasukkan!👍');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('content.dashboard.sessions_create', [
            'sessions' => Session::orderBy('id', 'desc')->where('id_tahun_ajaran',$id)->get(),
            'tahun_ajaran_id' => $id,
            'sessions_edit' => '',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        if ($session) {
            return view('content.dashboard.sessions_create', [
                'sessions_edit' => $session,
                'sessions' => Session::orderBy('id', 'desc')->get(),
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
    public function update(Request $request, Session $session)
    {
        $data = $request->validate([
            'mon' =>'required',
            'tue' =>'required',
            'wed' =>'required',
            'thu' =>'required',
            'fri' =>'required',
            'sat' =>'required',
            'status' =>'required',
        ]);

        $session->update($data);

        return redirect('sessions/'.$session->id_tahun_ajaran)->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        $data = Session::findOrFail($session->id);
        // var_dump($session->id_tahun_ajaran);
        $data->delete();
  
        return redirect('sessions/'.$session->id_tahun_ajaran)->with('message', 'Data berhasil dihapus!🙌');
    //     return redirect()->route('sessions.show', ['id_tahun_ajaran' => $session->id_tahun_ajaran])
    // ->with('message', 'Data berhasil dihapus!🙌');

    }
}
