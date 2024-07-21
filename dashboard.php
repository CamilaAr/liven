<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Meus Dados
                </div>
                <div class="card-body">
                    <form id="formDados">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Dados</button>
                        <button type="button" class="btn btn-danger float-right" id="btnRemoverConta">Remover Conta</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Meus Endereços
                </div>
                <div class="card-body">
                    <form id="formEndereco">
                        <input type="hidden" id="enderecoId" name="enderecoId">
                        <div class="form-group">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                        </div>
                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento">
                        </div>
                        <div class="form-group">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro">
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" required>
                        </div>
                        <div class="form-group">
                            <label for="pais">País</label>
                            <input type="text" class="form-control" id="pais" name="pais" required>
                        </div>
                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnAdicionarEndereco">Adicionar Endereço</button>
                        <button type="submit" class="btn btn-primary" id="btnSalvarEndereco" style="display: none;">Salvar Endereço</button>
                    </form>
                    <ul class="list-group mt-3" id="listaEnderecos">
                        <!-- Endereços do usuário serão carregados aqui -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    function carregarDadosUsuario() {
        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage
        console.log('Token carregado:', token); // Verificação do token carregado

        if (!token) {
            alert('Token não encontrado. Por favor, faça login novamente.');
            window.location.href = 'index.php'; // Redireciona para a página de login se o token não for encontrado
            return;
        }

        $.ajax({
            url: 'usuario/obterusuario.php',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                console.log('Resposta recebida:', response); // Log da resposta recebida
                if (response.nome) {
                    $('#nome').val(response.nome);
                }
                if (response.email) {
                    $('#email').val(response.email);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar dados do usuário:', error);
                alert('Erro ao carregar dados do usuário. Por favor, tente novamente.');
            }
        });
    }

    function carregarEnderecosUsuario() {
        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage
        
        $.ajax({
            url: 'endereco/obterenderecos.php',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                console.log('Endereços recebidos:', response); // Log dos endereços recebidos
                $('#listaEnderecos').empty();
                response.forEach(function(endereco) {
                    $('#listaEnderecos').append(
                        '<li class="list-group-item">' +
                        endereco.logradouro + ', ' + endereco.numero + 
                        (endereco.complemento ? ', ' + endereco.complemento : '') + 
                        ', ' + (endereco.bairro ? endereco.bairro + ', ' : '') + 
                        endereco.cidade + ', ' + endereco.estado + 
                        ', ' + endereco.pais + ', ' + endereco.cep +
                        ' <button class="btn btn-sm btn-warning btnEditarEndereco" data-id="' + endereco.id + '">Editar</button>' +
                        ' <button class="btn btn-sm btn-danger btnRemoverEndereco" data-id="' + endereco.id + '">Remover</button>' +
                        '</li>'
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error('Erro ao carregar endereços do usuário:', error);
                alert('Erro ao carregar endereços do usuário. Por favor, tente novamente.');
            }
        });
    }

    function atualizarDadosUsuario(event) {
        event.preventDefault();

        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage
        const nome = $('#nome').val();

        $.ajax({
            url: 'usuario/atualizarusuario.php',
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: JSON.stringify({
                nome: nome
            }),
            success: function(response) {
                console.log('Resposta recebida:', response); // Log da resposta recebida
                alert('Dados atualizados com sucesso');
                carregarDadosUsuario(); // Recarrega os dados do usuário após a atualização
            },
            error: function(xhr, status, error) {
                console.error('Erro ao atualizar dados do usuário:', error);
                alert('Erro ao atualizar dados do usuário. Por favor, tente novamente.');
            }
        });
    }

    function cadastrarEndereco(event) {
        event.preventDefault();

        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage
        const logradouro = $('#logradouro').val();
        const numero = $('#numero').val();
        const complemento = $('#complemento').val();
        const bairro = $('#bairro').val();
        const cidade = $('#cidade').val();
        const estado = $('#estado').val();
        const pais = $('#pais').val();
        const cep = $('#cep').val();

        $.ajax({
            url: 'endereco/cadastrarendereco.php',
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: JSON.stringify({
                logradouro: logradouro,
                numero: numero,
                complemento: complemento,
                bairro: bairro,
                cidade: cidade,
                estado: estado,
                pais: pais,
                cep: cep
            }),
            success: function(response) {
                console.log('Endereço cadastrado:', response); // Log do endereço cadastrado
                alert('Endereço cadastrado com sucesso');
                carregarEnderecosUsuario(); // Recarrega os endereços do usuário após o cadastro
                $('#formEndereco')[0].reset(); // Limpa o formulário
            },
            error: function(xhr, status, error) {
                console.error('Erro ao cadastrar endereço:', error);
                alert('Erro ao cadastrar endereço. Por favor, tente novamente.');
            }
        });
    }

    function salvarEndereco(event) {
        event.preventDefault();

        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage
        const id = $('#enderecoId').val();
        const logradouro = $('#logradouro').val();
        const numero = $('#numero').val();
        const complemento = $('#complemento').val();
        const bairro = $('#bairro').val();
        const cidade = $('#cidade').val();
        const estado = $('#estado').val();
        const pais = $('#pais').val();
        const cep = $('#cep').val();

        $.ajax({
            url: 'endereco/atualizarendereco.php?id=' + id,
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: JSON.stringify({
                logradouro: logradouro,
                numero: numero,
                complemento: complemento,
                bairro: bairro,
                cidade: cidade,
                estado: estado,
                pais: pais,
                cep: cep
            }),
            success: function(response) {
                console.log('Endereço atualizado:', response); // Log do endereço atualizado
                alert('Endereço atualizado com sucesso');
                carregarEnderecosUsuario(); // Recarrega os endereços do usuário após a atualização
                $('#formEndereco')[0].reset(); // Limpa o formulário
                $('#btnAdicionarEndereco').show(); // Mostra o botão de adicionar
                $('#btnSalvarEndereco').hide(); // Esconde o botão de salvar
            },
            error: function(xhr, status, error) {
                console.error('Erro ao atualizar endereço:', error);
                alert('Erro ao atualizar endereço. Por favor, tente novamente.');
            }
        });
    }

    function removerConta() {
        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage

        if (!confirm('Tem certeza de que deseja remover sua conta?')) {
            return;
        }

        $.ajax({
            url: 'usuario/removerconta.php',
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                console.log('Conta removida:', response); // Log da resposta recebida
                alert('Conta removida com sucesso');
                localStorage.removeItem('token'); // Remove o token do localStorage
                window.location.href = 'index.php'; // Redireciona para a página de login
            },
            error: function(xhr, status, error) {
                console.error('Erro ao remover conta:', error);
                alert('Erro ao remover conta. Por favor, tente novamente.');
            }
        });
    }

    function editarEndereco(id) {
        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage

        $.ajax({
            url: 'endereco/obterendereco.php?id=' + id, // Passa o ID do endereço na URL
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                console.log('Endereço a ser editado:', response); // Log do endereço a ser editado
                $('#enderecoId').val(response.id);
                $('#logradouro').val(response.logradouro);
                $('#numero').val(response.numero);
                $('#complemento').val(response.complemento);
                $('#bairro').val(response.bairro);
                $('#cidade').val(response.cidade);
                $('#estado').val(response.estado);
                $('#pais').val(response.pais);
                $('#cep').val(response.cep);
                $('#btnAdicionarEndereco').hide(); // Esconde o botão de adicionar
                $('#btnSalvarEndereco').show(); // Mostra o botão de salvar
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter endereço para edição:', error);
                alert('Erro ao obter endereço para edição. Por favor, tente novamente.');
            }
        });
    }

    function removerEndereco(id) {
        const token = localStorage.getItem('token'); // Recupera o token JWT do localStorage

        if (!confirm('Tem certeza de que deseja remover este endereço?')) {
            return;
        }

        $.ajax({
            url: 'endereco/removerendereco.php',
            method: 'DELETE',
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: JSON.stringify({ id: id }),
            success: function(response) {
                console.log('Endereço removido:', response); // Log do endereço removido
                alert('Endereço removido com sucesso');
                carregarEnderecosUsuario(); // Recarrega os endereços do usuário após a remoção
            },
            error: function(xhr, status, error) {
                console.error('Erro ao remover endereço:', error);
                alert('Erro ao remover endereço. Por favor, tente novamente.');
            }
        });
    }

    $('#formDados').submit(atualizarDadosUsuario);
    $('#formEndereco').submit(function(event) {
        event.preventDefault();
        if ($('#enderecoId').val()) {
            salvarEndereco(event);
        } else {
            cadastrarEndereco(event);
        }
    });
    $('#btnRemoverConta').click(removerConta);
    $(document).on('click', '.btnEditarEndereco', function() {
        const id = $(this).data('id');
        editarEndereco(id);
    });
    $(document).on('click', '.btnRemoverEndereco', function() {
        const id = $(this).data('id');
        removerEndereco(id);
    });

    carregarDadosUsuario();
    carregarEnderecosUsuario();
});
</script>

</body>
</html>
