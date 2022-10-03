<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('number');
            $table->string('code')->unique();
            $table->integer('client_id');
            $table->integer('chef_id');
            $table->integer('dish_id');
            $table->integer('quantity');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->double('amount', 8, 2);
            $table->string('status'); //pending, approved, cancelled, complete
            $table->text('notes')->nullable();
            $table->integer('ratings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
