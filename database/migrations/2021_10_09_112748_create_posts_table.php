<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("slug");
            $table->string("canonical")->nullable();
            $table->string("title")->nullable();
            $table->string("description")->nullable();
            $table->string("subtitle")->nullable();
            $table->string("summery")->nullable();
            $table->text("content")->nullable();
            $table->unsignedBigInteger("category_id")->index()->nullable();
            $table->foreign("category_id")->references("id")->on("categories");
            $table->unsignedBigInteger("author_id")->index()->nullable();
            $table->foreign("author_id")->references("id")->on("users");
            $table->enum("status", ["draft", "in_review", "ready", "publish"])->default("publish");
            $table->enum("visibility", ["private", "public"])->default("public");
            $table->bigInteger("order")->default(0);
            $table->json("extra")->nullable();
            $table->dateTime("published_at")->default(now()->format("Y-m-d H:i:s"));
            $table->dateTime("expired_at")->nullable();
            $table->unsignedBigInteger("parent_id")->index()->nullable();
            $table->foreign("parent_id")->references("id")->on("posts")->onUpdate("cascade");

            $table->unsignedBigInteger("update_id")->nullable();
            $table->foreign("update_id")->references("id")->on("posts")->onUpdate("cascade");
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
        Schema::dropIfExists('posts');
    }
}
