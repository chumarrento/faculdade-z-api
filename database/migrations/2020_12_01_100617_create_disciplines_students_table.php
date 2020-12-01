<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinesStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplines_students', function (Blueprint $table) {
            $table->id();
            $table->float('final_grade')->nullable();
            $table->enum('status', ['Em Andamento', 'Aprovado', 'Reprovado'])->default('Em Andamento');
            $table->foreignId('student_id')->references('id')->on('students');
            $table->foreignId('discipline_id')->references('id')->on('disciplines');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disciplines_students');
    }
}
