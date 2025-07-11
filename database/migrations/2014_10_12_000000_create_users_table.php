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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // Export count is uesd to count number of excel files exported a day
            $table->integer('exportCount')->nullable();
            // User permission to see contacts
            $table->boolean('contact_permission')->nullable();
            // User pemission to see photos
            $table->boolean('photo_permission')->nullable();
            $table->boolean('image_merge_permission')->nullable();
            $table->string('role')->nullable();
            // Properties share list is for save id of properties which are added to sharelist by user
            $table->json('properties_share_list')->nullable();
            $table->json('images_share_list')->nullable();
            $table->integer('properties_viewed')->nullable();
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
