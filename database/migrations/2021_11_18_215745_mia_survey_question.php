<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MiaSurveyQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mia_survey_question', function (Blueprint $table) {
            $table->id();

            $table->integer('survey_id');
    $table->string('title');
    $table->text('caption');
    $table->integer('type');
    $table->text('val');
    $table->text('data');
    $table->integer('ord');
    

            $table->foreign('survey_id')->references('id')->on('mia_survey');

            

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mia_survey_question');
    }
}