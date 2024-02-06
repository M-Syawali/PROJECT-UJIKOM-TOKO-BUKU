<?php

namespace App\Http\Controllers;
use App\models\TransactionsM;
use App\models\ProductsM;
use App\models\LogM;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Http\Request;

class TransactionsR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    $transactions = TransactionsM::with('products')->get();
    $products = ProductsM::all(); 
    $subtitle = "Halaman Transaksi"; 
    $LogM = LogM::create([
        'id_user' => Auth::user()->id,
        'activity' => 'User Melihat Halaman Transaksi'
    ]);
    // Mengelompokkan transaksi berdasarkan nomor_unik
    $groupedTransactions = $transactions->groupBy('nomor_unik');

    return view('transactions', compact('groupedTransactions', 'products', 'subtitle'));
  }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = ProductsM::all();
        $subtitle = "Halaman Tambah Transaksi"; 
        return view('create.transactionscreate', compact('products','subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     public function store(Request $request)
     {
         $logM = LogM::create([
             'id_user' => Auth::user()->id,
             'activity' => 'User Menambahkan Transaksi'
         ]);
     
         $request->validate([
             'nomor_unik' => 'required',
             'nama_pelanggan' => 'required',
             'selected_products' => 'required|array|min:1',
             'selected_products.*.qty' => 'required|integer|min:1', // Validasi jumlah (qty) produk
             'uang_bayar' => 'required',
         ]);
     
         // Inisialisasi variabel total harga
         $totalHarga = 0;
     
         foreach ($request->input('selected_products') as $productId => $productData) {
            $product = ProductsM::find($productId);
     
             $product = ProductsM::find($productId);
     
             if (!$product) {
                 return redirect()->route('transactions.create')->with('error', 'Produk Tidak Ditemukan');
             }
     
             if ($product->stok < $qty) {
                 return redirect()->route('transactions.create')->with('error', 'Stok ' . $product->nama_produk . ' Tidak Mencukupi');
             }
     
             // Hitung total harga dari produk saat ini
             $totalHargaProduk = $product->harga_produk * $qty;
     
             $transaction = new TransactionsM;
             $transaction->nomor_unik = $request->input('nomor_unik');
             $transaction->nama_pelanggan = $request->input('nama_pelanggan');
             $transaction->id_produk = $productId;
             $transaction->qty = $qty;
             $transaction->total_harga = $totalHargaProduk;
             $transaction->uang_bayar = $request->input('uang_bayar');
     
             // Uang kembali dihitung setelah transaksi selesai
             $transaction->uang_kembali = 0;
     
             $product->stok -= $qty;
     
             $product->save();
             $transaction->save();
     
             // Menambahkan total harga dari produk saat ini ke totalHarga transaksi
             $totalHarga += $totalHargaProduk;
         }
     
         $uangBayar = $request->input('uang_bayar');
         $uangKembali = $uangBayar - $totalHarga;
     
         // Simpan nilai uang kembali dan total harga ke database
         $lastTransaction = TransactionsM::latest()->first();
         $lastTransaction->uang_kembali = $uangKembali;
         $lastTransaction->total_harga = $totalHarga;
         $lastTransaction->save();
     
         return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Ditambahkan!');
     }
     
     public function edit($id)
     {
         $products = ProductsM::all();
         $transaction = TransactionsM::find($id); // Menambahkan ini untuk mendapatkan data transaksi
         $subtitle = "Halaman Edit Transaksi"; 
         return view('transactions_edit', compact('products', 'transaction', 'subtitle'));
     }
     
     public function update(Request $request, $id)
{
    $logM = LogM::create([
        'id_user' => Auth::user()->id,
        'activity' => 'User Mengupdate Transaksi'
    ]);

    $request->validate([
        'nomor_unik' => 'required',
        'nama_pelanggan' => 'required',
        'selected_products' => 'required|array|min:1',
        'uang_bayar' => 'required',
    ]);

    // Retrieve the transaction to be updated
    $transaction = TransactionsM::find($id);

    if (!$transaction) {
        return redirect()->route('transactions.index')->with('error', 'Data Transaksi tidak ditemukan.');
    }

    // Delete old transactions with the same nomor_unik
    TransactionsM::where('nomor_unik', $transaction->nomor_unik)->delete();

    // Inisialisasi variabel total harga
    $totalHarga = 0;

    foreach ($request->input('selected_products') as $productId => $productData) {
        $product = ProductsM::find($productId);

        if (!$product) {
            return redirect()->route('transactions.edit', $transaction->id)->with('error', 'Produk Tidak Ditemukan');
        }

        $qty = $productData['qty'];

        if ($product->stok < $qty) {
            return redirect()->route('transactions.edit', $transaction->id)->with('error', 'Stok ' . $product->nama_produk . ' Tidak Mencukupi');
        }

        // Hitung total harga dari produk saat ini
        $totalHargaProduk = $product->harga_produk * $qty;

        $newTransaction = new TransactionsM;
        $newTransaction->nomor_unik = $request->input('nomor_unik');
        $newTransaction->nama_pelanggan = $request->input('nama_pelanggan');
        $newTransaction->id_produk = $productId;
        $newTransaction->qty = $qty;
        $newTransaction->total_harga = $totalHargaProduk;
        $newTransaction->uang_bayar = $request->input('uang_bayar');

        // Uang kembali dihitung setelah transaksi selesai
        $newTransaction->uang_kembali = $newTransaction->uang_bayar - $newTransaction->total_harga;

        $product->stok -= $qty;

        $product->save();
        $newTransaction->save();

        // Menambahkan total harga dari produk saat ini ke totalHarga
        $totalHarga += $totalHargaProduk;
    }

    $uangBayar = $request->input('uang_bayar');
    $uangKembali = $uangBayar - $totalHarga;

    // Simpan nilai uang kembali ke database
    $lastTransaction = TransactionsM::latest()->first();
    $lastTransaction->uang_kembali = $uangKembali;
    $lastTransaction->save();

    // Redirect ke indeks transaksi dengan pesan sukses
    return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Diupdate!');
}
     
    /**
     * Mengupdate transaksi yang telah diedit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
        
    /**
     * Remove the specified resource from storage.
     *
     */
   public function destroy($nomor_unik)
    {
        // Find all transactions with the given nomor_unik
        $transactions = TransactionsM::where('nomor_unik', $nomor_unik)->get();
    
        if ($transactions->isEmpty()) {
            return redirect()->route('transactions.index')->with('error', 'Data Transaksi tidak ditemukan.');
        }
    
        // Delete each transaction
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }
    
        return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil Dihapus.');
    }

    public function pdf($nomor_unik)
    {
        $transactions = TransactionsM::with('products')->where('nomor_unik', $nomor_unik)->get();
        $groupedTransactions = $transactions->groupBy('nomor_unik');

        if ($transactions->isEmpty()) {
            return redirect()->route('transactions.index')->with('error', 'Data Transaksi tidak ditemukan.');
        }
    
        $pdf = PDF::loadView('transactionspdf', compact('transactions','groupedTransactions'));
    
        // Instead of download(), use stream() to display the PDF in the browser
        return $pdf->stream('transactions.pdf', array('Attachment' => 0));
    }
}