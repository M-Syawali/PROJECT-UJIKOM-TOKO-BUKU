<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogM;
use Illuminate\Support\Facades\Auth;

class LogC extends Controller
{
    public function index()
    {
        $logM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melihat Halaman log'
        ]);
    
        $subtitle = "Daftar Aktivitas";
        $logM = LogM::select('users.*','log.*')
        ->join('users','users.id','=','log.id_user')
        ->orderBy('log.id','desc')
        ->get();
        return view('log',compact('subtitle','logM'));
    }
}
