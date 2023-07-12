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
        Schema::table('mutasi_peserta_barus', function (Blueprint $table) {
            $table->string('produk_yg_dipilih')->nullable()->change();
            $table->string('kelas_rawat')->nullable()->change();
            $table->string('no_peg')->nullable()->change();
            $table->string('sub_group')->nullable()->change();
            $table->string('nama_subgroup')->nullable()->change();
            $table->string('nama')->nullable()->change();
            $table->string('pisa')->nullable()->change();
            $table->string('tempat_lhr')->nullable()->change();
            $table->string('tgl_lhr')->nullable()->change();
            $table->string('jns_kel')->nullable()->change();
            $table->string('status_kawin')->nullable()->change();
            $table->string('alamat')->nullable()->change();
            $table->string('kode_kecamatan')->nullable()->change();
            $table->string('kode_dokter')->nullable()->change();
            $table->string('nama_dokter')->nullable()->change();
            $table->string('nomor_kartu')->nullable()->change();
            $table->string('kode_fakes')->nullable()->change();
            $table->string('nama_fakes')->nullable()->change();
            $table->string('kelas_rawat_bpjs')->nullable()->change();
            $table->string('tgl_efektif_bpjs')->nullable()->change();
            $table->string('nomor_induk_kependudukan')->nullable()->change();
            $table->string('tmt')->nullable()->change();
            $table->string('nama_bank')->nullable()->change();
            $table->string('no_rek')->nullable()->change();
            $table->string('nama_pemilik_rekening')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mutasi_peserta_barus', function (Blueprint $table) {
            //
        });
    }
};
