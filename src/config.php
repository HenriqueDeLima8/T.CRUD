<?php

$config = [
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS')
];

$conn = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database']
);

if ($conn->connect_error) {
    die('Erro na conexão com o banco de dados.');
}

$conn->set_charset('utf8mb4');
header('Content-Type: text/html; charset=UTF-8');

session_start();