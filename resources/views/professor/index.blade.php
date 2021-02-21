@extends('templates.main', ['titulo'=> "Professor",'tag' => "PRO"])

@section('conteudo')
<div class="row">
    <div class="col-sm-12">
        <button class="btn btn-primary btn-block" onClick="criar()">
           <b>Cadastrar Novo Professor</b>
        </button>        
    </div>
</div>
        
<x-professorTableList :header="['Nome','E-mail','Eventos']" :data="$professor"/>


<div class="modal fade" tabindex="-1" role="dialog" id="modalProfessor"> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formProfessor">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Novo Professor</b></h5>
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
                <h5 class="modal-title"><b>Informações do Professor</b></h5>
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
                <h5 class="modal-title"><b>Remover Professor</b></h5>
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
            $('#modalProfessor').modal().find('.modal-title').text("Cadastrar Professor");
            $('#id').val('');
            $('#nome').val('');
            $('#email').val('');
            $('#modalProfessor').modal('show');
        }

        function editar(id){
            $('#modalProfessor').modal().find('.modal-title').text("Alterar Professor");

            $.getJSON('/api/professor/'+id, function(data){
               
                $('#id').val(data.id);
                $('#nome').val(data.nome);
                $('#email').val(data.email);
                $('#modalProfessor').modal('show');    
                
            });        
        }

        function remover(id, nome){
            $('#modalRemove').modal().find('.modal-title').text("");
            $('#modalRemove').modal().find('.modal-title').append("Deseja Remover o Professor '"+ nome +"'?");
            $('#id_remove').val(id);
            $('#modalRemove').modal('show');

        }

        function visualizar(id){

            $('#modalInfo').modal().find('.modal-body').html("");
            
            $.getJSON('/api/professor/'+id, function(data){

                $('#modalInfo').modal().find('.modal-body').append("<b>ID:</b> " + data.id + "<br></br>");
                $('#modalInfo').modal().find('.modal-body').append("<b>NOME:</b> " + data.nome + "<br></br>");
                $('#modalInfo').modal().find('.modal-body').append("<b>E-MAIL:</b> " + data.email + "<br></br>");
                $('#modalInfo').modal('show');

            });

        }

        $("#formProfessor").submit( function(event){

            event.preventDefault();

            if($("#id").val() !=''){
                update( $("#id").val() );

            }
            else{
                insert();
               
            }

            $("#modalProfessor").modal('hide');
        });

        function insert(){
            
            professor = {
                nome: $("#nome").val(),
                email: $("#email").val(),

            };

            $.post("/api/professor", professor, function(data){
                novoProfessor = JSON.parse(data);
                linha = getLin(novoProfessor);
                $("#tabela>tbody").append(linha)

            });
        }

        function update(id){
            professor = {
                nome : $("#nome").val(),
                email : $("#email").val(),
            }

            $.ajax({
                type: "PUT",
                url : "/api/professor/" + id,
                context : this,
                data : professor,
                success : function(data) {
                    linhas = $("#tabela>tbody>tr");

                    e = linhas.filter(function(i,e){
                        return e.cells[0].textContent == id;
                    });

                    if(e){
                        e[0].cells[1].textContent = professor.nome.toUpperCase();
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
                url : "/api/professor/" + id,
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

        function getLin(professor){
            
            var linha = 
            "<tr style='text-align: center'>" +
                "<td>" + professor.nome + "</td>" +
                "<td>" + professor.email + "</td>" +
                "<td>" +   
                    "<a class='btn' nohref style='cursor:pointer' onCLick='editar("+ professor.id +")'><i class='fa fa-pencil'></i></a>" + 
                "</td>" +
            "</tr>";

            return linha;

        }

    </script>

@endsection
