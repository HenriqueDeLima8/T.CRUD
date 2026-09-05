<?php

require 'config.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare(
        'SELECT id, nome, senha FROM usuarios WHERE email = ?'
    );

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($senha, $usuario['senha'])) {

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        header('Location: index.php');
        exit;

    } else {
        $erro = 'E-mail ou senha inválidos.';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="sge-login">

    <main class="sge-login-card">
        <h1 class="mb-2">SGE</h1>

        <h2 class="h4 mb-4">Acesso ao sistema</h2>

        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <label class="form-label" for="email">E-mail</label>
            <input class="form-control mb-3" type="email" id="email" name="email" required>

            <label class="form-label" for="senha">Senha</label>
            <input class="form-control mb-4" type="password" id="senha" name="senha" required>

            <br><br>

            <button class="btn btn-sge w-100" type="submit">Entrar</button>

        </form>
    </main>

</body>

</html>