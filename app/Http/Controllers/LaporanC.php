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
        $transactionsM = TransactionsM::with('products')->get(); // Eager loading

        // Mengambil daftar produk untuk dropdown
        $products = ProductsM::all();

        return view('laporan', compact('subtitle', 'transactionsM', 'products'));
    }

    public function filter(Request $request)
    {
        $subtitle = "Filter Transaksi";
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $productName = $request->input('productName');
    
        $query = TransactionsM::with('products')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    
        if (!empty($productName)) {
            $query->whereHas('products', function ($q) use ($productName) {
                $q->where('nama_produk', 'like', '%' . $productName . '%');
            });
        }
    
        $transactionsM = $query->get();
    
        // Mengambil daftar produk untuk dropdown
        $products = ProductsM::all();
    
        return view('laporan', compact('subtitle', 'transactionsM', 'startDate', 'endDate', 'productName', 'products'));
    }

    public function export(Request $request)
    {
        $subtitle = "Filter Transaksi";
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $productName = $request->input('productName');
    
        $query = TransactionsM::with('products')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    
        if (!empty($productName)) {
            $query->whereHas('products', function ($q) use ($productName) {
                $q->where('nama_produk', 'like', '%' . $productName . '%');
            });
        }
    
        $transactionsM = $query->get();
    
        // Mengambil daftar produk untuk dropdown
        $products = ProductsM::all();
        
        $pdf = Pdf::loadView('transactions_pdf1', compact('subtitle', 'transactionsM', 'startDate', 'endDate', 'productName', 'products'));
        return $pdf->stream();
    }
    
 
}
