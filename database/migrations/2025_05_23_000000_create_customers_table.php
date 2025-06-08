<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // integer auto increment primary key
            $table->string('kode_customer', 36)->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_telp')->nullable();
            $table->string('password'); // tambahkan kolom password untuk customer login
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
