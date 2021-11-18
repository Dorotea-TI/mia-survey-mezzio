<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MiaSurveyDone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mia_survey_done', function (Blueprint $table) {
            $table->id();

            $table->integer('survey_id');
    $table->integer('user_id');
    $table->string('email');
    $table->text('data');
    $table->integer('duration');
    

            $table->foreign('survey_id')->references('id')->on('mia_survey');$table->foreign('user_id')->references('id')->on('mia_user');

            $table->timestamps();

            $table->integer('deleted')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mia_survey_done');
    }
}