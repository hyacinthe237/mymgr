<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->integer('role_id');
            $table->integer('country_id');
            $table->string('code')->unique();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middle_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('card_last_digits')->nullable();
            $table->string('card_expiry')->nullable();
            $table->string('profile')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('stripe_customer_token')->nullable();
            $table->string('stripe_card_token')->nullable();
            $table->string('chef_type')->nullable(); // amateur|professional
            $table->date('date_of_birth')->nullable();
            $table->string('status')->default('pending'); // pending|active|blocked|deleted
            $table->string('api_token')->unique();
            $table->string('bank_bsb')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('vaccination_status')->nullable();
            $table->double('ratings')->nullable();
            $table->string('sex')->nullable();
            $table->string('pin')->nullable();
            $table->string('otp')->nullable();
            $table->text('json')->nullable();
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
