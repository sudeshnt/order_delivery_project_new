<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedIsDeletedToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function(Blueprint $table)
        {
            $table->boolean('isDeleted');
        });
        Schema::table('vehicles', function(Blueprint $table)
        {
            $table->boolean('isDeleted');
        });
        Schema::table('drivers', function(Blueprint $table)
        {
            $table->boolean('isDeleted');
        });
        Schema::table('products', function(Blueprint $table)
        {
            $table->boolean('isDeleted');
        });
        Schema::table('companies', function(Blueprint $table)
        {
            $table->boolean('isDeleted');
        });
        Schema::table('zones', function(Blueprint $table)
        {
            $table->boolean('isDeleted');
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
