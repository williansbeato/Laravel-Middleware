<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Matricula extends Migration
{
  
    public function up(){
        Schema::create('matriculas', function (Blueprint $table) {
            
            $table->unsignedBigInteger('aluno_id');
            $table->foreign('aluno_id')->references('id')->on('alunos');
            $table->unsignedBigInteger('disciplina_id');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
            $table->primary(['aluno_id','disciplina_id']);

            $table->timestamps();
        });
    }

   
    public function down(){
        Schema::dropIfExists('matriculas');
    }
}
