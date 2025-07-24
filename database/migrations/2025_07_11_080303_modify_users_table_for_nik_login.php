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
        Schema::table('users', function (Blueprint $table){

            // ganti nama username ke nik
            $table->renameColumn('name', 'nik');

            //hapus kolom email
            $table->dropColumn(['email', 'email_verified_at']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){

            // balik nama kolom nik->username
            $table->renameColumn('name', 'nik');

            //tambah lagi kolom email
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();

        });
    }
};
