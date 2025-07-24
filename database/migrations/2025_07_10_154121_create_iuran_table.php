<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //PEMBAYARAN IURAN OLEH WARGA
    public function up(): void
    {
        Schema::create('transaksi_iuran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_iuran_id')->constrained('kategori_iuran')->onDelete('cascade');
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');

            $table->date('tanggal_bayar')->nullable();

            $table->integer('jumlah_bayar')->nullable();

            $table->string('bukti_bayar')->nullable();

            $table->enum('status', ['pending', 'terkonfirmasi'])->default('pending');

            $table->foreignId('transaksi_kas_id')->nullable()->constrained('transaksi_kas')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_iuran');
    }
};
