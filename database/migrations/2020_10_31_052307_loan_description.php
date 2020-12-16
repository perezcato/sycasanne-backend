<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoanDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LoanDescription', function (Blueprint $table){
            $table->id('MyIndex');
            $table->bigInteger('LoanID')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('CreatedAt')->nullable();
            $table->bigInteger('userRef')->nullable();
            $table->bigInteger('deviceRef')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LoanDescription');
    }
}
