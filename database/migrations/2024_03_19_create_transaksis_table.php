<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('transaksi_id');
        });
    }
}; 