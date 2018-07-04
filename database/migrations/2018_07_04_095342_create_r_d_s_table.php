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
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->dateTime('date');
            $table->string('place');
            $table->string('file_path');
            $table->string('invitation_subject');
            $table->integer('invitation_delay');
            $table->integer('invitation_frequence');
            $table->integer('invitation_quantity');
            $table->string('admin_first_name');
            $table->string('admin_last_name');
            $table->string('admin_email');
            $table->string('url_one_hash');
            $table->string('url_two_hash');
            $table->string('url_three_hash');
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
