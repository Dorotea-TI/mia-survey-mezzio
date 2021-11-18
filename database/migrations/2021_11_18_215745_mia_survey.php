<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MiaSurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mia_survey', function (Blueprint $table) {
            $table->id();

            $table->integer('creator_id');
    $table->string('title');
    $table->text('caption');
    $table->integer('type');
    $table->text('photo');
    $table->integer('completed');
    

            $table->foreign('creator_id')->references('id')->on('mia_user');

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
        Schema::dropIfExists('mia_survey');
    }
}