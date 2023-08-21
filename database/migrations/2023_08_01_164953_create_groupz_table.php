<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupzTable extends Migration
{
    public function up()
    {
        Schema::create('groupz', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('admin_id');
            $table->string('group_image')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groupz');
    }
};
