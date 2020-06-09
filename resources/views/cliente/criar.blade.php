@extends('base')

@section('title', 'Criar novo cliente')

@section('content')

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <label>Nome: </label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>

                <div class="col-md-12 col-sm-12">
                    <label>CPF/CNPJ: </label>
                    <input type="text" class="form-control cpfOuCnpj" id="cpf_cnpj" name="cpf_cnpj">
                </div>

                <div class="col-md-12 col-sm-12">
                    <button class="btn btn-success" id="btn_cadastrar">CADASTRAR</button>
                </div>
            </div>
        </div>
    </body>

    <script>
        $(document).on('click', '#btn_cadastrar', function() {
            let nome = $('#nome').val();
            let cpf_cnpj = $('#cpf_cnpj').val();

            $.ajax({
                url: '{{ url('/api/cadastrarCliente') }}',
                type: 'POST',
                data: {
                    "nome": nome,
                    "cpf_cnpj": cpf_cnpj
                },
                success: function(data) {
                    alert(data.status);
                }
            });
        });
    </script>
@endsection



