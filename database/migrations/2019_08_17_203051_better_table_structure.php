<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BetterTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usernames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->enum('process_state', ['unprocessed', 'processing', 'processed'])->default('unprocessed');
            $table->integer('score')->nullable();
            $table->timestamps();
        });
        Schema::create('batch_usernames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username_id');
            $table->bigInteger('batch_id');
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
        Schema::dropIfExists('usernames');
        Schema::dropIfExists('batch_usernames');

    }
}
