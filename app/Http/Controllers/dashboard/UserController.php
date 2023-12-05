<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('content.dashboard.users', [
            'users' => User::with('department')->orderBy('id', 'desc')->get(),
            'users_verified' => User::whereNotNull('email_verified_at')->count(),
        ]);
    }

    public function create()
    {
        return view('content.dashboard.users_create', [
            'departments' => Department::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fullname' =>'required|string|max:255',
            'nim' =>'nullable|unique:users',
            'phone_number' =>'required',
            'role' =>'required',
            'email' =>'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        // Menggunakan GuzzleHttp\Client untuk mengunduh gambar
        $client = new Client();

        $response = $client->get("https://ui-avatars.com/api/?name=" . urlencode($data["fullname"]) . "&background=A5A6FF&bold=true&color=FFF&length=2");
        $avatarFileName = time() . '.png'; // Generate nama unik untuk file avatar (misalnya, menggunakan timestamp)
        $avatarPath = public_path('avatars/' . $avatarFileName); // Tentukan path lengkap untuk menyimpan file avatar

        // Simpan file avatar ke dalam folder "public/avatars"
        file_put_contents($avatarPath, $response->getBody());

        // Simpan nama file avatar ke dalam data pengguna
        $data["avatar"] = 'avatars/' . $avatarFileName;
        $data["nim"] = $request->input('nim');
        $data["department_id"] = $request->input('department_id');

        $data['password'] = bcrypt($data['password']); // Mengenkripsi password sebelum menyimpann

        $user = User::create($data);

        return redirect()->route('users.index')->with('message', 'Pengguna berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('content.dashboard.users_edit', [
            'user' => $user,
            'departments' => Department::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'fullname' =>'required',
            'email' =>'required',
            'nim' =>'nullable',
            'phone_number' =>'nullable',
            'deparment_id' =>'nullable',
            'role' =>'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048|nullable',
            'password' => 'nullable|confirmed'
        ]);

        if ($request->hasFile('avatar')) {
           // Hapus gambar lama jika ada
            if ($user->avatar) {
                // Hapus gambar lama dari sistem penyimpanan;
                if (file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }
            }
            
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('avatars'), $avatarName);
            
            $data['avatar'] = 'avatars/' . $avatarName;
        }
        

        if($request->has(['password'])) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        return redirect('users')->with('message', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect('users')->with('message', 'Data berhasil dihapus!👍');
    }

    public function profile($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        return view('content.dashboard.profile', compact('user'));
    }
    
    
    public function settings()
    {
        return view('content.dashboard.settings', [
            'departments' => Department::all()
        ]);
    }
    
    public function settings_action(Request $request, $id)
    {
        $user = User::findOrFail($id);
  
        if(auth()->user()->role == 'user') {
            $data = $request->validate([
                'fullname' =>'required|string|max:255',
                'email' =>'required|string|email|max:255|unique:users,email,'. $id,
                'phone_number' =>'required',
                'nim' =>'required_if:role,user|max:255|unique:users,nim,'. $id,
                'department_id' =>'required',
            ]);
        } else {
            $data = $request->validate([
                'fullname' =>'required|string|max:255',
                'email' =>'required|string|email|max:255|unique:users,email,'. $id,
                'nim' => [
                    'nullable',
                    Rule::unique('users')->ignore($id)->whereNotNull('nim'),
                ],
                'phone_number' => 'nullable',
                'department_id' => 'nullable',
            ]);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('avatars'), $avatarName);
            
            $data['avatar'] = 'avatars/' . $avatarName;
        }

        if ($request->hasFile('dokumen')) {
            $dokumen = $request->file('dokumen');
            $dokumenName = time() . '_' . $dokumen->getClientOriginalName();
            $dokumen->move(public_path('storage'), $dokumenName);
            
            $data['dokumen'] = 'storage/' . $dokumenName;
        }

        if($request->has('signature')) {
            $request->validate([
                'signature' => 'required',
            ]);
            $folderPath = public_path('signature/');
    
            $image_parts = explode(';base64', $request->signature);
            $image_type_aux = explode('image/', $image_parts[0]);
            
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $filename = uniqid(). '.'. $image_type;
            $file = $folderPath . $filename;
            file_put_contents($file, $image_base64);

            $data["signature"] = 'signature/' . $filename;
        }

        $user->update($data);

        return redirect('settings')->with('message', 'Profil berhasil diubah!👍');
    }

    public function delete_signature()
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->signature = null;
        $user->save();

        return redirect('settings')->with('message', 'Signature berhasil dihapus!👍');
    }
}
