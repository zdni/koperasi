<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionLeadershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_leaderships', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('accountant_employee_id')->unsigned();
            $table->bigInteger('coordinator_employee_id')->unsigned();
            $table->bigInteger('gm_employee_id')->unsigned();
            $table->bigInteger('region_id')->unsigned();

            $table->foreign('accountant_employee_id')->references('id')->on('employees');
            $table->foreign('coordinator_employee_id')->references('id')->on('employees');
            $table->foreign('gm_employee_id')->references('id')->on('employees');
            $table->foreign('region_id')->references('id')->on('regions');
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
        Schema::dropIfExists('region_leaderships');
    }
}
