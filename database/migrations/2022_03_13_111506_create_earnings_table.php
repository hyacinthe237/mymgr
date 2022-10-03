<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->integer('user_id');
            $table->integer('booking_id');
            $table->integer('cleared_by')->nullable();
            $table->datetime('date_cleared')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->string('status'); //pending, cleared, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('users', function (Blueprint $table) {
            $table->double('balance', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('earnings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
}
