<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("price");
            $table->unsignedFloat("discount")->default(0);
            $table->unsignedFloat("tax")->default(0);
            $table->unsignedSmallInteger("wallet_id")->index();
            $table->foreign("wallet_id")->references("id")->on("wallets");
            $table->unsignedBigInteger("post_id")->index();
            $table->foreign("post_id")->references("id")->on("posts");
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
        Schema::dropIfExists('costs');
    }
}
