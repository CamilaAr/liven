<!-- cadastro.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Cadastro de Usuário
                </div>
                <div class="card-body">
                    <form id="formCadastro">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
                <div class="card-footer">
                    <small>Já possui uma conta? <a href="index.php">Faça login aqui</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Função para cadastrar usuário
        $('#formCadastro').submit(function(event) {
            event.preventDefault();

            var nome = $('#nome').val();
            var email = $('#email').val();
            var senha = $('#senha').val();

            $.ajax({
                url: 'usuario/cadastrarusuario.php', 
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    nome: nome,
                    email: email,
                    senha: senha
                }),
                success: function(response) {
                    console.log('Usuário cadastrado com sucesso:', response);
                    alert('Cadastro realizado com sucesso. Faça login para continuar.');
                    window.location.href = 'index.php'; // Redireciona para a tela de login após o cadastro
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao cadastrar usuário:', error);
                    alert('Erro ao cadastrar usuário. Por favor, tente novamente.');
                }
            });
        });
    });
</script>

</body>
</html>
