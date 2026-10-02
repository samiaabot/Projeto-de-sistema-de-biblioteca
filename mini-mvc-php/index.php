<?php

/**
 * PONTO DE ENTRADA
 *
 * No XAMPP, o Apache abre este arquivo quando o aluno acessa
 * http://localhost/mini-mvc-php/
 *
 * Aqui não há HTML nem SQL. Este arquivo só junta as peças e
 * entrega a requisição ao Controller.
 *
 * Ordem: conexão -> Model -> Controller.
 */

require __DIR__ . '/config/database.php';
require __DIR__ . '/models/LivroModel.php';
require __DIR__ . '/controllers/LivroController.php';

// $pdo nasceu em config/database.php e segue disponível neste arquivo.
$controller = new LivroController($pdo);
$controller->tratarRequisicao();
