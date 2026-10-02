<?php

/**
 * CONTROLLER
 *
 * Recebe a requisição HTTP, valida o que o formulário enviou,
 * pede ao Model para gravar ou listar, e escolhe a resposta:
 * redirecionar (POST com sucesso) ou carregar a View.
 *
 * Não escreve SQL e não monta o HTML da página.
 */
class LivroController
{
    private $model; 

    public function __construct(PDO $pdo)
    {
        $this->model = new LivroModel($pdo);
    }

    public function tratarRequisicao()
    {
        $erro = '';
        $sucesso = '';
        $titulo = '';
        $descricao = '';

        // POST = o aluno enviou o formulário. GET = só abriu ou atualizou a página.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // name="titulo" no HTML chega aqui como $_POST['titulo'].
            $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
            // name="descricao" no HTML chega aqui como $_POST['descricao'].
            $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

            if ($titulo === '' || $descricao === '') {
                $erro = 'Preencha o título e a avaliação.';
            } elseif (strlen($titulo) > 120) {
                $erro = 'O título pode ter no máximo 120 caracteres.';
            } elseif (strlen($descricao) > 500) {
                $erro = 'A avaliação pode ter no máximo 500 caracteres.';
            } else {
                try {
                    // O Controller entrega os textos. O Model monta o INSERT.
                    $this->model->inserir($titulo, $descricao);

                    /*
                     * Post-Redirect-Get: depois de gravar, o navegador é
                     * mandado de volta para o GET. Assim, atualizar a página
                     * (F5) não reenvia o formulário nem duplica a tarefa.
                     * exit impede que o PHP continue e imprima HTML depois
                     * do redirecionamento.
                     */
                    header('Location: index.php?sucesso=1');
                    exit;
                } catch (PDOException $e) {
                    $erro = 'Não foi possível salvar a avaliação. ' . $e->getMessage();
                }
            }
        }

        if (isset($_GET['sucesso']) && $_GET['sucesso'] === '1') {
            $sucesso = 'Avaliação cadastrada.';
        }

        $tarefas = $this->model->listar();

        /*
         * O require está dentro do método. Por isso a View enxerga
         * $tarefas, $erro, $sucesso, $titulo e $descricao.
         */
        require __DIR__ . '/../views/livros_view.php';
    }
}
