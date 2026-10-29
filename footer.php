
<?php
// Rodapé compartilhado da Scriptoria.
?>

    </main>

    <footer class="rodape">
        <div>
            <strong>Scriptoria</strong>
            <p>Sistema de Gestão de Bibliotecas</p>
        </div>

        <div>
            <p>Conhecimento que atravessa gerações.</p>
            <p>&copy; <?= date('Y') ?> Scriptoria. Todos os direitos reservados.</p>
        </div>
    </footer>

</div>

<script>
    const botaoMenu = document.getElementById('botaoMenu');
    const navegacao = document.getElementById('navegacaoPrincipal');

    if (botaoMenu && navegacao) {
        botaoMenu.addEventListener('click', function () {
            const aberto = navegacao.classList.toggle('aberto');

            botaoMenu.setAttribute('aria-expanded', String(aberto));
            botaoMenu.setAttribute(
                'aria-label',
                aberto ? 'Fechar menu' : 'Abrir menu'
            );
        });
    }
</script>

</body>
</html>
