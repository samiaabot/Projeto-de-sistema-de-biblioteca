
<?php
// Layout principal compartilhado da Scriptoria.
$paginaAtual = $_GET['pagina'] ?? 'catalogo';
$buscaAtual = $_GET['busca'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Scriptoria | Biblioteca</title>

    <meta name="description"
          content="Scriptoria — Sistema de Gestão de Bibliotecas.">

    <style>
        :root {
            --marfim: #fbf5ed;
            --papel: #fffdf9;
            --castanho: #59331f;
            --castanho-escuro: #382013;
            --dourado: #b58a59;
            --texto: #29231f;
            --texto-suave: #81766d;
            --linha: #e8ded2;
            --superficie: #f3ebe2;
            --verde: #55765b;
            --sombra: 0 8px 30px rgba(69, 43, 25, .06);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--texto);
            background: var(--marfim);
            font-family: "Segoe UI", Arial, sans-serif;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        .pagina {
            width: min(1440px, 100%);
            min-height: 100vh;
            margin: 0 auto;
            padding: 0 44px 48px;
        }

        /* CABEÇALHO */

        .topo {
            padding-top: 20px;
        }

        .barra-superior {
            min-height: 86px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            padding: 14px 0;
            border-bottom: 1px solid var(--linha);
        }

        .marca {
            display: inline-flex;
            align-items: center;
            gap: 13px;
            flex-shrink: 0;
        }

        .marca img {
            display: block;
            width: 230px;
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .marca-texto {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .marca-nome {
            color: var(--castanho);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 28px;
            letter-spacing: -1.2px;
        }

        .marca-descricao {
            margin-top: 5px;
            color: var(--texto-suave);
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .pesquisa {
            display: flex;
            align-items: center;
            width: min(390px, 100%);
            height: 44px;
            padding: 0 7px 0 16px;
            background: var(--papel);
            border: 1px solid var(--linha);
            border-radius: 8px;
            transition: border-color .2s, box-shadow .2s;
        }

        .pesquisa:focus-within {
            border-color: var(--dourado);
            box-shadow: 0 0 0 3px rgba(181, 138, 89, .12);
        }

        .pesquisa input {
            width: 100%;
            min-width: 0;
            border: 0;
            outline: 0;
            color: var(--texto);
            background: transparent;
            font-size: 13px;
        }

        .pesquisa input::placeholder {
            color: #a79b8f;
        }

        .pesquisa button {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            border: 0;
            border-radius: 6px;
            color: var(--castanho);
            background: transparent;
            cursor: pointer;
        }

        .pesquisa button:hover {
            background: var(--superficie);
        }

        .acoes-topo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .link-entrar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 0 17px;
            color: var(--castanho);
            border: 1px solid var(--linha);
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .link-entrar:hover {
            border-color: var(--dourado);
            background: var(--superficie);
        }

        .menu-mobile {
            display: none;
            width: 42px;
            height: 42px;
            border: 1px solid var(--linha);
            border-radius: 8px;
            color: var(--castanho);
            background: var(--papel);
            cursor: pointer;
        }

        /* NAVEGAÇÃO */

        .navegacao {
            display: flex;
            align-items: center;
            gap: 30px;
            min-height: 56px;
            border-bottom: 1px solid var(--linha);
        }

        .navegacao a {
            position: relative;
            display: inline-flex;
            align-items: center;
            min-height: 56px;
            color: #74665a;
            font-size: 13px;
            transition: color .2s;
        }

        .navegacao a:hover,
        .navegacao a.ativo {
            color: var(--castanho);
        }

        .navegacao a.ativo {
            font-weight: 700;
        }

        .navegacao a.ativo::after {
            position: absolute;
            right: 0;
            bottom: -1px;
            left: 0;
            height: 2px;
            background: var(--dourado);
            content: "";
        }

        /* CONTEÚDO DAS PÁGINAS */

        .conteudo {
            min-height: 420px;
            padding-top: 34px;
        }

        .titulo-pagina {
            margin: 0;
            color: var(--castanho-escuro);
            font-size: clamp(25px, 3vw, 35px);
            font-weight: 750;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .subtitulo-pagina {
            margin: 8px 0 26px;
            color: var(--texto-suave);
            font-size: 14px;
        }

        .caixa {
            margin-top: 24px;
            padding: 25px;
            border: 1px solid var(--linha);
            border-radius: 13px;
            background: var(--papel);
            box-shadow: var(--sombra);
        }

        .caixa h2 {
            margin: 0 0 20px;
            color: var(--castanho-escuro);
            font-size: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            color: var(--texto);
            font-size: 13px;
            font-weight: 650;
        }

        input:not([type="checkbox"]):not([type="radio"]),
        select,
        textarea {
            max-width: 100%;
        }

        .caixa input,
        .caixa select,
        .caixa textarea {
            width: 100%;
            margin-bottom: 16px;
            padding: 12px 14px;
            border: 1px solid var(--linha);
            border-radius: 8px;
            outline: none;
            color: var(--texto);
            background: #fff;
        }

        .caixa input:focus,
        .caixa select:focus,
        .caixa textarea:focus {
            border-color: var(--dourado);
            box-shadow: 0 0 0 3px rgba(181, 138, 89, .1);
        }

        .caixa textarea {
            min-height: 110px;
            resize: vertical;
        }

        button,
        .botao {
            transition: background .2s, border-color .2s, transform .2s;
        }

        .botao,
        .caixa button[type="submit"] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 43px;
            padding: 10px 18px;
            border: 1px solid var(--castanho);
            border-radius: 8px;
            color: white;
            background: var(--castanho);
            font-size: 13px;
            font-weight: 650;
            cursor: pointer;
        }

        .botao:hover,
        .caixa button[type="submit"]:hover {
            background: var(--castanho-escuro);
        }

        .aviso {
            margin: 0 0 16px;
            padding: 12px 15px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 13px;
        }

        .erro {
            color: #8a2b24;
            background: #fff0ed;
            border-color: #f0d0ca;
        }

        .sucesso {
            color: #315e3b;
            background: #edf6ed;
            border-color: #d2e7d3;
        }

        .cartao {
            padding: 18px 0;
            border-top: 1px solid var(--linha);
        }

        .cartao h3 {
            margin: 0 0 6px;
            color: var(--castanho);
            font-size: 17px;
        }

        .cartao p {
            margin: 0;
            overflow-wrap: anywhere;
        }

        .cartao small {
            display: inline-block;
            margin-top: 8px;
            color: var(--texto-suave);
            font-size: 12px;
        }

        .vazio {
            color: var(--texto-suave);
            font-size: 14px;
        }

        /* RODAPÉ */

        .rodape {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 65px;
            padding: 22px 0;
            border-top: 1px solid var(--linha);
            color: var(--texto-suave);
            font-size: 12px;
        }

        .rodape strong {
            color: var(--castanho);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 16px;
        }

        /* TABLETS E TELEMÓVEIS */

        @media (max-width: 850px) {
            .pagina {
                padding-right: 24px;
                padding-left: 24px;
            }

            .barra-superior {
                flex-wrap: wrap;
                gap: 15px;
            }

            .marca img {
                width: 190px;
            }

            .pesquisa {
                order: 3;
                width: 100%;
            }

            .navegacao {
                gap: 22px;
                overflow-x: auto;
            }

            .navegacao a {
                flex-shrink: 0;
            }
        }

        @media (max-width: 560px) {
            .pagina {
                padding-right: 16px;
                padding-left: 16px;
            }

            .topo {
                padding-top: 8px;
            }

            .barra-superior {
                min-height: 70px;
                gap: 10px;
            }

            .marca {
                gap: 8px;
            }

            .marca img {
                width: 165px;
            }

            .marca-nome {
                font-size: 23px;
            }

            .marca-descricao {
                font-size: 8px;
                letter-spacing: 1px;
            }

            .acoes-topo {
                gap: 6px;
            }

            .link-entrar {
                min-height: 36px;
                padding: 0 10px;
                font-size: 12px;
            }

            .menu-mobile {
                display: inline-grid;
                place-items: center;
            }

            .navegacao {
                display: none;
                align-items: stretch;
                flex-direction: column;
                gap: 0;
                padding: 8px 0;
                overflow: visible;
            }

            .navegacao.aberto {
                display: flex;
            }

            .navegacao a {
                min-height: 43px;
            }

            .navegacao a.ativo::after {
                right: auto;
                width: 35px;
            }

            .conteudo {
                padding-top: 25px;
            }

            .caixa {
                padding: 18px;
            }

            .rodape {
                flex-direction: column;
                margin-top: 40px;
            }
        }
    </style>
</head>

<body>
<div class="pagina">

    <header class="topo">
        <div class="barra-superior">

            <a class="marca" href="index.php" aria-label="Scriptoria — página inicial">
                <img
                    src="assets/img/logo-scriptoria.png"
                    alt="Scriptoria — Sistema de Gestão de Bibliotecas"
                >
            </a>

            <form class="pesquisa" method="GET" action="index.php" role="search">
                <input
                    type="search"
                    name="busca"
                    placeholder="Buscar por título, autor ou categoria..."
                    value="<?= htmlspecialchars((string) $buscaAtual, ENT_QUOTES, 'UTF-8') ?>"
                    aria-label="Buscar livros"
                >

                <button type="submit" aria-label="Pesquisar">
                    <svg width="19" height="19" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round">
                        <circle cx="10.8" cy="10.8" r="6.8"/>
                        <path d="m16 16 4.5 4.5"/>
                    </svg>
                </button>
            </form>

            <div class="acoes-topo">
                <a class="link-entrar" href="index.php?pagina=login">
                    Entrar
                </a>

                <button
                    class="menu-mobile"
                    type="button"
                    id="botaoMenu"
                    aria-label="Abrir menu"
                    aria-expanded="false"
                    aria-controls="navegacaoPrincipal"
                >
                    <svg width="22" height="22" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8"
                         stroke-linecap="round">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

        </div>

        <nav class="navegacao" id="navegacaoPrincipal"
             aria-label="Navegação principal">

            <a href="index.php"
               class="<?= $paginaAtual === 'catalogo' ? 'ativo' : '' ?>">
                Início
            </a>

            <a href="index.php?pagina=lancamentos">Lançamentos</a>
            <a href="index.php?pagina=ebooks">E-books</a>
            <a href="index.php?pagina=populares">Populares</a>
            <a href="index.php?busca=Acadêmicos">Acadêmicos</a>
            <a href="index.php?busca=Infantil">Infantil</a>
            <a href="index.php?busca=Ficção">Ficção</a>
            <a href="index.php?busca=Não Ficção">Não Ficção</a>

        </nav>
    </header>

    <main class="conteudo">
</body>
</html>
