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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('diskon', 5, 2);
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->string('gambar', 255)->nullable();
            $table->string('status', 50)->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
