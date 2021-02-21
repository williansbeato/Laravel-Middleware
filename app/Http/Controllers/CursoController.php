<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Curso;


class CursoController extends Controller{

    public function index(){

       $curso = Curso::all();
       
       return view('curso.index', compact(['curso']));

    }

 
    public function create(){ }

    public function store(Request $request){

        $curso = new Curso();
        $curso -> nome = mb_strtoupper($request->input('nome'),'UTF-8');
        $curso -> save();

        return json_encode($curso);
    }

   
    public function show($id){

        $curso = Curso::find($id);

        if(isset($curso)){
            return json_encode($curso);
        }

        return response('Curso não encontrado', 404);
    }

  
    public function edit($id){ }

   
    public function update(Request $request, $id){
        
        $curso = Curso::find($id);

        if(isset($curso)){
            
            $curso -> nome = mb_strtoupper($request->input('nome'),'UTF-8');
            $curso -> save();   

            return json_encode($curso);
  
        }

        return response('Curso não encontrado', 404);

    }

   
    public function destroy($id){
        $curso = Curso::find($id);

        if(isset($curso)){
            $curso -> delete();   
            return response("OK", 200);
        }

        return response('Curso não encontrado', 404);
    }
}
