<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsM extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        'nomor_unik',
        'nama_pelanggan',
        'products',
        'total_harga',
        'uang_bayar',
        'uang_kembali',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'products' => 'json',
    ];
    
    
}
