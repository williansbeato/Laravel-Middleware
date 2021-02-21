<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model{

    public function curso() {
        return $this->belongsTo('\App\Curso');
    }

    public function aluno(){
        return $this->belongsToMany('\App\Aluno', 'matriculas');
    }

    public function professor() {
        return $this->belongsTo('\App\Professor');
    }
  
}