<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->string('state');
            $table->timestamps();
            
            $table->bigInteger('account_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('employee_id')->references('id')->on('employees');
            
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
        Schema::dropIfExists('account_lines');
    }
}
