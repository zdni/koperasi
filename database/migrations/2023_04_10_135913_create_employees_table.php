<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('place_and_date_of_birth');
            $table->string('identity_card_number');
            $table->string('address');
            $table->string('gender');
            $table->date('date_of_entry');
            $table->string('contact_person');
            $table->string('last_education');
            $table->boolean('activity_state');
            
            $table->bigInteger('position_id')->nullable()->unsigned();
            $table->bigInteger('unit_id')->nullable()->unsigned();
            $table->bigInteger('user_id')->nullable()->unsigned();
            
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
