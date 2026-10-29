
<?php
require __DIR__ . '/layouts/header.php';

function adminEscape($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>

<style>
    .admin-painel {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 0 48px;
    }

    .admin-cabecalho {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 32px;
    }

    .admin-cabecalho h1 {
        margin: 0 0 8px;
        color: #493526;
        font-size: clamp(1.8rem, 4vw, 2.6rem);
    }

    .admin-cabecalho p {
        margin: 0;
        color: #78695b;
    }

    .admin-etiqueta {
        display: inline-block;
        padding: 8px 13px;
        border-radius: 20px;
        background: #f3e7d2;
        color: #76552c;
        font-size: .85rem;
        font-weight: 600;
    }

    .admin-estatisticas {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 34px;
    }

    .admin-card {
        background: #fffdf8;
        border: 1px solid #e8ddcc;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 5px 18px rgba(65, 43, 25, .05);
    }

    .admin-card-topo {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 22px;
    }

    .admin-card-icone {
        display: grid;
        place-items: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f3e7d2;
        font-size: 1.35rem;
    }

    .admin-card-label {
        color: #78695b;
        font-size: .92rem;
        line-height: 1.5;
    }

    .admin-card-numero {
        display: block;
        color: #493526;
        font-size: 2.1rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .admin-secao {
        margin-bottom: 30px;
    }

    .admin-secao h2 {
        color: #493526;
        font-size: 1.35rem;
        margin: 0 0 16px;
    }

    .admin-acoes {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .admin-acao {
        display: block;
        padding: 22px;
        border: 1px solid #e8ddcc;
        border-radius: 14px;
        background: #fffdf8;
        color: #493526;
        text-decoration: none;
        transition: transform .2s, box-shadow .2s;
    }

    .admin-acao:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(65, 43, 25, .09);
    }

    .admin-acao strong {
        display: block;
        margin-bottom: 8px;
        font-size: 1.05rem;
    }

    .admin-acao p {
        margin: 0;
        color: #78695b;
        font-size: .92rem;
        line-height: 1.6;
    }

    .admin-aviso {
        margin-top: 24px;
        padding: 16px 18px;
        border-left: 4px solid #b58a4b;
        border-radius: 8px;
        background: #f8f0e2;
        color: #654b2e;
        line-height: 1.6;
    }

    @media (max-width: 900px) {
        .admin-estatisticas {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .admin-acoes {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 520px) {
        .admin-painel {
            padding-top: 22px;
        }

        .admin-estatisticas {
            gap: 12px;
        }

        .admin-card {
            padding: 16px;
        }

        .admin-card-numero {
            font-size: 1.7rem;
        }
    }
</style>

<section class="admin-painel">
    <header class="admin-cabecalho">
        <div>
            <h1>Painel administrativo</h1>
            <p>Bem-vindo à área de gestão da biblioteca Scriptoria.</p>
        </div>

        <span class="admin-etiqueta">Gestão da biblioteca</span>
    </header>

    <section class="admin-estatisticas">
        <article class="admin-card">
            <div class="admin-card-topo">
                <span class="admin-card-label">Livros cadastrados</span>
                <span class="admin-card-icone" aria-hidden="true">📚</span>
            </div>
            <strong class="admin-card-numero">
                <?= adminEscape($totalLivros) ?>
            </strong>
        </article>

        <article class="admin-card">
            <div class="admin-card-topo">
                <span class="admin-card-label">Livros disponíveis</span>
                <span class="admin-card-icone" aria-hidden="true">📖</span>
            </div>
            <strong class="admin-card-numero">
                <?= adminEscape($livrosDisponiveis) ?>
            </strong>
        </article>

        <article class="admin-card">
            <div class="admin-card-topo">
                <span class="admin-card-label">Empréstimos ativos</span>
                <span class="admin-card-icone" aria-hidden="true">🔄</span>
            </div>
            <strong class="admin-card-numero">
                <?= adminEscape($emprestimosAtivos) ?>
            </strong>
        </article>

        <article class="admin-card">
            <div class="admin-card-topo">
                <span class="admin-card-label">Usuários cadastrados</span>
                <span class="admin-card-icone" aria-hidden="true">👥</span>
            </div>
            <strong class="admin-card-numero">
                <?= adminEscape($totalUsuarios) ?>
            </strong>
        </article>
    </section>

    <section class="admin-secao">
        <h2>Gestão da biblioteca</h2>

        <div class="admin-acoes">
            <a class="admin-acao" href="index.php">
                <strong>📚 Consultar catálogo</strong>
                <p>Ver os livros cadastrados e voltar à página principal.</p>
            </a>

            <a class="admin-acao" href="index.php?pagina=livros">
                <strong>✍️ Gerir livros</strong>
                <p>A área de cadastro e edição será integrada na próxima etapa.</p>
            </a>

            <a class="admin-acao" href="index.php?pagina=emprestimos">
                <strong>🔄 Gerir empréstimos</strong>
                <p>A área de empréstimos e devoluções será criada numa próxima etapa.</p>
            </a>
        </div>

        <div class="admin-aviso">
            <strong>Nota:</strong> este painel mostra os totais reais da base
            de dados. Os links de gestão de livros e empréstimos ainda são
            atalhos de preparação; vamos implementar essas funcionalidades
            nas próximas etapas.
        </div>
    </section>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
