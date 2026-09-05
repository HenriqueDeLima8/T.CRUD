<?php

require 'config.php';
require 'auth.php';

$id = $_GET['id'] ?? null;

$emprestimo_edicao = null;

if ($id) {

    $stmt = $conn->prepare(
        'SELECT * FROM emprestimos WHERE id = ?'
    );

    $stmt->bind_param('i', $id);
    $stmt->execute();

    $emprestimo_edicao = $stmt
        ->get_result()
        ->fetch_assoc();
}

$categorias = $conn->query(
    'SELECT id, categoria FROM categorias ORDER BY categoria'
);

$emprestimos = $conn->query(
    'SELECT
        e.id,
        e.nome_produto,
        e.descricao,
        e.numero_serie,
        e.situacao,
        c.categoria
     FROM emprestimos e
     INNER JOIN categorias c
        ON e.categoria_id = c.id
     ORDER BY e.nome_produto'
);

require 'header.php';

?>

<main class="sge-main">

    <h2 class="mb-4">
        <?= $emprestimo_edicao
            ? 'Editar Empréstimo'
            : 'Novo Empréstimo'
            ?>
    </h2>

    <form class="sge-panel sge-form mb-5" action="salvar_emprestimo.php" method="POST">

        <?php if ($emprestimo_edicao): ?>

            <input type="hidden" name="id" value="<?= $emprestimo_edicao['id'] ?>">

        <?php endif; ?>


        <label class="form-label" for="nome_produto">
            Nome do produto
        </label>

        <input class="form-control" type="text" id="nome_produto" name="nome_produto"
            value="<?= htmlspecialchars($emprestimo_edicao['nome_produto'] ?? '') ?>" required>

        <div class="mb-3"></div>

        <label class="form-label" for="descricao">
            Descrição
        </label>

        <textarea class="form-control" id="descricao" name="descricao" rows="5" cols="40"
            required><?= htmlspecialchars($emprestimo_edicao['descricao'] ?? '') ?></textarea>

        <div class="mb-3"></div>

        <label class="form-label" for="categoria_id">
            Categoria
        </label>

        <select class="form-select" id="categoria_id" name="categoria_id" required>

            <option value="">
                Selecione uma categoria
            </option>

            <?php while ($categoria = $categorias->fetch_assoc()): ?>

                <option value="<?= $categoria['id'] ?>" <?= (
                      isset($emprestimo_edicao['categoria_id']) &&
                      $emprestimo_edicao['categoria_id'] == $categoria['id']
                  ) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria['categoria']) ?>
                </option>

            <?php endwhile; ?>

        </select>

        <div class="mb-3"></div>

        <label class="form-label" for="numero_serie">
            Número de Série ou Patrimônio
        </label>

        <input class="form-control" type="text" id="numero_serie" name="numero_serie"
            value="<?= htmlspecialchars($emprestimo_edicao['numero_serie'] ?? '') ?>" required>

        <div class="mb-3"></div>

        <fieldset class="mb-3">

            <legend class="fs-6">Situação</legend>

            <label>
                <input type="radio" name="situacao" value="disponível" <?= (
                    ($emprestimo_edicao['situacao'] ?? 'disponível')
                    === 'disponível'
                ) ? 'checked' : '' ?> required>
                Disponível
            </label>

            <br>

            <label>
                <input type="radio" name="situacao" value="emprestado" <?= (
                    ($emprestimo_edicao['situacao'] ?? '')
                    === 'emprestado'
                ) ? 'checked' : '' ?>>
                Emprestado
            </label>

            <br>

            <label>
                <input type="radio" name="situacao" value="em manutenção" <?= (
                    ($emprestimo_edicao['situacao'] ?? '')
                    === 'em manutenção'
                ) ? 'checked' : '' ?>>
                Em manutenção
            </label>

        </fieldset>

        <button class="btn btn-sge" type="submit">
            Salvar
        </button>

    </form>


    <h2 class="mb-3">Empréstimos cadastrados</h2>

    <div class="table-responsive">
        <table class="table table-hover">

            <thead>

                <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Série/Patrimônio</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>

            </thead>

            <tbody>

                <?php while ($emprestimo = $emprestimos->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($emprestimo['nome_produto']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($emprestimo['descricao']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($emprestimo['categoria']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($emprestimo['numero_serie']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($emprestimo['situacao']) ?>
                        </td>

                        <td>

                            <a href="emprestimos.php?id=<?= $emprestimo['id'] ?>">
                                Editar
                            </a>

                            |

                            <a href="excluir.php?tipo=emprestimo&id=<?= $emprestimo['id'] ?>"
                                onclick="return confirm('Excluir este empréstimo?')">
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