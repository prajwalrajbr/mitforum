<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('fileLink');
            $table->string('uploaded_at');
            $table->integer('Assessment_id')->unsigned();
            $table->foreign('Assessment_id')->references('id')->on('assessment_q_s');
            $table->integer('uploaded_by')->unsigned();
            $table->foreign('uploaded_by')->references('id')->on('users');
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
        Schema::dropIfExists('assessment_a_s');
    }
}
