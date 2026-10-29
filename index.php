
<?php

require __DIR__ . '/config/database.php';

$pagina = $_GET['pagina'] ?? 'catalogo';

if ($pagina === 'admin') {
    require_once __DIR__ . '/controllers/AdminController.php';

    $controller = new AdminController($pdo);
    $controller->index();
    exit;
}

require_once __DIR__ . '/models/LivroModel.php';
require_once __DIR__ . '/controllers/LivroController.php';

$controller = new LivroController($pdo);
$controller->tratarRequisicao();
