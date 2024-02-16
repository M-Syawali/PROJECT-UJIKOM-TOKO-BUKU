<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogM;
use App\Models\ProductsM;
use Illuminate\Support\Facades\Auth;
use PDF;

class ProductsR extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $logM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melihat Halaman Produk'
        ]);

        $products = ProductsM::search(request('search'))
        ->paginate(10);
        $vcari = request('search');
        // $products = ProductsM::all();
        $subtitle = "Products";
        return view('products', compact('products','subtitle','vcari'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Di Halaman Tambah Produk'
        ]);

        $subtitle = "Pages Products Tambah";
        $products = ProductsM::all();
        return view('create.productscreate', compact('products','subtitle',));
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
            'activity' => 'User Melakukan Proses Tambah Produk'
        ]);

        $validatedData = $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_buku' => 'required', 
            'nama_produk' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'stok' => 'required', 
            'harga_produk' => 'required',
        ]);
        

        $input = $request->all();

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            if ($image->isValid()) {
                $folderPath = 'assets/images/products';
                $imgName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move(public_path($folderPath) , $imgName);
                $input['foto'] = $imgName;
            } else {
                return redirect()->back()->withErrors(['image' => 'invalid Image File. '])->withInput();
            }
        }

        ProductsM::create($input);

        return redirect()->route('products.index')->with('success', 'Data Products Berhasil ditambahkan.');
    
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
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Di Halaman Edit Produk'
        ]);

        $subtitle = "Pages Products Edit";
        $products = ProductsM::find($id);
        return view('edit.productsedit',compact('products','subtitle'));
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
        $LogM = LogM::create([
            'id_user' => Auth::user()->id,
            'activity' => 'User Melakukan Proses Edit Produk'
        ]);
    
        $validatedData = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_buku' => 'required',
            'nama_produk' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'stok' => 'required',
            'harga_produk' => 'required',
        ]);
    
        $products = ProductsM::findOrFail($id);
        $input = $request->all();
    
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            if ($image->isValid()) {
                $folderPath = 'assets/images/products';
                $imgName = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move(public_path($folderPath), $imgName);
                $input['foto'] = $imgName;
    
                // Delete old image file if it exists
                if ($products->foto && file_exists(public_path($folderPath . '/' . $products->foto))) {
                    unlink(public_path($folderPath . '/' . $products->foto));
                }
            } else {
                return redirect()->back()->withErrors(['image' => 'Invalid Image File.'])->withInput();
            }
        }
    
        $products->update($input);
    
        return redirect()->route('products.index')->with('success', 'Data Products Berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = ProductsM::findOrFail($id);
        $products->delete();

        return redirect()->route('products.index')->with('success', 'Data berhasil dihapus.');
    }

    public function pdf()
    {
       // Mengambil data transaksi berdasarkan ID
        $products = ProductsM::all();
        $pdf = PDF::loadView('productspdf',['products' => $products]);
        // Menghasilkan laporan PDF
        return $pdf->stream('produk.pdf');
    }
}
