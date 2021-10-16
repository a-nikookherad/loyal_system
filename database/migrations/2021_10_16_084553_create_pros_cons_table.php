<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProsConsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pros_cons', function (Blueprint $table) {
            $table->id();
            $table->enum("type", ["Weakness", "Strengths"]);
            $table->string("content", 200);

            $table->unsignedBigInteger("comment_id")->index();
            $table->foreign("comment_id")->references("id")->on("comments")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pros_cons');
    }
}
