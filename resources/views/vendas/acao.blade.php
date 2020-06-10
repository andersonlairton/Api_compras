@extends('base')

@section('title','Listar Vendas')

@section('content')

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
            <a href="{{ url('/vendas/criar') }}" class="btn btn-success" id="btn_cadastrar">Nova venda</a>
            </div>
            <div class="col-md-12 col-sm-12">
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data Venda</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_vendas">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewVendaCompleta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{url('/api/listarvendas ')}}',
            type: 'GET',
            success: function(data) {
                trHTML = "";
                for (let i = 0; i < data.length; i++) {
                    trHTML += `
                        <tr>
                            <td>${data[i].id}</td>
                            <td>${data[i].id_cliente}</td>
                            <td>R$ ${data[i].valor}</td>
                            <td>${data[i].data_venda}</td>
                            <td><i id="${data[i].id}" class="fa fa-search openModal view" style="color:#CCC" aria-hidden="true"></i></td>
                           </tr>
                    `;
                }
                $('#tbody_vendas').html(trHTML);
            }
        });
        
    });

    $(document).on('click','.openModal',function(){
        let vendaId = $(this).attr("id");

        $.ajax({
            url:'{{url('/api/listarprodutosvenda')}}/'+vendaId,
            type:'GET',
            async:false,
            success:function(data){
                console.log(data['venda'].data_venda !=null);

                let content = `
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label>Id venda</label>
                        <input type="text" class="form-control" id="id_venda" value="${data['venda'].id}" readonly="true">
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label>Id Cliente</label>
                        <input type="text" class="form-control" id="id_cliente" value="${data['venda'].id_cliente}" readonly="true">
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label>Valor</label>
                        <input type="text" class="form-control" id="valor" value="${data['venda'].valor}" readonly="true">
                    </div>
                </div>
                `;
                
                content+=` 
                <div class="col-md-12 col-sm-12" id="produtosVendidos">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Quantidade Vendida</th>
                                <th scope="col">Valor unitario</th>
                            </tr>
                        </thead>
                        <tbody>`;
                
                for (let i = 0; i < data['produtos'].length; i++) {
                    content += `
                        <tr >
                            <td>${data['produtos'][i].descricao}</td>
                            <td>${data['produtos'][i].quantidade_vendida}</td>
                            <td>R$ ${(data['produtos'][i].valor).toFixed(2)}</td>
    
                            <td><i id="${data['produtos'][i].id}" class="openModal edit" style="color:blue" aria-hidden="true"></i></td>
                            <td><i id="${data['produtos'][i].id}" class="removeItem" style="color:red" aria-hidden="true"></i></td>
                        </tr>
                    `;

                }
                if(data['venda'].data_venda ==null){
                    content+=`
                        </tbody>  
                        </table>
                    
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <button type="button" class="btn btn-success my-sm-1" id="adicionar_itens">Adicionar Itens</button>
                        <button type="button" class="btn btn-danger my-sm-1" id="exclir_todosItens">Limpar Itens</button>
                        <button type="button" class="btn btn-success  my-sm-0" id="finalizar_venda">Finalizar venda</button>
                    </div>
                `;
                }
                $('.modal-body').html(content);
            }
        });

        $('#viewVendaCompleta').modal('show');
    });

    $(document).on('click','#adicionar_itens',function(){
       
       document.getElementById("produtosVendidos").style.display = 'none';
       $.ajax({
                    url:'{{url('/api/listarprodutos')}}',
                    type:'GET',
                    async: false,
                    success: function(data) {
                trHTML = `
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
                        </tr>`;
                
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
                trHTML+=`
                </thead>
                </table>
                
                
                `;
                
                
            }
                });
        $('.modal-footer').html(trHTML);
  
    });

    $(document).on('click', '.close', function() {
        location.reload();
        });
    $(document).on('click','#exclir_todosItens',function(){
        let id_venda = $('#id_venda').val();
        $.ajax({
            url:'{{url('/api/removerproduto')}}/'+id_venda,
            type:'DELETE',
            success:function(data){
                alert(data.status);
                location.reload();
            }
        });
        console.log(id_venda);
    });
    $(document).on('click','#finalizar_venda',function(){
        let id_venda = $('#id_venda').val();
        $.ajax({
            url:'{{url('/api/finalizarvenda')}}/'+id_venda,
            type:'PUT',
            success:function(data){
                alert(data.status);
                location.reload();
            }
        });
    });

    $(document).on('click', '.addItem', function() {
        let id_venda = $('#id_venda').val();
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
               
            }
            });
    
    });

    $(document).on('click', '.removeItem', function() {
        let id_venda = $('#id_venda').val();
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
                
            }
            });
    
    });

    $(document).on('click', '.deleteItem', function() {

        let id_venda = $('#id_venda').val();
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

</script>
@endsection