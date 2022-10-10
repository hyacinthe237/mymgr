<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('projects title');
            $table->string('code')->comment('projects code');
            $table->enum('status', ['pending','active','complete', 'canceled'])->default('pending')->comment('Project status');
            $table->text('description')->nullable()->comment('projects description');
            $table->text('goal')->nullable()->comment('projects goal');
            $table->date('start_date')->nullable()->comment('projects start_date');
            $table->date('end_date')->nullable()->comment('projects end_date');
            $table->boolean('is_public')->default('1')->comment('projects is_public');
            $table->Integer('owner_id')->unsigned()->comment('projects owner_id');
            $table->Integer('organization_id')->unsigned()->comment('projects organization_id');
            $table->Integer('category_id')->unsigned()->comment('projects category_id');
            $table->Integer('created_by')->unsigned()->comment('projects created_by');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('owner_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('category_id')->references('id')->on('project_categories')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');

    }
}
