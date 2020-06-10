@extends('base')

@section('title', 'Criar novo produto')

@section('content')

    <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Qtd. Estoque</th>
                        <th scope="col">Data cadastro</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="tbody_produtos">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="viewCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pruduto</h5>
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
                url: '{{ url('/api/listarprodutos') }}',
                type: 'GET',
                success: function(data) {
                    let trHTML = "";

                    for (let i = 0; i < data.length; i++) {

                        console.log(data[i]);
                        trHTML += `
                        <tr>
                            <td>${data[i].id}</td>
                            <td>${data[i].descricao}</td>
                            <td>${data[i].valor}</td>
                            <td>${data[i].quantidade_estoque}</td>
                            <td>${data[i].created_at}</td>
                            <td><i id="${data[i].id}" class="fa fa-file openModal view" style="color:#CCC" aria-hidden="true"></i></td>
                            <td><i id="${data[i].id}" class="fa fa-pencil openModal edit" style="color:blue" aria-hidden="true"></i></td>
                            <td><i id="${data[i].id}" class="fa fa-trash remove openModal" style="color:red" aria-hidden="true"></i></td>
                        </tr>
                    `;
                    }

                    $('#tbody_produtos').html(trHTML);
                }
            });
        });
        $(document).on('click', '.openModal', function() {
            let produtoId = $(this).attr("id");

            $.ajax({
                url: '{{ url('/api/listarprodutos') }}/' + produtoId,
                type: 'GET',
                async: false,
                success: function(data) {
                    console.log(data);

                    let content = `
                               <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <label>ID: </label>
                                        <input type="text" class="form-control" id="id" name="id" value="${data.id}" readonly="true">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <label>descricao: </label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" value="${data.descricao}">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <label>valor: </label>
                                        <input type="text" class="form-control" id="valor" name="valor" value="${data.valor}">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <label>quantidade_estoque: </label>
                                        <input type="text" class="form-control" id="quantidade_estoque" name="quantidade_estoque" value="${data.quantidade_estoque}">
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <label>Data cadastro: </label>
                                        <input type="text" class="form-control cpfOuCnpj" id="cpf_cnpj" name="cpf_cnpj" value="${data.created_at}" readonly="true">
                                    </div>
                            </div>
                        `;

                    $('.modal-body').html(content);

                }
            });

            $('#viewCliente').modal('show');
        });

        $(document).on('click', '.view', function() {
            $("input").prop("readonly", true);
            $('.modal-footer').html(`
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            `);
        });

        $(document).on('click', '.remove', function() {
            $("input").prop("readonly", true);

            $('.modal-footer').html(`
                <button type="button" class="btn btn-danger" id="exclir_cliente">Excluir cliente</button>
            `);
        });

        $(document).on('click', '.edit', function() {
            $('.modal-footer').html(`
                <button type="button" class="btn btn-primary" id="update_cliente">Atualizar Dados</button>
            `);
        });

        $(document).on('click', '#exclir_cliente', function() {
            let clienteId = $('#id').val();

            $.ajax({
                url: '{{ url('/api/excluirproduto') }}/' + clienteId,
                type: 'DELETE',
                success: function(data) {
                    alert(data.status);
                    location.reload();
                }
            });
        });

        $(document).on('click', '#update_cliente', function() {
            let produtoId = $('#id').val();

            let descricao = $('#descricao').val();
            let valor = $('#valor').val();
            let quantidade_estoque = $('#quantidade_estoque').val();

            $.ajax({
                url: '{{ url('/api/editarproduto') }}/' + produtoId,
                type: 'PUT',
                data: {
                    "descricao": descricao,
                    "valor": valor,
                    "quantidade_estoque": quantidade_estoque
                },
                success: function(data) {
                    alert(data.status);
                    location.reload();
                }
            });
        });


    </script>
@endsection



