<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMembershipTable extends Migration
{
    public function up()
    {
        Schema::create('group_membership', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('groupz_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('groupz_id')->references('id')->on('groupz')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_membership');
    }
}
