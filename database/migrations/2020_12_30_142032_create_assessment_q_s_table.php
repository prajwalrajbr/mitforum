<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentQSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_q_s', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->string('branch');
            $table->string('sem');
            $table->boolean('is_f');
            $table->string('fileName');
            $table->string('fileLink');
            $table->string('startTime');
            $table->string('endTime');
            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->string('subject_name');
            $table->string('sub_code');
            $table->integer('created_by_id')->unsigned();
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->string('created_by_name');
            $table->string('date');
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
        Schema::dropIfExists('assessment_q_s');
    }
}
