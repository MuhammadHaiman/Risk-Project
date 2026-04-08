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
        Schema::create('daftar_risiko', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agensi_id');
            $table->unsignedBigInteger('aset_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('sub_kategori_risiko_id');
            $table->unsignedBigInteger('risiko_id');
            $table->unsignedBigInteger('kategori_punca_risiko_id');
            $table->integer('impak')->default(0);
            $table->integer('kebarangkalian')->default(0);
            $table->integer('skor_risiko')->default(0);
            $table->string('tahap_risiko')->default('Rendah');
            $table->text('kawalan_sediada')->nullable();
            $table->text('plan_mitigasi')->nullable();
            $table->string('pemilik_risiko')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_risiko');
    }
};
