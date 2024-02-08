<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardC extends Controller
{
    public function getTodayDetails()
    {
        $today = Carbon::now();

        $dayName = $today->format('l');
        $monthName = $today->format('F');

        return [
            'dayName' => $dayName,
            'monthName' => $monthName,
        ];
    }

    public function getTodayDate()
    {
        $todayDate = Carbon::now()->format('d/m/y');
X
        return $todayDate;
    }

    public function index()
    {
        $subtitle = "Dashboard Pages";
        $todayDetails = $this->getTodayDetails();
        $todayDate = $this->getTodayDate();

        return view('dashboard' , compact('subtitle','todayDetails','todayDate'));

    }
}
