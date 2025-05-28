<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('points')->default(0);
            $table->integer('time')->default(0); // in seconds
        });
    }
    
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['points', 'time']);
        });
    }
    
};
