<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttorneyFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attorney_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path');
            $table->bigInteger('form_id')->unsigned()->nullable();
            $table->bigInteger('attorney_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('attorney_forms', function($table) {
          $table->foreign('form_id')->references('id')->on('forms');
          $table->foreign('attorney_id')->references('id')->on('attorneys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attorney_forms');
    }
}
