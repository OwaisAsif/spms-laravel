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
        Schema::create('share_lists', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->string('type')->nullable();
            // images and property ids array
            $table->json('share_data')->nullable();
            // Both for images and properties options
            $table->json('property_options')->nullable();
            // images options (room, size, price)
            $table->json('image_options')->nullable();
            // images properties seprate comments
            $table->json('images_property_comments')->nullable();
            // both for image and property comment
            $table->string('comment')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_lists');
    }
};
