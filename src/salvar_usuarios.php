<?php

require 'config.php';
require 'auth.php';

$id = $_POST['id'] ?? null;

$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];

if ($id) {

    if ($senha !== '') {

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            'UPDATE usuarios
             SET nome = ?, email = ?, senha = ?
             WHERE id = ?'
        );

        $stmt->bind_param(
            'sssi',
            $nome,
            $email,
            $senha_hash,
            $id
        );

    } else {

        $stmt = $conn->prepare(
            'UPDATE usuarios
             SET nome = ?, email = ?
             WHERE id = ?'
        );

        $stmt->bind_param(
            'ssi',
            $nome,
            $email,
            $id
        );
    }

} else {

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        'INSERT INTO usuarios (nome, email, senha)
         VALUES (?, ?, ?)'
    );

    $stmt->bind_param(
        'sss',
        $nome,
        $email,
        $senha_hash
    );
}

$stmt->execute();

header('Location: usuarios.php');
exit;