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
        Schema::table('landing_page_settings', function (Blueprint $table) {
            $table->text('footer_address')->nullable();
            $table->json('footer_contact_links')->nullable();
            $table->json('footer_service_links')->nullable();
            $table->json('footer_bottom_links')->nullable();
            $table->json('footer_social_links')->nullable();
            $table->string('footer_copyright')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_address',
                'footer_contact_links',
                'footer_service_links',
                'footer_bottom_links',
                'footer_social_links',
                'footer_copyright',
            ]);
        });
    }
};
