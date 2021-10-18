<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bug_reports', function (Blueprint $table) {
            $table->id();
            $table->string("full_name")->nullable()->comment("feature name");
            $table->string("email")->nullable()->comment("feature name");
            $table->string("mobile")->nullable()->comment("feature name");
            $table->string("title")->nullable()->comment("feature name");
            $table->string("environment")->nullable();
            $table->string("scenario")->nullable()->comment("the reason to happen event");
            $table->string("expected_result")->nullable();
            $table->string("actual_result")->nullable();
            $table->boolean("gift")->nullable();
            $table->enum("visual_proof", ["screenshot", "video", "text"])->nullable();
            $table->enum("priority", ["minor", "medium", "critical"])->nullable();
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
        Schema::dropIfExists('bug_reports');
    }
}
