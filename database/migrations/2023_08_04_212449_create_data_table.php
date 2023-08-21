<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    public function up()
    {
        Schema::create('data_table', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('gender');
            $table->string('institution')->nullable();
            $table->string('job_title')->nullable();
            $table->string('participant_type')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('discipline')->nullable();
            $table->string('role_in_activity')->nullable();
            $table->string('country')->nullable();
            $table->text('remarks')->nullable();
            $table->string('sheet_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_table');
    }
}
