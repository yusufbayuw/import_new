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
        Schema::create('provider_inhealths', function (Blueprint $table) {
            $table->id();
            $table->string('kode_provider')->nullable();
            $table->string('nama_provider')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kantor_operasional')->nullable();
            $table->string('wilayah_pelayanan')->nullable();
            $table->string('dati2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_inhealths');
    }
};
