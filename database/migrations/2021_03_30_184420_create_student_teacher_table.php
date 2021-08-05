<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_teacher', function (Blueprint $table) {
            $table->foreignId('student_user_id')->constrained('users');
            $table->foreignId('teacher_user_id')->constrained('teachers', 'user_id');
            $table->foreignId('studenttype_id')->constrained();
            $table->timestamps();
            $table->primary(['student_user_id','teacher_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_teacher');
    }
}