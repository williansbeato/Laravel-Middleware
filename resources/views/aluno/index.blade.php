@extends('templates.main', ['titulo'=> "Aluno",'tag' => "ALU"])

@section('conteudo')
<div class="row">
    <div class="col-sm-12">
        <button class="btn btn-primary btn-block" onClick="criar()">
           <b>Cadastrar Novo Aluno</b>
        </button>     
    </div>
</div>
        
<x-alunoTableList :header="['Nome','E-mail','Curso','Disciplina','Eventos']" :data="$aluno"/>

<div class="modal fade" tabindex="-1" role="dialog" id="modalAluno"> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formAluno">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Novo Aluno</b></h5>
                </div>

                <div class="modal-body">

                    <input type="hidden" class="form-control" id="id">
                    <div class="row">
                        <div class="col-sm-12">
                            <label><b>Nome</b></label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-12">
                            <label><b>E-mail</b></label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-12">
                            <label><b>Curso</b></label>
                            <select class="form-control" name="curso" id="curso" required>
                                @foreach ( $curso ?? [] as $item)
                                    <option value="{{ $item->id }}"><p> {{ $item->nome }} </p></option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    


                </div>

                <div class="modal-footer">
                    
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modalInfo"> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Informações da Aluno</b></h5>
            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">       
                <button type="cancel" class="btn btn-success" data-dismiss="modal"><b>OK</b></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalRemove"> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="id_remove" class="form-control">
            <div class="modal-header">
                <h5 class="modal-title"><b>Remover Aluno</b></h5>
            </div>

            <div class="modal-body">

            </div>

            <div class="modal-footer">    
                <button class="btn btn-danger" onClick="remove()"><b>Remover</b></button>
                <button type="cancel" class="btn btn-secondary" data-dismiss="modal"><b>Cancelar</b></button>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script type="text/javascript">

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN' : "{{csrf_token()}}"
            }
        });

        function criar(){
           
            $('#modalAluno').modal().find('.modal-title').text("Cadastrar Aluno");
            $('#id').val('');
            $('#nome').val('');
            $('#curso').removeAttr('selected');
            $('#modalAluno').modal('show');
        }

        function editar(id){
            $('#modalAluno').modal().find('.modal-title').text("Alterar Aluno");

            $.getJSON('/api/aluno/'+ id, function(data){
               

                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#email').val(data.email);
                $('#curso').val(data.curso_id);    


                $('#modalAluno').modal('show');    
                
            });        
        }

        function remover(id, nome){
            $('#modalRemove').modal().find('.modal-title').text("");
            $('#modalRemove').modal().find('.modal-title').append("Deseja Remover o Aluno '"+ nome +"'?");
            $('#id_remove').val(id);
            $('#modalRemove').modal('show');

        }

        function visualizar(id){
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/aluno/'+ id, function(data){

                $('#modalInfo').modal().find('.modal-body').append("<b>ID:</b> " + data.id + "<br></br>");
                $('#modalInfo').modal().find('.modal-body').append("<b>NOME:</b> " + data.nome + "<br></br>");
                $('#modalInfo').modal().find('.modal-body').append("<b>E-MAIL:</b> " + data.email + "<br></br>");
                $("#modalInfo").modal().find('.modal-body').append("<b>CURSO:</b> " + data.curso.nome + "<br><br>");

            });

        }

        $("#formAluno").submit( function(event){

            event.preventDefault();

            if($("#id").val() !=''){
                update( $("#id").val() );

            }
            else{
                insert();
               
            }

            $("#modalAluno").modal('hide');
        });

        function insert(){
            
            aluno = {
                nome: $("#nome").val(),
                email: $("#email").val(),
                curso: $("#curso").val()

            };

            $.post("/api/aluno", aluno , function(data){
                novoAluno = JSON.parse(data);
                linha = getLin(novoAluno);
                $("#tabela>tbody").append(linha)

            });
        }

        function update(id){
            aluno = {
                nome : $("#nome").val(),
                email: $("#email").val(),
                curso: $("#curso").val()

            }

            $.ajax({
                type: "PUT",
                url : "/api/aluno/" + id,
                context : this,
                data : aluno,
                success : function(data) {
                    linhas = $("#tabela>tbody>tr");

                    e = linhas.filter(function(i,e){
                        return e.cells[0].textContent == id;
                    });

                    if(e){
                        e[0].cells[1].textContent = aluno.nome.toUpperCase();
                    }
                },
                error : function(error){
                    alert('ERRO - UPDATE');
                }
            });
        }

        function remove(){
            var id = $("#id_remove").val();

            $.ajax({
                type: "DELETE",
                url : "/api/aluno/" + id,
                context : this,
                success : function() {
                    linhas = $("#tabela>tbody>tr");

                    e = linhas.filter(function(i,e){
                        return e.cells[0].textContent == id;
                    });

                    if(e){
                        e.remove();
                    }
                },
                error : function(error){
                    alert('ERRO - DELETE');
                }
            });

            $('#modalRemove').modal('hide');

        }

        function getLin(aluno){

                var linha = 
                "<tr style='text-align: center'>" +

                    "<td>" + aluno.nome + "</td>" +
                    "<td>" + aluno.email + "</td>" +
                    "<td>" + aluno.curso.nome + "</td>" +
                    "<td>"+
                       "<select class='form-control'>"+
                           "@foreach($item->disciplina as $disciplina)" +
                                "<option>{{$disciplina->nome}}</option>" +
                            "@endforeach" +
                        "</select>" +
                    "</td>" +

                    "<td>" +   

                        "<a class='btn' nohref style='cursor:pointer' onCLick='editar("+ aluno.id +")'><i class='fa fa-pencil'></i></a>" + 
                        "<a class='btn' style='cursor: pointer' href='{{route('matricula.show', $item->id)}})}}'><i class='fa fa-asterisk'></i></a>" +
                    
                    "</td>" +
                "</tr>";

                return linha;

            }
        
    </script>
        
@endsection