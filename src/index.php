<?php

require 'config.php';
require 'auth.php';
require 'header.php';

?>

<main class="sge-main">

    <section class="sge-hero mb-4">
        <h2>Bem-vindo ao SGE</h2>

        <p class="mb-0">
            Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! Gerencie os empréstimos e categorias do sistema com
            praticidade.
        </p>
    </section>

    <div class="row g-3">
        <div class="col-12 col-md-6">
            <a class="sge-action" href="emprestimos.php">
                <strong>Gerenciar Empréstimos</strong>
                <span>Cadastre, edite e acompanhe os itens emprestados.</span>
            </a>
        </div>

        <div class="col-12 col-md-6">
            <a class="sge-action" href="categorias.php">
                <strong>Gerenciar Categorias</strong>
                <span>Organize os tipos de produtos do seu inventário.</span>
            </a>
        </div>
    </div>

</main>

<?php require 'footer.php'; ?>