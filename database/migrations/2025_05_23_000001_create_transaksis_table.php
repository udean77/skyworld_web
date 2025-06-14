<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('transaksi_id')->unique();
            $table->string('kode_customer');
            $table->foreign('kode_customer')->references('kode_customer')->on('customers');
            $table->foreignId('wahana_id')->constrained('wahanas');
            $table->integer('jumlah_tiket');
            $table->foreignId('status_id')->constrained('statuses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
