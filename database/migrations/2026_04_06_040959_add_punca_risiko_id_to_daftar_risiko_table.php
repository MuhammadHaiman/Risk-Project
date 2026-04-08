<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('daftar_risiko', function (Blueprint $table) {
            // Add punca_risiko_id column for new structure
            if (!Schema::hasColumn('daftar_risiko', 'punca_risiko_id')) {
                $table->unsignedBigInteger('punca_risiko_id')->nullable()->after('risiko_id');

                // Add foreign key for punca_risiko_id
                $table->foreign('punca_risiko_id')
                    ->references('id')
                    ->on('punca_risiko')
                    ->onDelete('set null');
            }

            // Make kategori_punca_risiko_id nullable for backward compatibility
            if (Schema::hasColumn('daftar_risiko', 'kategori_punca_risiko_id')) {
                try {
                    $table->unsignedBigInteger('kategori_punca_risiko_id')->nullable()->change();
                } catch (\Exception $e) {
                    // Column already nullable
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_risiko', function (Blueprint $table) {
            // Check if column exists before dropping
            if (Schema::hasColumn('daftar_risiko', 'punca_risiko_id')) {
                // Try to drop the foreign key first
                try {
                    DB::statement('ALTER TABLE daftar_risiko DROP FOREIGN KEY daftar_risiko_punca_risiko_id_foreign');
                } catch (\Exception $e) {
                    // Foreign key doesn't exist
                }

                // Drop the column
                $table->dropColumn('punca_risiko_id');
            }
        });
    }
};
