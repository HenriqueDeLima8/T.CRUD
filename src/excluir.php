<?php

require 'config.php';
require 'auth.php';

$id = $_GET['id'];
$tipo = $_GET['tipo'];

if ($tipo === 'emprestimo') {

    $stmt = $conn->prepare(
        'DELETE FROM emprestimos WHERE id = ?'
    );

    $stmt->bind_param('i', $id);

    $stmt->execute();

    header('Location: emprestimos.php');
    exit;
}

if ($tipo === 'usuario') {

    $stmt = $conn->prepare(
        'DELETE FROM usuarios WHERE id = ?'
    );

    $stmt->bind_param('i', $id);
    $stmt->execute();

    header('Location: usuarios.php');
    exit;
}

if ($tipo === 'categoria') {

    $stmt = $conn->prepare(
        'DELETE FROM categorias WHERE id = ?'
    );

    $stmt->bind_param('i', $id);

    $stmt->execute();

    header('Location: categorias.php');
    exit;
}

header('Location: index.php');
exit;