<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->string("description");
            $table->boolean("show_name")->default(false)->comment("does user want to show hi's name?");
            $table->enum("status", ["pending", "approved"])->default("pending")->comment("expert accept required");

            $table->unsignedBigInteger("post_id")->index();
            $table->foreign("post_id")->references("id")->on("posts")->onUpdate("cascade")->onDelete("cascade");

            $table->unsignedBigInteger("user_id")->index()->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onUpdate("cascade");

            $table->unsignedBigInteger("guest_id")->index()->nullable();
            $table->foreign("guest_id")->references("id")->on("guests")->onUpdate("cascade");

            $table->unsignedBigInteger("parent_id")->index()->nullable();
            $table->foreign("parent_id")->references("id")->on("comments")->onDelete("cascade")->onUpdate("cascade");
            $table->softDeletes();
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
        Schema::dropIfExists('comments');
    }
}
