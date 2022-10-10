<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('tickets title');
            $table->text('description')->nullable()->comment('tickets description');
            $table->integer('status')->unsigned()->index()->nullable()->comment('tickets status');
            $table->enum('priority', ['low','medium','high','critical'])->default('low')->comment('tickets priority');
            $table->enum('complexity', ['low','medium','high','critical'])->default('low')->comment('tickets complexity');
            $table->Integer('project_id')->unsigned()->index()->nullable()->comment('tickets project_id');
            $table->Integer('created_by')->unsigned()->index()->nullable()->comment('tickets project_id');
            $table->Integer('parent_id')->unsigned()->index()->nullable()->comment('tickets project_id');
            $table->Integer('assignee_id')->unsigned()->index()->nullable()->comment('tickets project_id');
            $table->Integer('number')->index()->comment('tickets number');
            $table->date('start_date')->nullable()->comment('tickets start_date');
            $table->date('end_date')->nullable()->comment('tickets end_date');
            $table->string('estimate')->nullable()->comment('tickets estimate'); // 2hours,52 days or 3 months
            $table->boolean('is_open')->default('1')->comment('tickets is_open');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('parent_id')->references('id')->on('tickets')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('assignee_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
