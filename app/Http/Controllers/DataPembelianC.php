<?php

namespace App\Http\Controllers;

use App\Models\ProductsM;
use App\Models\TransactionsM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPembelianC extends Controller
{
    public function index()
    {
        $subtitle = " Data Buku Page";
        $products = ProductsM::count();
        $transactions = TransactionsM::count();
        $users = User::count();
        $income = TransactionsM::sum('total_harga');
        $incomeData = TransactionsM::select('total_harga','created_at')->get();
        return view('datapembelian', compact('subtitle','products','users','transactions','income','incomeData'));
    } 
}
