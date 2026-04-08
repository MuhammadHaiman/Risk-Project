<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add foreign keys to assets
        Schema::table('assets', function (Blueprint $table) {
            $table->foreign('agensi_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->foreign('id_jenis_aset')->references('id')->on('jenis_aset')->onDelete('restrict');
        });

        // Add foreign keys to sub_kategori_risiko
        Schema::table('sub_kategori_risiko', function (Blueprint $table) {
            $table->foreign('kategori_risiko_id')->references('id')->on('kategori_risiko')->onDelete('cascade');
        });

        // Add foreign keys to risiko
        Schema::table('risiko', function (Blueprint $table) {
            $table->foreign('sub_kategori_risiko_id')->references('id')->on('sub_kategori_risiko')->onDelete('cascade');
        });

        // Add foreign keys to punca_risiko
        Schema::table('punca_risiko', function (Blueprint $table) {
            $table->foreign('kategori_punca_risiko_id')->references('id')->on('kategori_punca_risiko')->onDelete('cascade');
        });

        // Add foreign keys to daftar_risiko
        Schema::table('daftar_risiko', function (Blueprint $table) {
            $table->foreign('agensi_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->foreign('aset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategori_risiko')->onDelete('restrict');
            $table->foreign('sub_kategori_risiko_id')->references('id')->on('sub_kategori_risiko')->onDelete('restrict');
            $table->foreign('risiko_id')->references('id')->on('risiko')->onDelete('restrict');
            $table->foreign('kategori_punca_risiko_id')->references('id')->on('kategori_punca_risiko')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('daftar_risiko', function (Blueprint $table) {
            $table->dropForeign(['agensi_id']);
            $table->dropForeign(['aset_id']);
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['sub_kategori_risiko_id']);
            $table->dropForeign(['risiko_id']);
            $table->dropForeign(['kategori_punca_risiko_id']);
        });

        Schema::table('punca_risiko', function (Blueprint $table) {
            $table->dropForeign(['kategori_punca_risiko_id']);
        });

        Schema::table('risiko', function (Blueprint $table) {
            $table->dropForeign(['sub_kategori_risiko_id']);
        });

        Schema::table('sub_kategori_risiko', function (Blueprint $table) {
            $table->dropForeign(['kategori_risiko_id']);
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['agensi_id']);
            $table->dropForeign(['id_jenis_aset']);
        });
    }
};
