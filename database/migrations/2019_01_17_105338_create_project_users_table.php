<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_users', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('user_id')->unsigned();
            $table->Integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_users');
    }
}
