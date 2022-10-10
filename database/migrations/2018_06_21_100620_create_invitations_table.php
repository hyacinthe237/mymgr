<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('id')->comment('invitations id');;
            $table->enum('status', ['pending','accepted','denied'])->default('pending')->comment('invitations status');
            $table->string('firstname', 255)->nullable()->comment('invitations firstname');
            $table->string('lastname', 255)->nullable()->comment('invitations lastname');
            $table->string('email')->comment('invitations email');
            $table->string('phone')->nullable()->comment('invitations phone');
            $table->Integer('sent_by')->unsigned()->comment('invitations created_by');
            $table->Integer('organization_id')->unsigned()->comment('invitations organization_id');
            $table->string('code')->unique('code')->comment('invitations code');
            $table->text('messsage')->nullable()->comment('invitations messsage');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('sent_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitations');
    }
}
