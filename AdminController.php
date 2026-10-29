
<?php

require_once __DIR__ . '/../models/AdminModel.php';

class AdminController
{
    private AdminModel $adminModel;

    public function __construct(PDO $pdo)
    {
        $this->adminModel = new AdminModel($pdo);
    }

    public function index(): void
    {
        $totalLivros = $this->adminModel->contarLivros();
        $livrosDisponiveis = $this->adminModel->contarLivrosDisponiveis();
        $emprestimosAtivos = $this->adminModel->contarEmprestimosAtivos();
        $totalUsuarios = $this->adminModel->contarUsuarios();

        require __DIR__ . '/../views/admin_view.php';
    }
}
