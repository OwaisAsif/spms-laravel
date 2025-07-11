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
        Schema::create('properties', function (Blueprint $table) {
            $table->id('building_id');
            $table->string('code')->unique()->nullable();
            $table->string('district')->nullable();
            $table->string('street')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('flat')->nullable();
            $table->integer('no_room')->nullable();
            $table->string('enter_password')->nullable();
            $table->timestamp('building_created_at')->default(now());
            $table->string('block')->nullable();
            $table->string('cargo_lift')->nullable();
            $table->string('customer_lift')->nullable();
            $table->string('tf_hr')->nullable();
            $table->string('car_park')->nullable();
            $table->integer('num_floors')->nullable();
            $table->string('ceiling_height')->nullable();
            $table->string('air_con_system')->nullable();
            $table->string('building_loading')->nullable();
            $table->string('display_by')->nullable();
            $table->string('individual')->nullable();
            $table->string('separate')->nullable();
            $table->string('year')->nullable();
            $table->string('agent_name')->nullable();

            // LANDLORD DETAILS
            $table->string('landlord_name')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_acc')->nullable();
            $table->string('management_company')->nullable();
            $table->mediumText('remarks')->nullable();
            $table->timestamp('landlord_created_at')->default(now());
            $table->string('contact1')->nullable();
            $table->string('number1')->nullable();
            $table->string('contact2')->nullable();
            $table->string('number2')->nullable();
            $table->string('contact3')->nullable();
            $table->string('number3')->nullable();

            // F.T.O.D
            $table->string('facilities')->nullable();
            $table->string('types')->nullable();
            $table->string('decorations')->nullable();
            $table->string('usage')->nullable();
            $table->string('yt_link_1')->nullable();
            $table->string('yt_link_2')->nullable();
            $table->string('others')->nullable();
            $table->string('other_date')->nullable();
            $table->string('other_current_date')->nullable();
            $table->longText('other_free_formate')->nullable();

            // Pricing
            $table->integer('gross_sf')->nullable();
            $table->integer('net_sf')->nullable();
            $table->float('selling_price', 16, 2)->default(0.00)->nullable();
            $table->float('selling_g', 16, 2)->default(0.00)->nullable();
            $table->float('selling_n', 16, 2)->default(0.00)->nullable();
            $table->float('rental_price', 16, 2)->default(0.00)->nullable();
            $table->float('rental_g', 16, 2)->default(0.00)->nullable();
            $table->float('rental_n', 16, 2)->default(0.00)->nullable();
            $table->text('mgmf')->nullable();
            $table->text('rate')->nullable();
            $table->text('land')->nullable();
            $table->text('oths')->nullable();

            // $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};