<?php $this->layout("_admin_theme"); ?>

<section class="main_admin" xmlns="http://www.w3.org/1999/html">

    <div class="main_admin_content">
        <header class="radius">
            <?php if (!empty($callsAll)): ?>
                <h1>Tipos de Ligações Cadastradas</h1>
                <br>
                <?php foreach ($callsAll as $call): ?>
                    <article style="border-bottom: #ffffff 1px solid; padding-bottom: 10px; margin-bottom: 10px">
                        <div class="main_plans_call_article_left">
                            <h2 id="value-real-plans_call">
                                ORIGEM: <?= $call->origin ?> | DESTINO: <?= $call->destiny ?>
                                <span> <a href="<?= urlLink("/admin/call/editar/{$call->id}") ?>"
                                          class="main_plans_call_article_left_button
                                   main_plans_call_article_left_button_edit"><i
                                                class="icon-pencil2"></i> Editar</a>
                                   <a href="<?= urlLink("/admin/call/excluir/{$call->id}") ?>"
                                      class="main_plans_call_article_left_button main_plans_call_article_left_button_delete"><i
                                               class="icon-bin"></i> Excluir</a>
                               </span>
                            </h2>
                            <p class="icon-coin-dollar">Valor por minuto:
                                R$ <?= number_format($call->value, '2', ',', '.'); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php
            else: ?>
                <h1>Ainda não existem Ligações Cadastradas!</h1>
            <?php endif; ?>
        </header>

        <header class="radius">
            <?php if (!empty($edit)): ?>
            <h1>Editar Ligação</h1>
            <form action="<?= urlLink("/admin/call/editar/$edit->id"); ?>" enctype="multipart/form-data" method="post">
                <label for="origin">DDD de Origem</label>
                <input class="mask-ddd" value="<?= $edit->origin; ?>" name="origin" type="number" required>
                <label for="destiny">DDD de Destino</label>
                <input class="mask-ddd" value="<?= $edit->destiny; ?>" name="destiny" type="number" required>
                <label for="value">R$ Valor por Minuto</label>
                <input class="mask-money" value="<?= number_format($edit->value, '2', ',', '.'); ?>" name="value" type="text">
                <button type="submit">Atualizar Cadastro</button>
                <?php else: ?>
                <h1>Cadastrar Novo Tipo de Ligação</h1>
                <form action="<?= urlLink("/admin/call"); ?>" enctype="multipart/form-data" method="post">
                    <label for="origin">DDD de Origem</label>
                    <input class="mask-ddd" name="origin" type="number" required>
                    <label for="destiny">DDD de Destino</label>
                    <input class="mask-ddd" name="destiny" type="number" required>
                    <label for="value">R$ Valor por Minuto</label>
                    <input name="value" class="mask-money" type="text">
                    <button type="submit">Efetuar Cadastro</button>
                    <?php endif; ?>
                </form>
        </header>

    </div>
</section>

<?= $this->start("scripts"); ?>
<script>
    $(function () {
        $(".mask-money").mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});
        $(".mask-ddd").mask('00', {reverse: true, placeholder: "Insira o DDD"});
    });
</script>
<?= $this->stop(); ?>



