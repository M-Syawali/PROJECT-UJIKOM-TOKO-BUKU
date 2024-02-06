<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('foto')->nullable(); 
            $table->string('jenis_buku'); // Sesuaikan panjang karakter dengan kebutuhan
            $table->string('nama_produk', 45); // Sesuaikan panjang karakter dengan kebutuhan
            $table->string('penulis'); // Sesuaikan panjang karakter dengan kebutuhan
            $table->string('penerbit'); // Sesuaikan panjang karakter dengan kebutuhan
            $table->integer('stok'); 
            $table->integer('harga_produk');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
