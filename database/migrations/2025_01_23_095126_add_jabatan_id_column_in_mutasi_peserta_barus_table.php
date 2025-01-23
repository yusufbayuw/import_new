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
            $table->string('jabatan')->nullable()->after('tmt');
            $table->string('gaji')->nullable()->after('jabatan');
            $table->string('kode_divisi_eksternal')->nullable()->after('nama_pemilik_rekening');
            $table->string('cost_center')->nullable()->after('kode_divisi_eksternal');
            $table->string('benefit')->nullable()->after('email');
            $table->string('direktorat')->nullable()->after('benefit');
            $table->string('nama_cabang')->nullable()->after('direktorat');
            $table->string('kode_bank')->nullable()->after('nama_bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mutasi_peserta_barus', function (Blueprint $table) {
            $table->dropColumn('jabatan');
            $table->dropColumn('gaji');
            $table->dropColumn('kode_divisi_eksternal');
            $table->dropColumn('cost_center');
            $table->dropColumn('benefit');
            $table->dropColumn('direktorat');
            $table->dropColumn('nama_cabang');
            $table->dropColumn('kode_bank');
        });
    }
};
