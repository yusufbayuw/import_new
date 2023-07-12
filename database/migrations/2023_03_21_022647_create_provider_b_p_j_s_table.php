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
        Schema::create('provider_b_p_j_s', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ppk_bpjs');
            $table->string('nama_ppk_bpjs');
            $table->string('tipe_ppk_bpjs');
            $table->string('alamat');
            $table->string('nama_dati2_ppk');
            $table->string('provinsi');
            $table->string('kode_ppk_inh');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_b_p_j_s');
    }
};
