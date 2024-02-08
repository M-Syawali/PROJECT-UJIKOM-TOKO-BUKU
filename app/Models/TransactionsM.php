<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsM extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        'id', 
        'id_produk', 
        'nama_pelanggan',
        'nomor_unik',   
        'qty',
        'total_harga',
        'uang_bayar', 
        'uang_kembali'
    ];

       public function products()
    {
        return $this->belongsToMany(ProductsM::class, 'transactions', 'id', 'id_produk')
            ->withPivot('qty'); // Assuming 'qty' is the name of the pivot column
    }
    
}
