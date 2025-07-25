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
        Schema::create('surat_skck', function (Blueprint $table) {
            $table->id();

            $table->foreignId('surat_id')->constrained('surat')->onDelete('cascade');

            $table->string('nama');
            $table->string('nik');
            $table->text('alamat');
            $table->string('keperluan');
            $table->string('tujuan_skck')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_skck');
    }
};
