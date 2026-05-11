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
        Schema::create('navbars', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Nama menu, misal: "Home", "Rekomendasi Cafe"
        $table->string('url'); // Link tujuan, misal: "/", "/rekomendasi"
        $table->integer('sort_order')->default(0); // Untuk mengatur urutan posisi menu
        $table->boolean('is_active')->default(true); // Fitur untuk mematikan/menyalakan menu
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbars');
    }
};
