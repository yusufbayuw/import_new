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
        Schema::create('kode_kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kecamatan');
            $table->string('nama_kecamatan');
            $table->string('nama_dati2');
            $table->string('nama_operasional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_kecamatans');
    }
};
