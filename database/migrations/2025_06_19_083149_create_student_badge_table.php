<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_badge', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('badge_id');
            $table->unsignedBigInteger('student_id'); // user_id with student role
            $table->timestamps();
        
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_badge');
    }
};
