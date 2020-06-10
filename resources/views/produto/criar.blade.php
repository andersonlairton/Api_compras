@extends('base')

@section('title', 'Criar novo produto')

@section('content')

    <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <label>Descricao: </label>
                <input type="text" class="form-control" id="descricao" name="descricao">
            </div>

            <div class="col-md-12 col-sm-12">
                <label>Valor: </label>
                <input type="text" class="form-control" id="valor" name="valor">
            </div>

            <div class="col-md-12 col-sm-12">
                <label>Qtd. Estoque: </label>
                <input type="text" class="form-control" id="quantidade_estoque" name="quantidade_estoque">
            </div>

            <div class="col-md-12 col-sm-12">
                <button class="btn btn-success" id="btn_cadastrar">CADASTRAR</button>
            </div>
        </div>
    </div>
    </body>

    <script>
        $(document).on('click', '#btn_cadastrar', function() {
            let descricao = $('#descricao').val();
            let valor = $('#valor').val();
            let quantidade_estoque = $('#quantidade_estoque').val();

            $.ajax({
                url: '{{ url('/api/cadastrarproduto') }}',
                type: 'POST',
                data: {
                    "descricao": descricao,
                    "valor": valor,
                    "quantidade_estoque": quantidade_estoque
                },
                success: function(data) {
                    alert(data.status);
                }
            });
        });
    </script>
@endsection



