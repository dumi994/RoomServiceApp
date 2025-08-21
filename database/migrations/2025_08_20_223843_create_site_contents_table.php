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
        Schema::create('site_content', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->text('home_title');
            $table->text('home_title_en');

            $table->text('home_button');
            $table->text('home_button_en');

            $table->text('page_header_title');
            $table->text('page_header_title_en');
            $table->text('page_header_subtitle');
            $table->text('page_header_subtitle_en');
            $table->text('page_h1');
            $table->text('page_h1_en');
            $table->text('page_description');
            $table->text('page_description_en');
            $table->text('page_service_name_en');
            $table->text('page_service_name');
            $table->text('home_bg_images');
            $table->string('page_bg_image');
            $table->text('page_default_images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_content');
    }
};
