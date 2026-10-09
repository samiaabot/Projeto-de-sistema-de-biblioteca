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
    'CREATE TABLE IF NOT EXISTS usuarios (
        idUsuario INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL,
        telefone TEXT NOT NULL
    );

    CREATE TABLE IF NOT EXISTS livros (
        idLivro INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        autor TEXT NOT NULL,
        categoria TEXT NOT NULL,
        status TEXT DEFAULT "DISPONIVEL",
        localizacao TEXT NOT NULL
    );

    CREATE TABLE IF NOT EXISTS emprestimos (
        idEmprestimo INTEGER PRIMARY KEY AUTOINCREMENT,
        idUsuario INTEGER NOT NULL,
        idLivro INTEGER NOT NULL,
        dataEmprestimo TEXT NOT NULL,
        dataDevolucao TEXT NOT NULL,
        dataDevolucaoReal TEXT,
        status TEXT DEFAULT "ATIVO",
        FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario),
        FOREIGN KEY (idLivro) REFERENCES livros(idLivro)
    );'
);

/*
 * Versão da mesma tabela no MySQL:
 *
 * CREATE TABLE IF NOT EXISTS usuarios (
 *     idUsuario INT AUTO_INCREMENT PRIMARY KEY,
 *     nome VARCHAR(120) NOT NULL,
 *     email VARCHAR(120) NOT NULL,
 *     telefone VARCHAR(30) NOT NULL
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 *
 * CREATE TABLE IF NOT EXISTS livros (
 *     idLivro INT AUTO_INCREMENT PRIMARY KEY,
 *     titulo VARCHAR(150) NOT NULL,
 *     autor VARCHAR(120) NOT NULL,
 *     categoria VARCHAR(80) NOT NULL,
 *     status VARCHAR(30) DEFAULT 'DISPONIVEL',
 *     localizacao VARCHAR(50) NOT NULL
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 *
 * CREATE TABLE IF NOT EXISTS emprestimos (
 *     idEmprestimo INT AUTO_INCREMENT PRIMARY KEY,
 *     idUsuario INT NOT NULL,
 *     idLivro INT NOT NULL,
 *     dataEmprestimo DATE NOT NULL,
 *     dataDevolucao DATE NOT NULL,
 *     dataDevolucaoReal DATE,
 *     status VARCHAR(30) DEFAULT 'ATIVO',
 *     FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario),
 *     FOREIGN KEY (idLivro) REFERENCES livros(idLivro)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */
