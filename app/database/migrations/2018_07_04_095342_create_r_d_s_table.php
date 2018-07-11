<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRDSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->nullable();
            $table->string('description')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('place')->nullable();
            $table->string('url')->nullable();
            $table->string('file_path')->nullable();
            $table->string('invitation_subject')->nullable();
            $table->string('invitation_description')->nullable();
            $table->integer('invitation_delay')->nullable();
            $table->integer('invitation_frequency')->nullable();
            $table->integer('invitation_quantity')->nullable();
            $table->string('admin_first_name')->nullable();
            $table->string('admin_last_name')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('url_one_hash')->nullable();
            $table->string('url_two_hash')->nullable();
            $table->string('url_three_hash')->nullable();
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
        Schema::dropIfExists('rds');
    }
}
