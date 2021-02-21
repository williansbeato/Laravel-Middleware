<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Aluno;
use App\Curso;

class AlunoController extends Controller{

   /* public function __construct(){

        $this->middleware('Mid');
    }
*/

    public function index(){
    
        $curso = Curso::all();
        $aluno = Aluno::with(['curso','disciplina'])->get();
               
        return view('aluno.index', compact(['aluno' , 'curso']));
 
    }
 
     public function create(){ }
 
     public function store(Request $request){

        $curso = Curso::find($request->curso);

        if(isset($curso)){
            
            $aluno = new Aluno();
            $aluno -> nome = mb_strtoupper($request->input('nome'),'UTF-8');
            $aluno -> email = $request -> input('email');
            $aluno -> curso()->associate($curso);

            $aluno -> save();
    
            return json_encode($aluno);
        }

        return response('Aluno não encontrado', 404);

    }
     
     public function show($id){
 
         $aluno = Aluno::with('curso')->find($id);

 
         if(isset($aluno)){
             return json_encode($aluno);
         }
 
         return response('Aluno não encontrado', 404);
 
    }
    
     public function edit($id){ }
     
     public function update(Request $request, $id){
         
        $aluno = Aluno::find($id);

        $curso = Curso::find($request->curso);

        if(isset($aluno) && isset($curso)){

            $aluno -> nome = mb_strtoupper($request->input('nome'),'UTF-8');
            $aluno -> email = $request -> input('email');
            $aluno -> curso()->associate($curso);

            $aluno -> save();

            return json_encode($aluno);
        }
    
        return response("Aluno não encontrado!", 404);
 
    }
     
    public function destroy($id){
 
        $aluno = Aluno::find($id);

        if(isset($aluno)){
            $aluno -> delete();   
            return response("OK", 200);
        }
 
        return response('Aluno não encontrado', 404);
    }
}
