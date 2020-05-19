<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalsManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('globals_manufacturers', function (Blueprint $table) {
            $table->unsignedInteger('global_supplier_id');
            $table->unsignedInteger('manufacturer_id');
            $table->primary(['global_supplier_id', 'manufacturer_id']);
            $table->foreign('global_supplier_id')->references('id')->on('global_suppliers');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
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
        Schema::dropIfExists('globals_manufacturers');
    }
}
