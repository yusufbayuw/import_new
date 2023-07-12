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
        Schema::table('provider_b_p_j_s', function (Blueprint $table) {
            $table->string('kode_ppk_bpjs')->nullable()->change();
            $table->string('nama_ppk_bpjs')->nullable()->change();
            $table->string('tipe_ppk_bpjs')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('nama_dati2_ppk')->nullable()->change();
            $table->string('provinsi')->nullable()->change();
            $table->string('kode_ppk_inh')->nullable()->change();
            $table->boolean('active')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_b_p_j_s', function (Blueprint $table) {
            //
        });
    }
};
