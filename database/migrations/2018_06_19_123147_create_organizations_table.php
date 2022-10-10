<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique('code')->comment('organizations code');
            $table->string('name')->comment('organizations name');
            $table->string('official_name')->nullable()->comment('organizations official_name');
            $table->string('address')->nullable()->comment('organizations address');
            $table->string('phone')->nullable()->comment('organizations phone');
            $table->Integer('admin_id')->unsigned()->comment('organizations admin_id');
            $table->enum('status', ['active', 'suspended'])->default('active')->comment('organizations status');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('admin_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
