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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('type')->default('i');
            $table->string('password');
            $table->string('email');
            $table->string('profile_picture')->nullable();
            $table->string('expertise')->nullable();
            $table->string('experience')->nullable();
            $table->string('innovations')->nullable();
            $table->string('links')->nullable();
            $table->string('certs')->nullable();
            $table->timestamp('registration_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('active')->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
