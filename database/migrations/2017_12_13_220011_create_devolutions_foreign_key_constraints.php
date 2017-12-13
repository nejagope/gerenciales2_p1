<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolutionsForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devolutions', function (Blueprint $table) {
            //
			$table->foreign('reason_id')->references('id')->on('reasons');            
			$table->foreign('order_id')->references('id')->on('orders');            
			$table->foreign('product_id')->references('id')->on('products');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devolutions', function (Blueprint $table) {
            $table->dropForeign('devolutions_reason_id_foreign');            
			$table->dropForeign('devolutions_order_id_foreign');            
			$table->dropForeign('devolutions_product_id_foreign');            
        });
    }
}
