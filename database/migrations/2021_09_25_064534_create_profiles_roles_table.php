<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_roles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("profile_id")->index();
            $table->foreign("profile_id")->references("id")->on("profiles");

            $table->unsignedBigInteger("role_id")->index();
            $table->foreign("role_id")->references("id")->on("roles");

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
        Schema::dropIfExists('profiles_roles');
    }
}
