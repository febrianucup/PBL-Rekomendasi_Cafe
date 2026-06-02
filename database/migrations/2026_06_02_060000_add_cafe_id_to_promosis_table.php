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
        Schema::table('promosis', function (Blueprint $table) {
            $table->unsignedBigInteger('cafe_id')->nullable()->after('description');
            $table->foreign('cafe_id')->references('id')->on('cafes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promosis', function (Blueprint $table) {
            $table->dropForeign(['cafe_id']);
            $table->dropColumn('cafe_id');
        });
    }
};
