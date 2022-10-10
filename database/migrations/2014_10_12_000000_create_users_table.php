<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('firstname', 255);
            $table->string('lastname', 255)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('api_token', 255)->unique();
            $table->enum('status', ['pending', 'active', 'blocked'])->default('pending');
            $table->string('photo', 255)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
