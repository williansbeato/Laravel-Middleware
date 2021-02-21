@extends('templates.main', ['titulo'=> "Negado"])

@section('conteudo')


<div class="d-flex justify-content-center"> 
    <div class="item-menu" >
        <a>
            <h2 class="text-center text-dark"><b>Acesso Restrito</b></h2>
            <br>
            <img src="{{ asset('image/restrito.png') }}">
        </a>
    </div>
    <br>
</div>

@endsection