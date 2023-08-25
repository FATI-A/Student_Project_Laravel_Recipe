<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('commentairy', function (Blueprint $table) {
            $table->id();
            $table->string("commentairy");
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger("recipe_id");
            $table->foreign("recipe_id")->references('id')->on('recipe')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('commentairy');
    }
};
