<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model{
        
    public function disciplina(){
        return $this->hasMany('\App\Disciplina');
    }

    public function aluno(){
        return $this->hasMany('\App\Aluno');
    }

}
