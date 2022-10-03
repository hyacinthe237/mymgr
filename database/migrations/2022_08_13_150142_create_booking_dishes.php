<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDishes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_dishes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('booking_id');
            $table->integer('dish_id');
            $table->integer('serves');
            $table->integer('duration');
            $table->double('price', 8, 2);
            $table->timestamps();
        });


        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('dish_id');
            $table->dropColumn('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_dishes');

        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('dish_id')->nullable()->after('chef_id');
            $table->integer('quantity')->nullable()->after('chef_id');
        });
    }
}
