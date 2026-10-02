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
        $sql = 'SELECT id, titulo, descricao FROM livros ORDER BY id DESC';

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
    public function inserir($titulo, $descricao)
    {
        $sql = 'INSERT INTO livros (titulo, descricao) VALUES (:titulo, :descricao)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
        ]);
    }
}
