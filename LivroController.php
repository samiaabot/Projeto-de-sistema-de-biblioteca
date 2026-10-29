
<?php

class LivroController
{
    private LivroModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new LivroModel($pdo);
    }

    public function tratarRequisicao(): void
    {
        $erro = '';
        $sucesso = '';

        $titulo = '';
        $autor = '';
        $categoria = '';
        $status = 'DISPONIVEL';
        $localizacao = '';

        $busca = trim($_GET['busca'] ?? '');
        $acao = $_GET['acao'] ?? '';
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Processa ações enviadas por formulário.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $acaoPost = $_POST['acao'] ?? '';

            // Exclusão por POST, evitando excluir através de um simples link.
            if ($acaoPost === 'excluir') {
                $idPost = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

                if (!$idPost || $idPost < 1) {
                    header('Location: index.php?erro=livro_invalido');
                    exit;
                }

                try {
                    $excluido = $this->model->excluir($idPost);

                    header(
                        'Location: index.php?' .
                        ($excluido ? 'sucesso=excluido' : 'erro=nao_excluido')
                    );
                    exit;
                } catch (PDOException $e) {
                    header('Location: index.php?erro=nao_excluido');
                    exit;
                }
            }

            $titulo = trim($_POST['titulo'] ?? '');
            $autor = trim($_POST['autor'] ?? '');
            $categoria = trim($_POST['categoria'] ?? '');
            $status = trim($_POST['status'] ?? 'DISPONIVEL');
            $localizacao = trim($_POST['localizacao'] ?? '');

            $idPost = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            $statusPermitidos = ['DISPONIVEL', 'EMPRESTADO'];

            if (
                $titulo === '' ||
                $autor === '' ||
                $categoria === '' ||
                $localizacao === ''
            ) {
                $erro = 'Preencha todos os campos do livro.';
            } elseif (strlen($titulo) > 120) {
                $erro = 'O título pode ter no máximo 120 caracteres.';
            } elseif (!in_array($status, $statusPermitidos, true)) {
                $erro = 'Selecione um status válido.';
            } else {
                try {
                    if ($acaoPost === 'editar') {
                        if (!$idPost || $idPost < 1) {
                            $erro = 'O livro selecionado é inválido.';
                        } elseif (!$this->model->buscarPorId($idPost)) {
                            $erro = 'O livro que pretende editar não existe.';
                        } else {
                            $this->model->atualizar(
                                $idPost,
                                $titulo,
                                $autor,
                                $categoria,
                                $status,
                                $localizacao
                            );

                            header('Location: index.php?sucesso=editado');
                            exit;
                        }
                    } else {
                        $this->model->inserir(
                            $titulo,
                            $autor,
                            $categoria,
                            $status,
                            $localizacao
                        );

                        header('Location: index.php?sucesso=1');
                        exit;
                    }
                } catch (PDOException $e) {
                    $erro = 'Não foi possível guardar as alterações.';
                }
            }
        }

        // Mensagens de resultado.
        if (isset($_GET['sucesso'])) {
            $mensagens = [
                '1' => 'Livro cadastrado com sucesso.',
                'editado' => 'Livro atualizado com sucesso.',
                'excluido' => 'Livro excluído com sucesso.'
            ];

            $sucesso = $mensagens[$_GET['sucesso']] ?? '';
        }

        if (isset($_GET['erro'])) {
            if ($_GET['erro'] === 'nao_excluido') {
                $erro = 'Não foi possível excluir o livro. Ele pode ter empréstimos associados.';
            } elseif ($_GET['erro'] === 'livro_invalido') {
                $erro = 'O livro selecionado é inválido.';
            }
        }

        // Carrega os dados do livro quando a ação é editar.
        $livroEdicao = null;

        if ($acao === 'editar') {
            if (!$id || $id < 1) {
                $erro = 'Selecione um livro válido para editar.';
            } else {
                $livroEdicao = $this->model->buscarPorId($id);

                if (!$livroEdicao) {
                    $erro = 'Livro não encontrado.';
                } else {
                    $titulo = $livroEdicao['titulo'];
                    $autor = $livroEdicao['autor'];
                    $categoria = $livroEdicao['categoria'];
                    $status = $livroEdicao['status'];
                    $localizacao = $livroEdicao['localizacao'];
                }
            }
        }

        // Lista os livros conforme a pesquisa.
        $livros = $busca !== ''
            ? $this->model->buscarPorFiltro($busca)
            : $this->model->listar();

        require __DIR__ . '/../views/livros_view.php';
    }
}
