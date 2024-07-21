<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Inclua o Bootstrap ou outros estilos necessários -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <form id="formLogin">
                        <div class="mb-3">
                            <label for="emailLogin" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailLogin" name="emailLogin" required>
                        </div>
                        <div class="mb-3">
                            <label for="senhaLogin" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senhaLogin" name="senhaLogin" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </form>
                </div>
                <div class="card-footer">
                    <small>Não possui uma conta? <a href="cadastrousuario.php">Cadastre-se aqui</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclua o jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Inclua o JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Função para realizar login
        $('#formLogin').submit(function(event) {
            event.preventDefault();

            var email = $('#emailLogin').val();
            var senha = $('#senhaLogin').val();

            $.ajax({
                url: 'usuario/login.php', // Substitua pela sua URL de backend
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    email: email,
                    senha: senha
                }),
                success: function(response) {
                    console.log('Login realizado com sucesso:', response);
                    if (response && response.token) {
                        localStorage.setItem('token', response.token);
                        console.log('Token armazenado:', localStorage.getItem('token')); // Verificação do token armazenado
                        // Redirecionar para o dashboard após o login
                        window.location.href = 'dashboard.php'; // Exemplo de redirecionamento para uma página após o login
                    } else {
                        console.error('Token não encontrado na resposta:', response);
                        alert('Erro ao realizar login. Por favor, tente novamente.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao realizar login:', error);
                    alert('Credenciais inválidas. Por favor, tente novamente.');
                }
            });
        });
    });
</script>

</body>
</html>
