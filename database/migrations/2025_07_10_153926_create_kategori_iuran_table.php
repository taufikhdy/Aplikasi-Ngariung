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
        Schema::create('kategori_iuran', function (Blueprint $table) {
            $table->id();

            $table->string('nama_iuran');

            $table->integer('jumlah');

            $table->enum('jenis', ['kk', 'perorangan'])->default('kk');

            $table->text('deskripsi')->nullable();

            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_iuran');
    }
};
