<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftOrderForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_order', function (Blueprint $table) {
            $table->foreign('gift_id')->references('id')->on('gifts');
			$table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gift_order', function (Blueprint $table) {
            $table->dropForeign('gift_order_order_id_foreign');            
			$table->dropForeign('gift_order_gift_id_foreign');            
        });
    }
}
