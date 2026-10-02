# mini-mvc-php

Starter kit para ensinar MVC com PHP nativo, HTML5 e CSS3. Não usa framework, Composer, router nem ferramenta de build.

O exemplo é um cadastro de tarefas com os campos `id`, `titulo` e `descricao`. O banco inicial é SQLite, para abrir no XAMPP sem instalar o MySQL.

## Como rodar no XAMPP

1. Copie a pasta `mini-mvc-php` para `C:\xampp\htdocs\`.
2. Abra o painel do XAMPP e inicie o **Apache**. O MySQL pode ficar desligado.
3. No navegador, acesse [http://localhost/mini-mvc-php/](http://localhost/mini-mvc-php/).
4. Preencha o formulário e salve. O arquivo `data/banco.sqlite` aparece sozinho na primeira visita.

A pasta `data` precisa permitir gravação. No XAMPP do Windows isso já costuma funcionar.

## O caminho de um dado

```text
views/tarefas_view.php          name="titulo"
        |  POST
controllers/TarefaController    $_POST['titulo']
        |
models/TarefaModel.php          :titulo  ->  coluna titulo
        |
views/tarefas_view.php          $tarefa['titulo']
```

O mesmo vale para `descricao`.

Depois de um INSERT bem-sucedido, o Controller responde com redirecionamento (`Location: index.php?sucesso=1`). Atualizar a página não cadastra a tarefa de novo.

## O que cada arquivo faz

| Arquivo | Papel |
| --- | --- |
| `index.php` | Entrada. Carrega a conexão, o Model e o Controller. |
| `config/database.php` | Abre o PDO (SQLite) e cria a tabela se ela não existir. |
| `controllers/TarefaController.php` | Lê `$_POST` / `$_GET`, valida e decide a resposta. |
| `models/TarefaModel.php` | `SELECT` e `INSERT` com `prepare`, `execute` e `fetchAll`. |
| `views/tarefas_view.php` | Formulário e listagem. Só exibe variáveis. |
| `views/layouts/header.php` | HTML5 compartilhado e o CSS da página. |
| `views/layouts/footer.php` | Fecha o HTML aberto no header. |

Ordem sugerida de leitura com a turma: `index.php`, Controller, Model, `database.php`, View.

## Trocar SQLite por MySQL

Os comentários em `config/database.php` mostram o DSN, usuário, senha e o `CREATE TABLE` no formato do MySQL. Crie antes o banco `mini_mvc` no phpMyAdmin e suba o MySQL no XAMPP.

## Limites de propósito

Este projeto mostra o ciclo formulário, validação, SQL e resposta. Login, edição, exclusão e rotas com várias páginas ficam para a aula seguinte.
