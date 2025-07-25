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
            $table->foreignId('wahana_id')->constrained('wahanas')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->integer('jumlah_tiket');
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();
        });

        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('transaksi_id')->nullable()->after('id');
        });

        // Isi nilai transaksi_id untuk data yang sudah ada
        DB::table('transaksis')->orderBy('id')->each(function ($transaksi) {
            DB::table('transaksis')
                ->where('id', $transaksi->id)
                ->update(['transaksi_id' => 'TRX-' . str_pad($transaksi->id, 6, '0', STR_PAD_LEFT)]);
        });

        // Set unique constraint setelah mengisi data
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unique('transaksi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('transaksi_id');
        });
    }
}; 