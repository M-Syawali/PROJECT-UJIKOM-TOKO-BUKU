<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionsM;
use App\Models\ProductsM;
use Carbon\Carbon;
use PDF;


class LaporanC extends Controller {

    public function index(Request $request)
    {
        $subtitle = "Laporan Transaksi";
       $transactions = TransactionsM::with('products')->get();

        // Mengambil daftar produk untuk dropdown
        $products = ProductsM::all();
        $groupedTransactions = $transactions->groupBy('nomor_unik');

        return view('laporan', compact('subtitle', 'transactions', 'products','groupedTransactions'));
    }

    public function filter(Request $request)
    {
        $subtitle = "Filter Transaksi";
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $transactions = TransactionsM::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $groupedTransactions = $transactions->groupBy('nomor_unik');

        return view('laporan', compact('subtitle', 'transactions', 'startDate', 'endDate', 'groupedTransactions'));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $transactions = TransactionsM::with('products')->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        $groupedTransactions = $transactions->groupBy('nomor_unik');

        $pdf = PDF::loadView('transactions_pdf1', compact('transactions', 'startDate', 'endDate', 'groupedTransactions'));
        return $pdf->stream();
    }
}
