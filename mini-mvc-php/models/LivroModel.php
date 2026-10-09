<?php

/**
 * MODEL
 *
 * Fala apenas com o banco. Não conhece HTML, formulário nem $_POST.
 * Os valores chegam prontos, por parâmetro, vindos do Controller.
 */
class LivroModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        // A conexão é criada uma vez em config/database.php e reaproveitada aqui.
        $this->pdo = $pdo;
    }

    /**
     * Lê todas as tarefas.
     * prepare + execute + fetchAll é o mesmo trio usado no INSERT.
     */
    public function listar()
    {
        $sql = 'SELECT idLivro AS id, titulo, autor, categoria, status, localizacao FROM livros ORDER BY idLivro DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Grava uma tarefa.
     *
     * :titulo e :descricao são marcadores. O PDO troca cada um pelo
     * valor correspondente, já escapado para o SQL.
     *
     * A cadeia do dado é:
     *   <input name="titulo">  ->  $_POST['titulo']  ->  :titulo
     *   <textarea name="descricao">  ->  $_POST['descricao']  ->  :descricao
     */
    public function inserir($titulo, $autor, $categoria, $status, $localizacao)
    {
        $sql = 'INSERT INTO livros (titulo, autor, categoria, status, localizacao) VALUES (:titulo, :autor, :categoria, :status, :localizacao)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':autor' => $autor,
            ':categoria' => $categoria,
            ':status' => $status,
            ':localizacao' => $localizacao,
        ]);
    }

    public function buscarPorFiltro($termo)
    {
        $sql = 'SELECT idLivro AS id, titulo, autor, categoria, status, localizacao FROM livros WHERE titulo LIKE :termo OR autor LIKE :termo OR categoria LIKE :termo ORDER BY idLivro DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':termo' => '%' . $termo . '%']);

        return $stmt->fetchAll();
    }

    public function verificarDisponibilidade($idLivro)
    {
        $sql = 'SELECT status, localizacao, categoria FROM livros WHERE idLivro = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idLivro]);

        return $stmt->fetch();
    }
}
