<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('debits', function (Blueprint $table) {
            $table->Increments('id');
            $table->smallInteger('member_id')->unsigned();;
            $table->integer('total_amount');
            $table->boolean('is_cong')->default(true);
            $table->boolean('debit_done')->default(false);
            $table->string('debit_note')->nullable();
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debits');
    }
}
