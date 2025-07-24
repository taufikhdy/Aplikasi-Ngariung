<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_kas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kas_id')->constrained('kas')->onDelete('cascade');

            $table->date('tanggal');

            $table->enum('jenis', ['masuk', 'keluar']);

            $table->integer('jumlah');

            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_rt');
    }
};
