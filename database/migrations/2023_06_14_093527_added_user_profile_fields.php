<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('type')->default('Alumni');
            $table->string('profile_picture')->nullable();
            $table->string('institution')->nullable();
            $table->string('faculty')->nullable();
            $table->date('grad_year')->nullable();
            $table->string('course')->nullable();
            $table->string('bio')->nullable();
            // $table->timestamp('registration_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('approved')->default(1);
            $table->string('location')->nullable();
            $table->string('interests')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('career')->nullable();
            $table->string('organisation')->nullable();
            $table->string('role')->default('User');
            $table->string('post_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //$table->dropColumn(['address', 'latitude','longitude']);
        });
    }
};
