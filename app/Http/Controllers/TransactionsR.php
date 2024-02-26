<?php

namespace App\Http\Controllers;

use App\Models\LogM;
use App\Models\ProductsM;
use App\Models\TransactionsM;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransactionsR extends Controller
{
    public function index()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melihat Halaman Transaksi'
        ]);

        $subtitle = "Transaksi";
        $transactions = TransactionsM::all();
        return view('transactions', compact('subtitle', 'transactions'));
    }

    public function create()
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Berada Di Halaman Transaksi'
        ]);

        $subtitle = "Tambah Transaksi";
        $products = ProductsM::all();
        return view('create.transactionscreate', compact('subtitle', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_unik' => 'required',
            'nama_pelanggan' => 'required',
            'products' => 'required|array',
            'total_harga' => 'required',
            'uang_bayar' => 'required',
            'qty' => 'required|array',
        ]);

        $produkId = $request->input('produkId');
        $qty = $request->input('qty');

        foreach ($produkId as $index => $id) {
            $product = ProductsM::find($id);
            if ($product->stok < $qty[$index]) {
                return redirect()->back()->withInput()->withErrors(['qty' => 'Qty produk ' . $product->nama_produk . ' melebihi stok yang tersedia']);
            }
        }

        // Mengurangi stok produk yang dibeli
        foreach ($produkId as $index => $id) {
            $product = ProductsM::find($id);
            $product->stok -= $qty[$index];
            $product->save();
        }

        TransactionsM::create([
            'nomor_unik' => $request->input('nomor_unik'),
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'products' => $this->prepareProduk($produkId, $qty),
            'total_harga' => $request->input('total_harga'),
            'uang_bayar' => $request->input('uang_bayar'),
            'uang_kembali' => $request->input('uang_bayar') - $request->input('total_harga'),
        ]);

        return redirect()->route('transactions.index')->with('success', 'Data Transaksi berhasil disimpan');
    }

    private function prepareProduk($produkIds, $qtys)
    {
        $preparedProduk = [];

        foreach ($produkIds as $index => $produkId) {
            $qty = $qtys[$index];

            $products = ProductsM::find($produkId);

            if ($products) {
            $preparedProduk[] = [
                'produkId' => $produkId,
                'nama_produk' => $products->nama_produk,
                'qty' => $qty,
                'total' => $qty * $products->harga_produk,
            ];
        }
    }

        return $preparedProduk;
    }

    public function edit(string $id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Berada Di Halaman Edit Transaksi'
        ]);

        $subtitle = "Update Transaksi";
        $transactions = TransactionsM::find($id);
        $products = ProductsM::all();
        return view('edit.transactionsedit', compact('subtitle', 'transactions','products'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nomor_unik' => 'required',
            'products' => 'required|array', // Fix typo here
            'nama_pelanggan' => 'required',
            'total_harga' => 'required',
            'uang_bayar' => 'required',
            'qty' => 'required|array',
        ]);

        $produkId = $request->input('produkId');
        $qty = $request->input('qty');

        // Mengembalikan stok produk yang sebelumnya dibeli
        $transaction = TransactionsM::find($id);
        foreach ($transaction->products as $product) {
            $productData = ProductsM::find($product['produkId']);
            $productData->stok += $product['qty'];
            $productData->save();
        }

        // Mengurangi stok produk yang baru dibeli
        foreach ($produkId as $index => $id) {
            $product = ProductsM::find($id);
            $product->stok -= $qty[$index];
            $product->save();
        }

        $transaction->update([
            'nomor_unik' => $request->input('nomor_unik'),
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'products' => $this->prepareProduk($produkId, $qty),
            'total_harga' => $request->input('total_harga'),
            'uang_bayar' => $request->input('uang_bayar'),
            'uang_kembali' => $request->input('uang_bayar') - $request->input('total_harga'),
        ]);

        return redirect()->route('transactions.index')->with('success', 'Data Transaksi berhasil disimpan');
    }

    public function destroy(string $id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Menghapus Data Transaksi'
        ]);

        $transactions = TransactionsM::find($id);
        $transactions->delete();
        return redirect('transactions')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function pdf(String $id)
    {
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Membuat PDF Transaksi'
        ]);

        $transactions = TransactionsM::find($id);
        $pdf = Pdf::loadView('transactionspdf', compact('transactions'));
        return $pdf->stream();
    }
}