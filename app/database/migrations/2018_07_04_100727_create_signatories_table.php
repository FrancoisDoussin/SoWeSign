<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignatoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_rds');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('company');
            $table->string('url_hash');
            $table->json('sign_coord');
            $table->string('sign_path')->nullable();
            $table->string('tag_number');
            $table->boolean('has_signed')->default(0);
            $table->timestamps();

            $table->foreign('id_rds')->references('id')->on('rds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signatories');
    }
}
