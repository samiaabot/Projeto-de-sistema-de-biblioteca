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
     * lê todos os livros
     * prepare + execute + fetchAll é o mesmo trio usado no INSERT
     */
    public function listar()
    {
        $sql = 'SELECT idLivro AS id, titulo, autor, categoria, status, localizacao FROM livros ORDER BY idLivro DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Grava um livro.
     *
     * Os marcadores são trocados pelos valores correspondentes pelo PDO, já escapados.
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

    /**
     * pesquisa livros por título, autor ou categoria
     */
    public function buscarPorFiltro($termo)
    {
        $sql = 'SELECT idLivro AS id, titulo, autor, categoria, status, localizacao FROM livros WHERE titulo LIKE :termo OR autor LIKE :termo OR categoria LIKE :termo ORDER BY idLivro DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':termo' => '%' . $termo . '%']);

        return $stmt->fetchAll();
    }

    /**
     * verifica disponbilidade e dados de um livro especifico
     */
    public function verificarDisponibilidade($idLivro)
    {
        $sql = 'SELECT status, localizacao, categoria FROM livros WHERE idLivro = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idLivro]);

        return $stmt->fetch();
    }
}

        return $stmt->fetch();
    }
}
