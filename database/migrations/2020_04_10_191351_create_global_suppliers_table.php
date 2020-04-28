<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedBigInteger('country_id');
            $table->string('email')->unique();
            $table->unsignedBigInteger('language_id');
            $table->string('telephone')->unique();
            $table->unsignedBigInteger('currency_id');    
            $table->string('phone')->nullable();
            $table->boolean('marketplace')->nullable();
            $table->boolean('brokers_pais')->nullable();
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
        Schema::dropIfExists('global_suppliers');
    }
}
