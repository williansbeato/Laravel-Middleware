@extends('templates.main', ['titulo'=> "Disciplina",'tag' => "DIS"])

@section('conteudo')
<div class="row">
    <div class="col-sm-12">
        <button class="btn btn-primary btn-block" onClick="criar()">
           <b>Cadastrar Novo Disciplina</b>
        </button>     
    </div>
</div>
        
<x-disciplinaTableList :header="['Nome','Curso','Professor','Eventos']" :data="$disciplina"/>

<div class="modal fade" tabindex="-1" role="dialog" id="modalDisciplina"> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formDisciplina">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Novo Disciplina</b></h5>
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
                            <label><b>Curso</b></label>
                            <select class="form-control" name="curso" id="curso" required>
                                @foreach ( $curso as $item)
                                    <option value="{{ $item->id }}"><p> {{ $item->nome}} </p></option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-top:10px">
                        <div class="col-sm-12">
                            <label><b>Professor</b></label>
                            <select class="form-control" name="professor" id="professor" required>
                                @foreach ( $professor ?? [] as $item)
                                    <option value="{{ $item->id }}"><p> {{ $item->nome}} </p></option>
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
                <h5 class="modal-title"><b>Informações da Disciplina</b></h5>
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
                <h5 class="modal-title"><b>Remover Disciplina</b></h5>
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
           
            $('#modalDisciplina').modal().find('.modal-title').text("Cadastrar Disciplina");
            $('#id').val('');
            $('#nome').val('');
            $('#curso').removeAttr('selected');
            $('#professor').removeAttr('selected');
            $('#modalDisciplina').modal('show');
        }

        function editar(id){
            $('#modalDisciplina').modal().find('.modal-title').text("Alterar Disciplina");

            $.getJSON('/api/disciplina/'+ id, function(data){
               
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#curso').val(data.curso_id);
                $('#professor').val(data.professor_id);

                $('#modalDisciplina').modal('show');    
                
            });        
        }

        function remover(id, nome){
            $('#modalRemove').modal().find('.modal-title').text("");
            $('#modalRemove').modal().find('.modal-title').append("Deseja Remover o Disciplina '"+ nome +"'?");
            $('#id_remove').val(id);
            $('#modalRemove').modal('show');

        }

        function visualizar(id){
            $('#modalInfo').modal().find('.modal-body').html("");

            $.getJSON('/api/disciplina/'+ id, function(data){

                $('#modalInfo').modal().find('.modal-body').append("<b>ID:</b> " + data.id + "<br></br>");
                $('#modalInfo').modal().find('.modal-body').append("<b>NOME:</b> " + data.nome + "<br></br>");
                $("#modalInfo").modal().find('.modal-body').append("<b>CURSO:</b> " + data.curso.nome + "<br><br>");
                $("#modalInfo").modal().find('.modal-body').append("<b>PROFESSOR:</b> " + data.professor.nome + "<br><br>");

            });

        }

        $("#formDisciplina").submit( function(event){

            event.preventDefault();

            if($("#id").val() !=''){
                update( $("#id").val() );

            }
            else{
                insert();
               
            }

            $("#modalDisciplina").modal('hide');
        });

        function insert(){
            
            disciplina = {
                nome: $("#nome").val(),
                curso: $("#curso").val(),   
                professor: $("#professor").val()


            };

            $.post("/api/disciplina", disciplina , function(data){
                novoDisciplina = JSON.parse(data);
                linha = getLin(novoDisciplina);
                $("#tabela>tbody").append(linha)

            });
        }

        function update(id){
            disciplina = {
                nome : $("#nome").val(),
                curso: $("#curso").val(),
                professor: $("#professor").val()

            }

            $.ajax({
                type: "PUT",
                url : "/api/disciplina/" + id,
                context : this,
                data : disciplina,
                success : function(data) {
                    linhas = $("#tabela>tbody>tr");

                    e = linhas.filter(function(i,e){
                        return e.cells[0].textContent == id;
                    });

                    if(e){
                        e[0].cells[1].textContent = disciplina.nome.toUpperCase();
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
                url : "/api/disciplina/" + id,
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

        function getLin(disciplina){

                var linha = 
                "<tr style='text-align: center'>" +


                    "<td>" + disciplina.nome + "</td>" +
                    "<td>" + disciplina.curso.nome + "</td>" +
                    "<td>" + disciplina.professor.nome + "</td>" +



                    "<td>" +   
                        "<a class='btn' nohref style='cursor:pointer' onCLick='editar("+ disciplina.id +")'><i class='fa fa-pencil'></i></a>" + 
                    "</td>" +
                "</tr>";

                return linha;

            }
        

    </script>
        
@endsection