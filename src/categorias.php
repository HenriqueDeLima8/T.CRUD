<?php

require 'config.php';
require 'auth.php';

$id = $_GET['id'] ?? null;

$categoria_edicao = null;

if ($id) {

    $stmt = $conn->prepare(
        'SELECT id, categoria FROM categorias WHERE id = ?'
    );

    $stmt->bind_param('i', $id);
    $stmt->execute();

    $categoria_edicao = $stmt
        ->get_result()
        ->fetch_assoc();
}

$categorias = $conn->query(
    'SELECT id, categoria FROM categorias ORDER BY categoria'
);

require 'header.php';

?>

<main class="sge-main">

    <h2 class="mb-4">
        <?= $categoria_edicao ? 'Editar Categoria' : 'Nova Categoria' ?>
    </h2>

    <form class="sge-panel sge-form mb-5" action="salvar_categoria.php" method="POST">

        <?php if ($categoria_edicao): ?>

            <input type="hidden" name="id" value="<?= $categoria_edicao['id'] ?>">

        <?php endif; ?>

        <label class="form-label" for="categoria">
            Categoria
        </label>

        <input class="form-control mb-3" type="text" id="categoria" name="categoria"
            value="<?= htmlspecialchars($categoria_edicao['categoria'] ?? '') ?>" required>

        <button class="btn btn-sge" type="submit">
            Salvar
        </button>

    </form>

    <h2 class="mb-3">Categorias cadastradas</h2>

    <div class="table-responsive">
        <table class="table table-hover">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($categoria = $categorias->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= $categoria['id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($categoria['categoria']) ?>
                        </td>

                        <td>

                            <a href="categorias.php?id=<?= $categoria['id'] ?>">
                                Editar
                            </a>

                            |

                            <a href="excluir.php?tipo=categoria&id=<?= $categoria['id'] ?>"
                                onclick="return confirm('Excluir esta categoria?')">
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