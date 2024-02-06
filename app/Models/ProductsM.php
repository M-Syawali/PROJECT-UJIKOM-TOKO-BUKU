<?php

namespace App\Models;

 use App\Models\TransactionsM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductsM extends Model
{
    use HasFactory, Searchable;
    protected $table = 'products';
    protected $fillable = [
        'foto',
        'jenis_buku',
        'nama_produk',
        'penulis',
        'penerbit',
        'stok',
        'harga_produk'
    ];


    public function transactions()
    {
        return $this->hasMany(TransactionsM::class, 'id_produk');
    }

    public function searchableAs()
    {
        return 'products';
    }

    public function toSearchableArray()
    {
        return [
            'nama_produk'=> $this->nama_produk,
            'jenis_buku'=> $this->jenis_buku,
        ];
    }
}
