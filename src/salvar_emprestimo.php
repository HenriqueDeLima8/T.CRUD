<?php

require 'config.php';
require 'auth.php';

$id = $_POST['id'] ?? null;

$nome_produto = trim($_POST['nome_produto']);
$descricao = trim($_POST['descricao']);
$categoria_id = $_POST['categoria_id'];
$numero_serie = trim($_POST['numero_serie']);
$situacao = $_POST['situacao'];

if ($id) {

    $stmt = $conn->prepare(
        'UPDATE emprestimos
         SET
            nome_produto = ?,
            descricao = ?,
            categoria_id = ?,
            numero_serie = ?,
            situacao = ?
         WHERE id = ?'
    );

    $stmt->bind_param(
        'ssissi',
        $nome_produto,
        $descricao,
        $categoria_id,
        $numero_serie,
        $situacao,
        $id
    );

} else {

    $stmt = $conn->prepare(
        'INSERT INTO emprestimos
        (
            nome_produto,
            descricao,
            categoria_id,
            numero_serie,
            situacao
        )
        VALUES (?, ?, ?, ?, ?)'
    );

    $stmt->bind_param(
        'ssiss',
        $nome_produto,
        $descricao,
        $categoria_id,
        $numero_serie,
        $situacao
    );
}

$stmt->execute();

header('Location: emprestimos.php');
exit;