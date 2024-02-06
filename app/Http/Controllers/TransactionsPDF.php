<?php

namespace App\Http\Controllers;

use App\Models\TransactionsM;
use Illuminate\Http\Request;
use PDF;

class TransactionsPdf extends Controller
{
    public function pdfowner()
    {
        $transactions = TransactionsM::all();
        $pdf = PDF::loadView('transactions_pdf1', ['transactions' => $transactions]);
        return $pdf->stream('transaksi.pdf');
    }
}
