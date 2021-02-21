<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Disciplina;
use App\Curso;
use App\Professor;

class DisciplinaController extends Controller{

    public function index(){

        $curso = Curso::all();

        $professor = Professor::all();

        $disciplina = Disciplina::with(['curso','professor'])->get();

        return view('disciplina.index', compact(['disciplina','curso','professor']));
 
     }
 
  
     public function create(){ }
 
     public function store(Request $request){


        $curso = Curso::find($request->curso);
        $professor = Professor::find($request->professor);


            if(isset($curso) && isset($professor)) {

                $disciplina = new Disciplina();

                $disciplina -> nome = mb_strtoupper($request->input('nome'),'UTF-8');

                $disciplina -> curso()->associate($curso);

                $disciplina -> professor()->associate($professor);

                $disciplina -> save();
    
            return json_encode($disciplina);

            }

      

        return response('Curso e/ou Professor não encontrado', 404);

    }
 
    
     public function show($id){

        $disciplina = Disciplina::with('curso','professor')->find($id);


 
         if(isset($disciplina)){
             return json_encode($disciplina);
         }
 
         return response('Disciplina não encontrado', 404);
 
     }
 
   
    public function edit($id){ }
 
    
    
    public function update(Request $request, $id){
         
        $disciplina = Disciplina::find($id);
        $curso = Curso::find($request->curso);
        $professor = Professor::find($request->professor);
 
        if(isset($disciplina) && isset($curso) && isset($professor)){
             
            $disciplina -> nome = mb_strtoupper($request->input('nome'),'UTF-8');

            $disciplina -> curso()->associate($curso);

            $disciplina -> professor()->associate($professor);

            $disciplina -> save(); 
 
            return json_encode($disciplina);
   
        }
 
        return response('Disciplina não encontrado', 404);
 
    }
 
    
    public function destroy($id){
         $disciplina = Disciplina::find($id);
 
         if(isset($disciplina)){
             $disciplina -> delete();   
             return response("OK", 200);
         }
 
         return response('Disciplina não encontrado', 404);
    }
}
