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
        $autor = '';
        $categoria = '';
        $status = 'DISPONIVEL';
        $localizacao = '';
        $busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

        // POST = o aluno enviou o formulário. GET = só abriu ou atualizou a página.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
            $autor = isset($_POST['autor']) ? trim($_POST['autor']) : '';
            $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
            $status = isset($_POST['status']) ? trim($_POST['status']) : 'DISPONIVEL';
            $localizacao = isset($_POST['localizacao']) ? trim($_POST['localizacao']) : '';

            if ($titulo === '' || $autor === '' || $categoria === '' || $localizacao === '') {
                $erro = 'Preencha todos os campos do livro.';
            } elseif (strlen($titulo) > 120) {
                $erro = 'O título pode ter no máximo 120 caracteres.';
            } else {
                try {
                    // O Controller entrega os dados. O Model monta o INSERT.
                    $this->model->inserir($titulo, $autor, $categoria, $status, $localizacao);

                    /*
                     * Post-Redirect-Get: depois de gravar, o navegador é
                     * mandado de volta para o GET. Assim, atualizar a página
                     * (F5) não reenvia o formulário nem duplica o cadastro.
                     * exit impede que o PHP continue e imprima HTML depois
                     * do redirecionamento.
                     */
                    header('Location: index.php?sucesso=1');
                    exit;
                } catch (PDOException $e) {
                    $erro = 'Não foi possível salvar o livro. ' . $e->getMessage();
                }
            }
        }

        if (isset($_GET['sucesso']) && $_GET['sucesso'] === '1') {
            $sucesso = 'Livro cadastrado com sucesso.';
        }

        // se houver algum filtro de busca, filtra. caso não houver, mostra todos os livros
        if ($busca !== '') {
            $livros = $this->model->buscarPorFiltro($busca);
        } else {
            $livros = $this->model->listar();
        }

        /*
         * O require está dentro do método. Por isso a View enxerga
         * $livros, $erro, $sucesso, $titulo, $autor, $categoria, $status, $localizacao e $busca.
         */
        require __DIR__ . '/../views/livros_view.php';
    }
}
