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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('cafe_id')->references('id')->on('cafes')->onDelete('cascade');

            // Cukup hapus ->after('cafe_id') karena posisinya sudah otomatis di sini 🎯
            $table->unsignedBigInteger('parent_id')->nullable(); 
            
            $table->text('body');
            $table->integer('rating_score')->nullable(); // Balasan tidak wajib punya rating
            $table->text('images')->nullable();
            $table->string('type')->default('review'); // 'review' atau 'discussion'
            $table->timestamps();

            // Deklarasi Foreign Key ke dirinya sendiri
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
