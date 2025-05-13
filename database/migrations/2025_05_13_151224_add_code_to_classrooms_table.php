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
        Schema::table('classrooms', function (Blueprint $table) {
            $table->string('code', 6)->unique()->after('subject');
        });
    }
    
    public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
    
};
