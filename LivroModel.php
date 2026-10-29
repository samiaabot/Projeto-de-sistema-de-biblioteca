
<?php

class LivroModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Lista todos os livros.
     */
    public function listar(): array
    {
        $sql = 'SELECT
                    idLivro AS id,
                    titulo,
                    autor,
                    categoria,
                    status,
                    localizacao
                FROM livros
                ORDER BY idLivro DESC';

        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * Insere um livro.
     */
    public function inserir(
        string $titulo,
        string $autor,
        string $categoria,
        string $status,
        string $localizacao
    ): void {
        $sql = 'INSERT INTO livros
                    (titulo, autor, categoria, status, localizacao)
                VALUES
                    (:titulo, :autor, :categoria, :status, :localizacao)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':autor' => $autor,
            ':categoria' => $categoria,
            ':status' => $status,
            ':localizacao' => $localizacao
        ]);
    }

    /**
     * Pesquisa por título, autor ou categoria.
     */
    public function buscarPorFiltro(string $termo): array
    {
        $sql = 'SELECT
                    idLivro AS id,
                    titulo,
                    autor,
                    categoria,
                    status,
                    localizacao
                FROM livros
                WHERE titulo LIKE :titulo
                   OR autor LIKE :autor
                   OR categoria LIKE :categoria
                ORDER BY idLivro DESC';

        $termoBusca = '%' . $termo . '%';
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':titulo' => $termoBusca,
            ':autor' => $termoBusca,
            ':categoria' => $termoBusca
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Consulta disponibilidade, localização e categoria.
     */
    public function verificarDisponibilidade(int $idLivro): array|false
    {
        $sql = 'SELECT status, localizacao, categoria
                FROM livros
                WHERE idLivro = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idLivro]);

        return $stmt->fetch();
    }

    /**
     * Busca um livro específico para edição.
     */
    public function buscarPorId(int $idLivro): array|false
    {
        $stmt = $this->pdo->prepare(
            'SELECT idLivro AS id, titulo, autor, categoria, status, localizacao
             FROM livros
             WHERE idLivro = :id'
        );

        $stmt->execute([':id' => $idLivro]);

        return $stmt->fetch();
    }

    /**
     * Atualiza os dados de um livro.
     */
    public function atualizar(
        int $idLivro,
        string $titulo,
        string $autor,
        string $categoria,
        string $status,
        string $localizacao
    ): void {
        $sql = 'UPDATE livros
                SET titulo = :titulo,
                    autor = :autor,
                    categoria = :categoria,
                    status = :status,
                    localizacao = :localizacao
                WHERE idLivro = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $idLivro,
            ':titulo' => $titulo,
            ':autor' => $autor,
            ':categoria' => $categoria,
            ':status' => $status,
            ':localizacao' => $localizacao
        ]);
    }

    /**
     * Exclui um livro somente se não tiver empréstimos associados.
     */
    public function excluir(int $idLivro): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM emprestimos WHERE idLivro = :id'
        );
        $stmt->execute([':id' => $idLivro]);

        if ((int) $stmt->fetchColumn() > 0) {
            return false;
        }

        $stmt = $this->pdo->prepare(
            'DELETE FROM livros WHERE idLivro = :id'
        );
        $stmt->execute([':id' => $idLivro]);

        return $stmt->rowCount() > 0;
    }
}
