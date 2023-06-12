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
            $table->foreignId('course_id');
            $table->string('qr_code', 10);
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('fullname')->unique();
            $table->string('gender')->nullable();
            $table->date('dob');
            $table->string('civil_status')->nullable();
            $table->string('nationality')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('highest_grade_completed')->nullable();
            $table->string('classification');
            $table->string('training_status');
            $table->string('scholarship_type');
            $table->boolean('training_completed')->default(false);
            $table->text('image')->nullable();
            $table->boolean('accepted')->default(false);
            $table->timestamps();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses');
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
