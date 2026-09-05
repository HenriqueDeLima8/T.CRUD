<?php

require 'config.php';
require 'auth.php';

$id = $_GET['id'] ?? null;

$usuario_edicao = null;

if ($id) {
    $stmt = $conn->prepare(
        'SELECT id, nome, email FROM usuarios WHERE id = ?'
    );

    $stmt->bind_param('i', $id);
    $stmt->execute();

    $usuario_edicao = $stmt->get_result()->fetch_assoc();
}

$usuarios = $conn->query(
    'SELECT id, nome, email FROM usuarios ORDER BY nome'
);

require 'header.php';

?>

<main class="sge-main">

    <h2 class="mb-4">
        <?= $usuario_edicao ? 'Editar Usuário' : 'Novo Usuário' ?>
    </h2>

    <form class="sge-panel sge-form mb-5" action="salvar_usuarios.php" method="POST">

        <?php if ($usuario_edicao): ?>

            <input type="hidden" name="id" value="<?= $usuario_edicao['id'] ?>">

        <?php endif; ?>

        <label class="form-label" for="nome">Nome</label>
        <input class="form-control mb-3" type="text" id="nome" name="nome"
            value="<?= htmlspecialchars($usuario_edicao['nome'] ?? '') ?>" required>

        <label class="form-label" for="email">E-mail</label>
        <input class="form-control mb-3" type="email" id="email" name="email"
            value="<?= htmlspecialchars($usuario_edicao['email'] ?? '') ?>" required>

        <label class="form-label" for="senha">Senha</label>
        <input class="form-control" type="password" id="senha" name="senha" <?= $usuario_edicao ? '' : 'required' ?>>

        <?php if ($usuario_edicao): ?>
            <small class="form-text d-block mb-3">
                Deixe em branco para manter a senha atual.
            </small>
        <?php endif; ?>

        <button class="btn btn-sge mt-3" type="submit">Salvar</button>

    </form>

    <h2 class="mb-3">Usuários cadastrados</h2>

    <div class="table-responsive">
        <table class="table table-hover">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($usuario = $usuarios->fetch_assoc()): ?>

                    <tr>
                        <td><?= $usuario['id'] ?></td>

                        <td>
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($usuario['email']) ?>
                        </td>

                        <td>
                            <a href="usuarios.php?id=<?= $usuario['id'] ?>">
                                Editar
                            </a>

                            |

                            <a href="excluir.php?tipo=usuario&id=<?= $usuario['id'] ?>"
                                onclick="return confirm('Excluir este usuário?')">
                                Excluir
                            </a>
                        </td>
                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>
    </div>

</main>

<?php require 'footer.php'; ?>