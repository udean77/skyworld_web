<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('transaksi_id')->unique()->nullable();
            $table->foreignId('wahana_id')->constrained('wahanas')->onDelete('cascade');        
            $table->string('kode_customer'); // hanya pakai kode_customer, hapus customer_id
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->integer('jumlah_tiket');
            $table->integer('total_harga')->nullable(); 
            $table->timestamps();
        });

        // Isi nilai transaksi_id untuk data yang sudah ada
        DB::table('transaksis')->orderBy('id')->each(function ($transaksi) {
            DB::table('transaksis')
                ->where('id', $transaksi->id)
                ->update(['transaksi_id' => 'TRX-' . str_pad($transaksi->id, 6, '0', STR_PAD_LEFT)]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};