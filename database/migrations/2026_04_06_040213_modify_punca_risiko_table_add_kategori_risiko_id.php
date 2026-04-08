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
        Schema::table('punca_risiko', function (Blueprint $table) {
            // Add kategori_risiko_id column
            $table->unsignedBigInteger('kategori_risiko_id')->nullable()->after('id');

            // Add foreign key for kategori_risiko_id
            $table->foreign('kategori_risiko_id')
                ->references('id')
                ->on('kategori_risiko')
                ->onDelete('cascade');

            // Drop the old kategori_punca_risiko_id foreign key and column
            $table->dropForeign(['kategori_punca_risiko_id']);
            $table->dropColumn('kategori_punca_risiko_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('punca_risiko', function (Blueprint $table) {
            // Drop foreign key for kategori_risiko_id
            $table->dropForeign(['kategori_risiko_id']);
            $table->dropColumn('kategori_risiko_id');

            // Restore kategori_punca_risiko_id
            $table->unsignedBigInteger('kategori_punca_risiko_id')->after('id');
            $table->foreign('kategori_punca_risiko_id')
                ->references('id')
                ->on('kategori_punca_risiko')
                ->onDelete('cascade');
        });
    }
};
