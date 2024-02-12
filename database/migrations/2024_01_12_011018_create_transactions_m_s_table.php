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
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->json('products')->nullable();
                $table->string('nama_pelanggan', 45);
                $table->string('nomor_unik', 10);
                $table->integer('total_harga');
                $table->integer('uang_bayar');
                $table->integer('uang_kembali');
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
            Schema::dropIfExists('transactions');
        }
    };
