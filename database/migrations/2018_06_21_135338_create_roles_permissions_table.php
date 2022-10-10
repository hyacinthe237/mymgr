<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('role_id')->unsigned()->comment('role_permissions role_id');
            $table->Integer('permission_id')->unsigned()->comment('role_permissions permission_id');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::dropIfExists('roles_permissions');
    }
}
