<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_order', function (Blueprint $table) {            
            $table->timestamps();
			 //foreign keys
			$table->integer('gift_id')->unsigned();
            $table->integer('order_id')->unsigned();
			
			$table->primary(['gift_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gift_order');
    }
}
