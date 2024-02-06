<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $subtitle = "Daftar Pengguna";
        return view('users', compact('users','subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subtitle = "userscreate";
        return view('create.userscreate',compact('subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'nama' => 'required',
            'role' => 'required',
            
        ]);

        $users = new User([
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'nama' => $validatedData['nama'],
            'role' => $validatedData['role'],
        ]);

        $users->save();

        return redirect()->route('users.index')->with('success', 'Data users berhasil di tambahkan.');
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
        $users = User::find($id);
        $subtitle = "users";
        return view('edit.usersedit', compact('users','subtitle'));
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
        $users = User::findOrFail($id);

        $users->update([
            'nama' => $request->nama,
            'username' => $request->username,       
            'role' => $request->role,  
           
        ]);
        // Redirect ke halaman yang sesuai setelah data berhasil diupdate
        return redirect()->route('users.index')->with('success', 'Data users berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('users.index')->with('success', 'Data users berhasil di hapus.');
    }
    public function changepassword($id)
    {
        $subtitle = "Edit Kata Sandi Pengguna";
        $users = User::find($id);
        return view('userschangepassword', compact('subtitle','users'));
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

        return redirect()->route('users.index')->with('success', 'Password berhasil diupdate.');
    }
}
