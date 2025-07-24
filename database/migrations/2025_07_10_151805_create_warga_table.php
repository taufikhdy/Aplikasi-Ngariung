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
        Schema::create('warga', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('jenis_kelamin');
            // TEMPAT LAHIR BUTUH GA?
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('pendidikan');
            $table->string('pekerjaan');

            $table->enum('status_perkawinan', ['kawin', 'belum_kawin']);
            $table->enum('status_keluarga', ['kepala', 'anggota']);

            $table->string('telepon')->nullable();

            $table->foreignId('kk_id')->constrained('kartu_keluarga')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
