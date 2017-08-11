<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('depots', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('saler')->nullable();
            $table->smallInteger('product_id')->unsigned();
            $table->string('quality_product');
            $table->string('color_product');
            $table->smallInteger('quantity_product')->unsigned();
            $table->date('input_date');
            $table->unsignedInteger('price_product');
            $table->unsignedBigInteger('total_price');
            $table->string('depot_note')->nullable();

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
        Schema::dropIfExists('depots');
    }
}
