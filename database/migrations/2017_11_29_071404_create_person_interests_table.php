<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_interests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->integer('interest_id');
            $table->foreign('interest_id')->references('id')->on('interests');
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
        Schema::dropIfExists('person_interests');
    }
}
