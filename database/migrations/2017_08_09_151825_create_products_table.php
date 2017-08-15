<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('product_name');
            $table->string('color_product');
            $table->string('storage_product');
            $table->string('quality_product');
            $table->boolean('is_quocte')->default(true);
            $table->string('product_info')->nullable();
            $table->smallInteger('vendor_id')->unsigned();
            $table->unsignedInteger('quantity_in_stock')->default(0);
            $table->date('created_at')->nullable();

            $table->foreign('vendor_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
