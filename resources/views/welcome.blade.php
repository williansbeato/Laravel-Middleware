@extends('templates.main', ['titulo'=> "Home",'tag' => "HOME"])

@section('conteudo')
    <div class="d-flex justify-content-center"> 
        <div class="item-menu" style="margin-right: 100px;">
            <a href="{{ route('curso.index') }}">
                <img src="{{ asset('image/curso_ico.png') }}" style="width: 150px;">
                <h4 class="text-center text-dark"><b>Curso</b></h4>
            </a>
        </div>

        <div class="item-menu" style="margin-right: 100px;">
            <a href="{{ route('disciplina.index') }}">
                <img src="{{ asset('image/componente_ico.png') }}" style="width: 150px;">
                <h4 class="text-center text-dark"><b>Disciplina</b></h4>
            </a>
        </div>

        <div class="item-menu" style="margin-right: 100px;">
            <a href="{{ route('professor.index') }}">
                <img src="{{ asset('image/professor_ico.png') }}" style="width: 150px;">
                <h4 class="text-center text-dark"><b>Professor</b></h4>
            </a>
        </div>

        <div class="item-menu">
            <a href="{{ route('aluno.index') }}">
                <img src="{{ asset('image/aluno_ico.png') }}" style="width: 150px;">
                <h4 class="text-center text-dark"><b>Aluno</b></h4>
            </a>
        </div>
    </div>
@endsection