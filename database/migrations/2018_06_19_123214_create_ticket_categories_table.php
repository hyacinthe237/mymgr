<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('organization_id')->unsigned()->comment('ticket_categories organization_id');
            $table->string('code')->unique('code')->comment('ticket_categories code');
            $table->string('name')->comment('ticket_categories name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_categories');
    }
}
