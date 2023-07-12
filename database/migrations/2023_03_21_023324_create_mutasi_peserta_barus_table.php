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
        Schema::create('mutasi_peserta_barus', function (Blueprint $table) {
            $table->id();
            $table->string('produk_yg_dipilih');
            $table->string('kelas_rawat');
            $table->string('no_peg');
            $table->string('sub_group');
            $table->string('nama_subgroup');
            $table->string('nama');
            $table->string('pisa');
            $table->string('tempat_lhr');
            $table->string('tgl_lhr');
            $table->string('jns_kel');
            $table->string('status_kawin');
            $table->string('alamat');
            $table->string('kode_kecamatan');
            $table->string('kode_dokter');
            $table->string('nama_dokter');
            $table->string('nomor_kartu');
            $table->string('kode_fakes');
            $table->string('nama_fakes');
            $table->string('kelas_rawat_bpjs');
            $table->string('tgl_efektif_bpjs');
            $table->string('nomor_induk_kependudukan');
            $table->string('tmt');
            $table->string('nama_bank');
            $table->string('no_rek');
            $table->string('nama_pemilik_rekening');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_peserta_barus');
    }
};
