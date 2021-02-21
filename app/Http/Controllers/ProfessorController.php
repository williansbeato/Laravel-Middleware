<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Professor;


class ProfessorController extends Controller{

    public function index(){

       $professor = Professor::all();
       
       return view('professor.index', compact(['professor']));

    }

 
    public function create(){ }

    public function store(Request $request){
        $professor = new Professor();
        $professor -> nome = mb_strtoupper($request->input('nome'),'UTF-8');
        $professor -> email = $request -> input('email');
        $professor -> save();


        return json_encode($professor);
    }

   
    public function show($id){

        $professor = Professor::find($id);

        if(isset($professor)){
            return json_encode($professor);
        }

        return response('Professor não encontrado', 404);

    }

  
    public function edit($id){ }

   
    public function update(Request $request, $id){
        
        $professor = Professor::find($id);

        if(isset($professor)){
            $professor -> nome = mb_strtoupper($request->input('nome'),'UTF-8');
            $professor -> email = $request -> input('email');
            $professor -> save();     
            return json_encode($professor);
  
        }

        return response('Professor não encontrado', 404);

    }

   
    public function destroy($id){
        $professor = Professor::find($id);

        if(isset($professor)){
            $professor -> delete();   
            return response("OK", 200);
        }

        return response('Professor não encontrado', 404);
    }
}
