<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('member_name');
            $table->string('member_phone');
            $table->boolean('is_female')->default(true);
            $table->string('member_address');
            $table->string('member_note')->nullable();
            $table->unsignedBigInteger('debt')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
