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
        Schema::create('cafe_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cafe_id')->references('id')->on('cafes')->onDelete('cascade');
            $table->text('photo_url')->isNotEmpty();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafe_photos');
    }
};
