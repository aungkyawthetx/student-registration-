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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('nrc');
            $table->date('dob');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('parent_info');
            $table->timestamps();
            $table->unique(['name', 'gender', 'nrc','dob','email','phone','address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
