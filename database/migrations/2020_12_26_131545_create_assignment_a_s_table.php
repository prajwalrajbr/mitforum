<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_a_s', function (Blueprint $table) {
            $table->id(); 
            $table->string('fileLink');
            $table->string('uploaded_at');
            $table->integer('Assignment_id')->unsigned();
            $table->foreign('Assignment_id')->references('id')->on('assignment_q_s');
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
        Schema::dropIfExists('assignment_a_s');
    }
}
