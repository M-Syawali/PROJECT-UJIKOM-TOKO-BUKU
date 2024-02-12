<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TransactionsM;
use Carbon\Carbon;
use PDF;

class LaporanC extends Controller
{
    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subtitle = "Laporan Transaksi";
        $transactions = TransactionsM::all();
        return view('laporan',compact('subtitle','transactions'));
    }

    public function filter(Request $request)
    {
        $subtitle = "Filter Transaksi";
        $startDate = $request->input('startDate') ?? now()->subMonth()->format('Y-m-d');
        $endDate = $request->input('endDate') ?? now()->format('Y-m-d');

        $transactions = TransactionsM::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        return view('laporan', compact('subtitle','transactions' ,'startDate','endDate'));

    }


    public function export(Request $request)
    {
        $startDate = $request->input('startDate') ?? now()->subMonth()->format('Y-m-d');
        $endDate = $request->input('endDate') ?? now()->format('Y-m-d');

        $transactions = TransactionsM::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $pdf = PDF::loadView('transactions_pdf1', compact('transactions', 'startDate', 'endDate'));
        return $pdf->stream();
    }
}
