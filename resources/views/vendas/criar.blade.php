@extends('base')

@section('title','Nova venda')

@section('content')

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <label>Cliente</label>
                <select class="custom-select" id="id_cliente" readonly="false">
                    
                    
                </select>
            </div>

            <div class="col-md-12 col-sm-12">
                <label>Valor:</label>
                <input type="text" class="form-control" id="valor" name="valor">
            </div>

            <div class="col-md-12 col-sm-12">
                <button class="btn btn-success" id="btn_cadastrar">Nova venda</button>
            </div>

            <div class="col-md-12 col-sm-12" id="produtos" style="display:none;">
            
                Venda Nº:<input class="form-control" id="vendaNum" readonly="true">
                <table  class="table">
                    <thead>
            
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Quantidade da venda</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="tbody_produtos">

                    </tbody>
                </table>
            </div>
            <div class="col-md-12 col-sm-12" id='btn_final' style="display:none;">
                <button type="button" class="btn btn-danger my-sm-1" id="exclir_todosItens">Limpar Itens</button>
                <button type="button" class="btn btn-success  my-sm-0" id="finalizar_venda">Finalizar venda</button>
            </div>
            
            
        </div>
    </div>
</body>


<script>
     $(document).ready(function() {
            $.ajax({
                url: '{{ url('/api/listarCliente') }}',
                type: 'GET',
                success: function(data) {
                    trHTML = "<option selected>Selecione o cliente...</option>";
                    for (let i = 0; i < data.length; i++) {

                        console.log(data[i]);
                        trHTML += `
                            <option value="${data[i].id}">${data[i].nome}</option>
                    `;
                    }

                    $('#id_cliente').html(trHTML);
                }
            });
        });
    $(document).on('click', '#btn_cadastrar', function() {
        let id_cliente = $('#id_cliente').val();
        let valor = $('#valor').val();

        $.ajax({
            url: '{{url('/api/novavenda ')}}',
            type: 'POST',
            data: {
                "id_cliente": id_cliente,
                "valor":valor
            },
            success: function(data) {
                alert(data.status);
                console.log(data);
                document.getElementById("produtos").style.display = 'block';
                document.getElementById("btn_cadastrar").style.display = 'none';
                document.getElementById("vendaNum").value = data.id_venda;
                document.getElementById("id_cliente").readOnly = true;
                document.getElementById("valor").readOnly = true;
                
                $.ajax({
                    url:'{{url('/api/listarprodutos')}}',
                    type:'GET',
                    async: false,
                    success: function(data) {
                trHTML = "";
                
                for (let i = 0; i < data.length; i++) {
                    trHTML += `
                        <tr>
                            <td>${data[i].id}</td>
                            <td>${data[i].descricao}</td>
                            <td>R$ ${data[i].valor}</td>
                            <td><button class="btn btn-success addItem" id="${data[i].id}" value="${data[i].id}"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                <button class="btn btn-danger removeItem" id="${data[i].id}" value="${data[i].id}"><i class="fa fa-times" aria-hidden="true"></i></button>
                            <td><input class="form-control qtdVenda" id="qtdVenda${data[i].id}" readonly="true"></td>
                            <td><button class="btn btn-danger deleteItem" id="${data[i].id}" value="${data[i].id}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </tr>
                    `;
                }
                $('#tbody_produtos').html(trHTML);
                
            }
                });
            }
        });
    });
    $(document).on('click', '.addItem', function() {
        let id_venda = $('#vendaNum').val();
        let id_item = $(this).attr("id");
        let quantidade_vendida = document.getElementById("qtdVenda"+id_item).value;
        if(!quantidade_vendida)
            quantidade_vendida=0;
        
        
        quantidade_vendida = parseInt(quantidade_vendida)+1;
        
        document.getElementById("qtdVenda"+id_item).value = quantidade_vendida;
        
       
        $.ajax({
            url: '{{url('/api/adicionarprodutos')}}',
            type: 'POST',
            data: {
                "id_venda": id_venda,
                "quantidade_vendida":quantidade_vendida,
                "id_produto":id_item
            },
            success:function(data){
                
                total = data.valor;
                console.log(total);
                document.getElementById("valor").value =total.toFixed(2);
                document.getElementById("btn_final").style.display = 'block';
            }
            });
    
    });

    $(document).on('click', '.removeItem', function() {
        let id_venda = $('#vendaNum').val();
        let id_item = $(this).attr("id");
        let quantidade_vendida = document.getElementById("qtdVenda"+id_item).value;
        if(!quantidade_vendida)
            quantidade_vendida=0;
       
        quantidade_vendida = parseInt(quantidade_vendida)-1;
        
        document.getElementById("qtdVenda"+id_item).value = quantidade_vendida;
        
       
        $.ajax({
            url: '{{url('/api/adicionarprodutos')}}',
            type: 'POST',
            data: {
                "id_venda": id_venda,
                "quantidade_vendida":quantidade_vendida,
                "id_produto":id_item
            },
            success:function(data){
                
                total = data.valor;
                console.log(total);
                document.getElementById("valor").value =total.toFixed(2);
                document.getElementById("btn_final").style.display = 'block';
            }
            });
    
    });

    $(document).on('click', '.deleteItem', function() {

        let id_venda = $('#vendaNum').val();
        let id_item = $(this).attr("id");
      
   
        console.log(id_venda);
        console.log(id_item);
      
        $.ajax({
            url: '{{url('/api/removerproduto')}}/' + id_venda +'/'+id_item,
            type: 'DELETE',
            data: {
                "id_venda": id_venda,
                "id_produto":id_item
            },
            success:function(data){
                total = data.valor;
                console.log(data);
                document.getElementById("valor").value =total.toFixed(2);
               
                document.getElementById("qtdVenda"+id_item).value="";
            }
        });
    });

    $(document).on('click','#finalizar_venda',function(){
        let id_venda =$('#vendaNum').val();
        $.ajax({
            url:'{{url('/api/finalizarvenda')}}/'+id_venda,
            type:'PUT',
            success:function(data){
                alert(data.status);
                window.location.href = "{{ url('/vendas/acao') }}";
                
            }
        });
    });

    $(document).on('click','#exclir_todosItens',function(){
        let id_venda = $('#vendaNum').val();
        $.ajax({
            url:'{{url('/api/removerproduto')}}/'+id_venda,
            type:'DELETE',
            success:function(data){
                console.log(data.status);
                document.getElementById("valor").value =0.00;
              
                document.getElementsByClassName("form-control qtdVenda").value="";
            }
        });
        console.log(id_venda);
    });

</script>

@endsection