<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileC extends Controller
{
    public function index()
    {
        $subtitle = "Profile Pages";
        $profile = User::all();
        return view('profile', compact('profile','subtitle'));
        
    }
    public function edit($id)
    {
        $users = User::find($id);
        $subtitle = "users";
        return view('edit.profileedit', compact('users','subtitle'));
    }

    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);

        $users->update([
            'nama' => $request->nama,
            'username' => $request->username,       
            'role' => $request->role,  
           
        ]);
        // Redirect ke halaman yang sesuai setelah data berhasil diupdate
        return redirect()->route('profile.index')->with('success', 'Data users berhasil di update.');
    }
    public function changepassword($id)
    {
        $subtitle = "Edit Kata Sandi Pengguna";
        $users = User::find($id);
        return view('edit.profilechangepassword', compact('subtitle','users'));
    }

    public function change(request $request, $id)
    {
        $request->validate([
            'password_new' => 'required',
            'password_confirm' => 'required|same:password_new',
        ]);
        $users = User::where("id",$id)->first();
        $users->update([
            'password' => Hash::make($request->password_new),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password berhasil diupdate.');
    }
    
}
