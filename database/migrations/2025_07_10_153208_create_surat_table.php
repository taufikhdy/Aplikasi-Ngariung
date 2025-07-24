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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');

            $table->string('nomor_surat')->nullable();
            $table->text('keperluan');

            $table->enum('status', ['diproses', 'disetujui', 'ditolak'])->default('diproses');

            $table->date('tanggal_pengajuan');
            $table->date('tanggal_disetujui')->nullable();

            $table->string('file_ttd')->nullable(); //TANDA TANGAN DIGITAL OPSIONAL

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
