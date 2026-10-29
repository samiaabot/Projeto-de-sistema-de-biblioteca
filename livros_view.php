
<?php
require __DIR__ . '/layouts/header.php';

function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$editando = isset($livroEdicao) && is_array($livroEdicao);
?>

<style>
    .catalogo-pagina {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 0 48px;
    }

    .catalogo-intro {
        margin-bottom: 28px;
    }

    .catalogo-intro h1 {
        color: #493526;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        margin-bottom: 8px;
    }

    .catalogo-intro p {
        color: #78695b;
        line-height: 1.6;
    }

    .catalogo-mensagem {
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 10px;
        line-height: 1.5;
    }

    .catalogo-sucesso {
        background: #eaf4e8;
        color: #285b32;
    }

    .catalogo-erro {
        background: #fae9e5;
        color: #8c3025;
    }

    .catalogo-grade {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .livro-card {
        background: #fffdf8;
        border: 1px solid #e8ddcc;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 18px rgba(65, 43, 25, .05);
        min-width: 0;
    }

    .livro-card h3 {
        color: #493526;
        margin: 0 0 12px;
        overflow-wrap: anywhere;
    }

    .livro-card p {
        color: #78695b;
        margin: 8px 0;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .livro-status {
        display: inline-block;
        margin: 4px 0 12px;
        padding: 6px 10px;
        border-radius: 20px;
        background: #eaf4e8;
        color: #285b32;
        font-size: .8rem;
        font-weight: 600;
    }

    .livro-status-emprestado {
        background: #fae9e5;
        color: #8c3025;
    }

    .livro-acoes {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 18px;
        padding-top: 15px;
        border-top: 1px solid #eee3d3;
    }

    .livro-botao {
        display: inline-block;
        border: 0;
        border-radius: 8px;
        padding: 10px 13px;
        font: inherit;
        font-size: .9rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .livro-botao-editar {
        background: #f3e7d2;
        color: #654b2e;
    }

    .livro-botao-excluir {
        background: #fae9e5;
        color: #8c3025;
    }

    .livro-formulario {
        margin-top: 36px;
        padding: 26px;
        background: #fffdf8;
        border: 1px solid #e8ddcc;
        border-radius: 16px;
    }

    .livro-formulario h2 {
        color: #493526;
        margin-top: 0;
    }

    .livro-form-grade {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .livro-campo {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .livro-campo label {
        color: #654b2e;
        font-weight: 600;
    }

    .livro-campo input,
    .livro-campo select {
        width: 100%;
        box-sizing: border-box;
        padding: 12px;
        border: 1px solid #d9cbb7;
        border-radius: 8px;
        background: #fff;
        color: #493526;
        font: inherit;
    }

    .livro-campo-largo {
        grid-column: 1 / -1;
    }

    .livro-botao-salvar {
        margin-top: 20px;
        background: #654b2e;
        color: #fffdf8;
    }

    .livro-cancelar {
        display: inline-block;
        margin: 20px 0 0 12px;
        color: #654b2e;
    }

    .catalogo-vazio {
        grid-column: 1 / -1;
        padding: 28px;
        border: 1px dashed #d9cbb7;
        border-radius: 12px;
        color: #78695b;
        text-align: center;
    }

    @media (max-width: 900px) {
        .catalogo-grade {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .catalogo-grade,
        .livro-form-grade {
            grid-template-columns: 1fr;
        }

        .livro-campo-largo {
            grid-column: auto;
        }

        .livro-formulario {
            padding: 18px;
        }
    }
</style>

<section class="catalogo-pagina">
    <header class="catalogo-intro">
        <h1>Acervo da Scriptoria</h1>
        <p>Consulta, pesquisa e gestão dos livros da biblioteca.</p>
    </header>

    <?php if ($sucesso !== ''): ?>
        <div class="catalogo-mensagem catalogo-sucesso">
            <?= e($sucesso) ?>
        </div>
    <?php endif; ?>

    <?php if ($erro !== ''): ?>
        <div class="catalogo-mensagem catalogo-erro">
            <?= e($erro) ?>
        </div>
    <?php endif; ?>

    <section class="catalogo-grade">
        <?php if (empty($livros)): ?>
            <div class="catalogo-vazio">
                Não foram encontrados livros para apresentar.
            </div>
        <?php else: ?>
            <?php foreach ($livros as $livro): ?>
                <article class="livro-card">
                    <h3><?= e($livro['titulo']) ?></h3>

                    <p><strong>Autor:</strong> <?= e($livro['autor']) ?></p>
                    <p><strong>Categoria:</strong> <?= e($livro['categoria']) ?></p>

                    <?php if (($livro['status'] ?? '') === 'DISPONIVEL'): ?>
                        <span class="livro-status">Disponível</span>
                    <?php else: ?>
                        <span class="livro-status livro-status-emprestado">
                            <?= e($livro['status'] ?? 'Indisponível') ?>
                        </span>
                    <?php endif; ?>

                    <p><strong>Localização:</strong> <?= e($livro['localizacao']) ?></p>

                    <div class="livro-acoes">
                        <a
                            class="livro-botao livro-botao-editar"
                            href="index.php?acao=editar&id=<?= (int) $livro['id'] ?>"
                        >
                            Editar
                        </a>

                        <form
                            method="POST"
                            action="index.php"
                            onsubmit="return confirm('Tens a certeza de que queres excluir este livro?');"
                        >
                            <input type="hidden" name="acao" value="excluir">
                            <input
                                type="hidden"
                                name="id"
                                value="<?= (int) $livro['id'] ?>"
                            >
                            <button class="livro-botao livro-botao-excluir" type="submit">
                                Excluir
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <section class="livro-formulario" id="formulario-livro">
        <h2>
            <?= $editando ? 'Editar livro' : 'Cadastrar novo livro' ?>
        </h2>

        <form method="POST" action="index.php">
            <input
                type="hidden"
                name="acao"
                value="<?= $editando ? 'editar' : 'cadastrar' ?>"
            >

            <?php if ($editando): ?>
                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $livroEdicao['id'] ?>"
                >
            <?php endif; ?>

            <div class="livro-form-grade">
                <div class="livro-campo">
                    <label for="titulo">Título</label>
                    <input
                        id="titulo"
                        name="titulo"
                        type="text"
                        maxlength="120"
                        required
                        value="<?= e($titulo) ?>"
                    >
                </div>

                <div class="livro-campo">
                    <label for="autor">Autor</label>
                    <input
                        id="autor"
                        name="autor"
                        type="text"
                        required
                        value="<?= e($autor) ?>"
                    >
                </div>

                <div class="livro-campo">
                    <label for="categoria">Categoria</label>
                    <input
                        id="categoria"
                        name="categoria"
                        type="text"
                        required
                        value="<?= e($categoria) ?>"
                    >
                </div>

                <div class="livro-campo">
                    <label for="status">Estado</label>
                    <select id="status" name="status" required>
                        <option
                            value="DISPONIVEL"
                            <?= $status === 'DISPONIVEL' ? 'selected' : '' ?>
                        >
                            Disponível
                        </option>
                        <option
                            value="EMPRESTADO"
                            <?= $status === 'EMPRESTADO' ? 'selected' : '' ?>
                        >
                            Emprestado
                        </option>
                    </select>
                </div>

                <div class="livro-campo livro-campo-largo">
                    <label for="localizacao">Localização na biblioteca</label>
                    <input
                        id="localizacao"
                        name="localizacao"
                        type="text"
                        required
                        value="<?= e($localizacao) ?>"
                    >
                </div>
            </div>

            <button
                class="livro-botao livro-botao-salvar"
                type="submit"
            >
                <?= $editando ? 'Guardar alterações' : 'Cadastrar livro' ?>
            </button>

            <?php if ($editando): ?>
                <a class="livro-cancelar" href="index.php">
                    Cancelar edição
                </a>
            <?php endif; ?>
        </form>
    </section>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
