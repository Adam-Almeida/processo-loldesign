<?php $this->layout("_admin_theme"); ?>

<section class="main_admin">
    <div class="main_admin_content">
        <header class="radius">
            <?php if (!empty($plansAll)): ?>
                <h1>Planos Cadastrados</h1>
                <br>
                <?php foreach ($plansAll as $plan): ?>
                    <article style="border-bottom: #ffffff 1px solid; padding-bottom: 10px">
                        <div class="main_plans_call_article_left">
                            <h2 id="value-real-plans_call"><?= $plan->plan ?><span><?= $plan->minutes .' Minutos' ?></span></h2>

                            <span>
                            <a href="<?= urlLink("/admin/planos/editar/{$plan->id}") ?>"
                               class="main_plans_call_article_left_button main_plans_call_article_left_button_edit"><i
                                        class="icon-pencil2"></i> Editar</a>
                            <a href="<?= urlLink("/admin/planos/excluir/{$plan->id}") ?>"
                               class="main_plans_call_article_left_button main_plans_call_article_left_button_delete"><i
                                        class="icon-bin"></i> Excluir</a>
                        </span>
                        </div>

                    </article>
                <?php endforeach; ?>
            <?php
            else: ?>
                <h1>Ainda não existem planos Cadastrados!</h1>
            <?php endif; ?>
        </header>
        <header class="radius">
            <?php if (!empty($edit)): ?>
            <h1>Editar Plano</h1>
            <form action="<?= urlLink("/admin/planos/editar/$edit->id"); ?>" enctype="multipart/form-data"
                  method="post">
                <label for="name">Plano</label>
                <input name="plan" type="text" value="<?= $edit->plan; ?>" required>
                <label for="name">Minutos</label>
                <input name="minutes" type="number" value="<?= $edit->minutes; ?>" required>
                <button type="submit">Editar</button>
                <?php else: ?>
                <h1>Cadastrar Novo Plano</h1>
                <form action="<?= urlLink("/admin/planos"); ?>" enctype="multipart/form-data" method="post">
                    <label for="name">Plano</label>
                    <input name="plan" type="text" required>
                    <label for="name">Minutos</label>
                    <input name="minutes" type="number" required>
                    <button type="submit">Efetuar Cadastro</button>
                    <?php endif; ?>
                </form>
        </header>
    </div>
</section>