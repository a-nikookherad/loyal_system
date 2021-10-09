<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostRelatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_relates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("post_id")->index();
            $table->foreign("post_id")->references("id")->on("posts")->onUpdate("cascade");

            $table->unsignedBigInteger("relate_id")->index();
            $table->foreign("relate_id")->references("id")->on("relates")->onUpdate("cascade");
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
        Schema::dropIfExists('post_relates');
    }
}
