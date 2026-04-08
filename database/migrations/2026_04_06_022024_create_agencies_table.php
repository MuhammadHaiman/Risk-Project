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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('nama_agensi');
            $table->string('no_tel_agensi');
            $table->string('website')->nullable();
            $table->string('nama_pic');
            $table->string('notel_pic');
            $table->string('emel_pic');
            $table->unsignedBigInteger('sektor_id')->nullable();
            $table->string('jenis_agensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
