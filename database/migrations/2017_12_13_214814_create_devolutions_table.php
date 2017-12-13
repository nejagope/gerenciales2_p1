<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolutions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			
			//foreign keys
			$table->integer('reason_id')->unsigned()->nullable();
			$table->integer('product_id')->unsigned()->nullable();
			$table->integer('order_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devolutions');
    }
}
