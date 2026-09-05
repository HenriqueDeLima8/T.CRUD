CREATE DATABASE IF NOT EXISTS sge CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_unicode_ci;

USE sge;

SET
    NAMES utf8mb4;

CREATE TABLE
    usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL
    );

CREATE TABLE
    categorias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        categoria VARCHAR(100) NOT NULL
    );

CREATE TABLE
    emprestimos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_produto VARCHAR(100) NOT NULL,
        descricao TEXT,
        categoria_id INT NOT NULL,
        numero_serie VARCHAR(100) NOT NULL,
        situacao ENUM ('disponível', 'emprestado', 'em manutenção') NOT NULL DEFAULT 'disponível',
        FOREIGN KEY (categoria_id) REFERENCES categorias (id)
    );

-- Dados
-- Senha: 123456
INSERT INTO
    usuarios (nome, email, senha)
VALUES
    (
        'Administrador',
        'admin@email.com',
        '$2y$10$FOi2dg8gVH5xFpCeQ21aee1h84WURiMlSw1lqs91nLV/Q1rxxV8q.'
    );

INSERT INTO
    categorias (categoria)
VALUES
    ('Notebook'),
    ('Data Show'),
    ('Projetor'),
    ('Câmera');

INSERT INTO
    emprestimos (
        nome_produto,
        descricao,
        categoria_id,
        numero_serie,
        situacao
    )
VALUES
    (
        'Notebook Dell',
        'Notebook para uso acadêmico',
        1,
        'NB001',
        'disponível'
    ),
    (
        'Projetor Epson',
        'Projetor multimídia',
        3,
        'PJ001',
        'emprestado'
    );