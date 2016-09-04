<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedDelveriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('delivery_id');
            $table->string('order_code');
            $table->dateTime('delivery_time');
            $table->dateTime('returned_time');
            $table->string('received_by');
            $table->timestamps();
        });
        Schema::create('products_on_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
