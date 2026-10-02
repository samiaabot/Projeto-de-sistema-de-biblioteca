<?php

/**
 * CONEXÃO COM O BANCO
 *
 * Este arquivo só abre o PDO e garante que a tabela exista.
 * Quem executa SELECT e INSERT é o Model, não este arquivo.
 *
 * SQLite grava tudo num arquivo. Por isso o projeto abre no
 * XAMPP sem instalar o MySQL. O arquivo surge em data/banco.sqlite
 * na primeira visita à página.
 */

$pastaDados = __DIR__ . '/../data';

if (!is_dir($pastaDados)) {
    mkdir($pastaDados, 0777, true);
}

$caminhoSqlite = $pastaDados . '/banco.sqlite';

// DSN = "endereço" que o PDO usa para achar o banco.
$dsn = 'sqlite:' . $caminhoSqlite;
$usuario = null;
$senha = null;

/*
 * COMO TROCAR PARA MYSQL (XAMPP + phpMyAdmin)
 * --------------------------------------------
 * 1. Crie um banco chamado mini_mvc no phpMyAdmin.
 * 2. Comente $dsn, $usuario e $senha acima.
 * 3. Descomente o bloco abaixo.
 * 4. Troque também o CREATE TABLE do final deste arquivo
 *    pela versão MySQL que está no comentário.
 *
 * $dsn = 'mysql:host=localhost;dbname=mini_mvc;charset=utf8mb4';
 * $usuario = 'root';
 * $senha = '';
 */

try {
    $pdo = new PDO($dsn, $usuario, $senha);

    // Erros de SQL viram exceção, em vez de falhar em silêncio.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // fetch e fetchAll devolvem array associativo: $linha['titulo'].
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit('Não foi possível conectar ao banco. ' . $e->getMessage());
}

// Roda em toda visita. IF NOT EXISTS evita erro se a tabela já existe.
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS livros (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        descricao TEXT NOT NULL
    )'
);

/*
 * Versão da mesma tabela no MySQL:
 *
 * CREATE TABLE IF NOT EXISTS tarefas (
 *     id INT AUTO_INCREMENT PRIMARY KEY,
 *     titulo VARCHAR(120) NOT NULL,
 *     descricao TEXT NOT NULL
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */
