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
        Schema::create('depots', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('saler')->nullable();
            $table->string('product_name');
            $table->string('storage_product');
            $table->string('quality_product');
            $table->string('color_product');
            $table->smallInteger('quantity_product')->unsigned();
            $table->boolean('is_quocte')->default(true);
            $table->string('pay_type');
            $table->date('input_date');
            $table->unsignedInteger('price_product');
            $table->unsignedBigInteger('total_price');
            $table->text('depot_note')->nullable();
            $table->boolean('is_input_depot')->default(true);    
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
