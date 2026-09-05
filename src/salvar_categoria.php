<?php

require 'config.php';
require 'auth.php';

$id = $_POST['id'] ?? null;
$categoria = trim($_POST['categoria']);

if ($id) {

    $stmt = $conn->prepare(
        'UPDATE categorias SET categoria = ? WHERE id = ?'
    );

    $stmt->bind_param('si', $categoria, $id);

} else {

    $stmt = $conn->prepare(
        'INSERT INTO categorias (categoria) VALUES (?)'
    );

    $stmt->bind_param('s', $categoria);
}

$stmt->execute();

header('Location: categorias.php');
exit;