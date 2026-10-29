
<?php

class AdminModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Conta todos os livros cadastrados.
     */
    public function contarLivros(): int
    {
        $sql = 'SELECT COUNT(*) FROM livros';

        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    /**
     * Conta os livros disponíveis para empréstimo.
     */
    public function contarLivrosDisponiveis(): int
    {
        $sql = "SELECT COUNT(*) FROM livros
                WHERE status = 'DISPONIVEL'";

        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    /**
     * Conta os empréstimos que estão ativos.
     */
    public function contarEmprestimosAtivos(): int
    {
        $sql = "SELECT COUNT(*) FROM emprestimos
                WHERE status = 'ATIVO'";

        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    /**
     * Conta os usuários cadastrados.
     */
    public function contarUsuarios(): int
    {
        $sql = 'SELECT COUNT(*) FROM usuarios';

        return (int) $this->pdo->query($sql)->fetchColumn();
    }
}
