<?php
/**
 * VIEW
 *
 * Só HTML, CSS (no layout) e echo de variáveis.
 * O texto que veio do banco passa por htmlspecialchars antes
 * de entrar na página. Isso impede que um título com HTML
 * vire código no navegador.
 *
 * Esta tela não é aberta direto pela URL. O Controller a inclui.
 */
require __DIR__ . '/layouts/header.php';
?>

<section class="caixa">
    <h2>Livro</h2>

    <?php if ($erro !== ''): ?>
        <p class="aviso erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if ($sucesso !== ''): ?>
        <p class="aviso sucesso"><?= htmlspecialchars($sucesso, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <!--
        method="POST" gera uma requisição que o Controller reconhece
        em $_SERVER['REQUEST_METHOD'].

        O atributo name é o elo com o PHP e com o SQL:
          name="titulo"     -> $_POST['titulo']     -> :titulo
          name="descricao"  -> $_POST['descricao']  -> :descricao

        required e maxlength ajudam no navegador. A validação que
        vale de verdade está no Controller.
    -->
    <form method="POST" action="index.php">
        <label for="livro">Título do livro</label>
        <input
            type="text"
            id="titulo"
            name="titulo"
            maxlength="120"
            required
            value="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?>"
        >

        <label for="descricao">Deixe sua avaliação</label>
        <textarea
            id="descricao"
            name="descricao"
            maxlength="500"
            required
        ><?= htmlspecialchars($descricao, ENT_QUOTES, 'UTF-8') ?></textarea>

        <button type="submit">Salvar avaliação</button>
    </form>
</section>

<section class="caixa">
    <h2>Avaliações cadastradas</h2>

    <?php if ($tarefas === []): ?>
        <p class="vazio">Nenhuma avaliação ainda. Use o formulário acima.</p>
    <?php else: ?>
        <?php foreach ($tarefas as $tarefa): ?>
            <article class="cartao">
                <h3><?= htmlspecialchars($tarefa['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?= htmlspecialchars($tarefa['descricao'], ENT_QUOTES, 'UTF-8') ?></p>
                <small>id <?= (int) $tarefa['id'] ?></small>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
