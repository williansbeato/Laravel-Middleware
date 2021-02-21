<div class="table-responsive" style="overflow-x:visible; overflow-y: visible;">
        <table class="table table-striped" id="tabela">
            <thead >
                <tr style="text-align: center">
                    @foreach ($header as $item)
                        <th>{{$item}}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
            @foreach ($data as $item)

                <tr style="text-align: center">
                
                    <td style="display:none;">{{ $item->id}}</td>

                    <td>{{ $item->nome}}</td>
                    <td>{{ $item->curso->nome }}</td>
                    <td>{{ $item->professor->nome  }}</td>

                 
                    <td  class="text-center d-flex align-items-center justify-content-center">
                  
                        <a class="btn" nohref style="cursor:pointer" onCLick="editar('{{ $item['id'] }}')">
                            <i class="fa fa-pencil"></i>
                        </a>
                        
                        <form action="{{ route('disciplina.destroy', $item['id']) }}" method="POST" name="form_{{$item['id']}}">
                            @csrf
                            @method('DELETE')
                           
                        </form>            
                        
                       
                    </td>
                    
                </tr>

                @endforeach

                </tbody>

        </table>
    </div>
