<?php
namespace App\Http\Controllers;
use App\Aluno;
use App\Curso;
use App\Disciplina;
use App\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller{


    public function index(){ }
 
  
    public function create(){ }

    public function store(Request $request){
           
        $aluno = Aluno::find($request->aluno_id);
        $disciplina = Disciplina::find($request->disciplina_id);

        if(isset($aluno) && isset($disciplina)){
            $matricula = new Matricula();
            $matricula->aluno()->associate($aluno);
            $matricula->disciplina()->associate($disciplina);
            $matricula->save();

            return json_encode($matricula);
        }
        

        return response('Disciplina ou Aluno não encontrado', 404);
    }

    public function show($id)
    {
        $matricula = Matricula::where('aluno_id', $id)->with(['aluno', 'disciplina'])->get();
        $aluno = Aluno::where('id', $id)->with('curso')->first();
        $disciplinas = Disciplina::where('curso_id', $aluno->curso_id)->get();

        if(isset($matricula)){
            return view('matricula.index', compact(['matricula', 'disciplinas', 'aluno']));
        }

        return json_encode('Matrícula não encontrada', 404);
    }

    
    public function edit($id){ }
 
    
    
    public function update(Request $request, $id){ }
 

    public function destroy($id)
    {
        $matricula = Matricula::where('aluno_id', $id)->delete();
        return response('OK', 200);
    }
}