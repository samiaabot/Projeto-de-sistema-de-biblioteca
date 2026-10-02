<?php
// Layout compartilhado: abre o documento e o CSS. Não consulta o banco.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini MVC PHP — Tarefas</title>
    <style>
        :root {
            --fundo: #f4f1ea;
            --papel: #fffdf8;
            --tinta: #1f2430;
            --muted: #5c6570;
            --linha: #e4ddd0;
            --destaque: #0f6e6e;
            --destaque-escuro: #0b5555;
            --erro-fundo: #fde8e6;
            --erro-texto: #8a2b24;
            --ok-fundo: #e5f6ee;
            --ok-texto: #0f6b45;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--tinta);
            background: var(--fundo);
            line-height: 1.5;
        }

        .pagina {
            width: min(720px, calc(100% - 32px));
            margin: 32px auto 48px;
        }

        header.topo h1 {
            margin: 0 0 8px;
            font-size: 2rem;
            letter-spacing: -0.03em;
        }

        header.topo p {
            margin: 0;
            color: var(--muted);
        }

        .fluxo {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 20px 0 0;
            padding: 0;
            list-style: none;
        }

        .fluxo li {
            background: #e7f3f3;
            color: var(--destaque-escuro);
            border-radius: 999px;
            padding: 4px 12px;
            font-family: "Segoe UI", sans-serif;
            font-size: 0.85rem;
        }

        .caixa {
            background: var(--papel);
            border: 1px solid var(--linha);
            border-radius: 16px;
            padding: 20px;
            margin-top: 20px;
        }

        h2 {
            margin: 0 0 16px;
            font-size: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-family: "Segoe UI", sans-serif;
            font-size: 0.92rem;
            font-weight: 650;
        }

        input,
        textarea {
            width: 100%;
            margin-bottom: 14px;
            padding: 10px 12px;
            border: 1px solid #cfc6b8;
            border-radius: 10px;
            font: inherit;
            color: inherit;
            background: #fff;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        button {
            border: 0;
            border-radius: 10px;
            padding: 10px 16px;
            background: var(--destaque);
            color: #fff;
            font-family: "Segoe UI", sans-serif;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background: var(--destaque-escuro);
        }

        .aviso {
            margin: 0 0 14px;
            padding: 10px 12px;
            border-radius: 10px;
            font-family: "Segoe UI", sans-serif;
        }

        .erro {
            background: var(--erro-fundo);
            color: var(--erro-texto);
        }

        .sucesso {
            background: var(--ok-fundo);
            color: var(--ok-texto);
        }

        .cartao {
            border-top: 1px solid var(--linha);
            padding: 14px 0;
        }

        .cartao:first-of-type {
            border-top: 0;
            padding-top: 0;
        }

        .cartao h3 {
            margin: 0 0 6px;
            font-size: 1.1rem;
        }

        .cartao p {
            margin: 0;
            white-space: pre-wrap;
        }

        .cartao small {
            display: inline-block;
            margin-top: 8px;
            color: var(--muted);
            font-family: "Segoe UI", sans-serif;
        }

        .vazio {
            margin: 0;
            color: var(--muted);
        }
    </style>
</head>
<body>
<div class="pagina">
    <header class="topo">
        <h1>Tarefas</h1>
        <p>Cadastro didático com PHP puro, no padrão MVC.</p>
        <ol class="fluxo">
            <li>1. View envia o formulário</li>
            <li>2. Controller valida</li>
            <li>3. Model grava com PDO</li>
            <li>4. View lista o resultado</li>
        </ol>
    </header>
