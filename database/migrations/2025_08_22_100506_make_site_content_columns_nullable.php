<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_content', function (Blueprint $table) {
            $table->string('home_title')->nullable()->change();
            $table->string('home_title_en')->nullable()->change();
            $table->string('home_button')->nullable()->change();
            $table->string('home_button_en')->nullable()->change();
            $table->string('page_header_title')->nullable()->change();
            $table->string('page_header_title_en')->nullable()->change();
            $table->string('page_header_subtitle')->nullable()->change();
            $table->string('page_header_subtitle_en')->nullable()->change();
            $table->string('page_h1')->nullable()->change();
            $table->string('page_h1_en')->nullable()->change();
            $table->text('page_description')->nullable()->change();
            $table->text('page_description_en')->nullable()->change();
            $table->string('page_service_name')->nullable()->change();
            $table->string('page_service_name_en')->nullable()->change();

            $table->string('logo')->nullable()->change();
            $table->string('page_bg_image')->nullable()->change();

            $table->json('home_bg_images')->nullable()->change();
            $table->json('page_default_images')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('site_content', function (Blueprint $table) {});
    }
};
