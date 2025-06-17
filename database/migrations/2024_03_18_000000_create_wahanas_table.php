<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWahanasTable extends Migration
{
    public function up()
    {
        Schema::create('wahanas', function (Blueprint $table) {
            $table->bigIncrements('id'); // ini adalah wahana_id
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('harga')->default(0);
            $table->string('gambar')->nullable();
            $table->integer('stok')->default(0); // jumlah tiket tersedia
// true = aktif, false = tidak aktif
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wahanas');
    }
}
