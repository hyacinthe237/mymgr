<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('user_id')->unsigned()->comment('user_organizations user_id');
            $table->Integer('organization_id')->unsigned()->comment('user_organizations organization_id');
            $table->string('position')->nullable()->comment('user_organizations position');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->unique(['user_id', 'organization_id']);
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
        Schema::dropIfExists('users_organizations');
    }
}
