<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttorneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attorneys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('semper_contact');
            $table->string('semper_contact_email')->nullable();
            $table->string('company_name');
            $table->string('company_contact_name');
            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('email');
            $table->string('phone');
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('attorneys', function($table) {
          $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attorneys');
    }
}
