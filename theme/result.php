<?php $this->layout("_theme"); ?>
<article class="main_search">
    <div class="main_search_content">
        <header>
            <h1>Confira o valor da sua ligação de acordo com seu CEP</h1>
            <p>Com o plano FaleMais você tem muitas vantagens</p>
        </header>
        <form action="<?= urlLink('/plan'); ?>" enctype="multipart/form-data" method="post"">
        <input class="mask-zipcode" type="text" name="origin" placeholder="Digite o CEP de origem">
        <input class="mask-zipcode" type="text" name="destiny" placeholder="Digite o CEP de destino">
        <input type="text" name="minutes" placeholder="Minutos de ligação">
        <select type="text" name="plan">
            <option value="" selected>Selecione o Plano</option>
            <?php if (!empty($planAll)):
                foreach ($planAll as $plan):?>
                    <option value="<?= $plan->minutes; ?>"><?= $plan->plan; ?></option>
                <?php endforeach; else: ?>
                <option value="" selected>Não Existem Planos no Momento</option>
            <?php endif; ?>
        </select>
        <div><button type="submit">CALCULAR</button></div>
        </form>
    </div>
</article>

<section id="plans_call-id" class="main_plans_call">

    <div class="main_plans_call_content">
        <?php if (!empty($call)):?>
                <a style="cursor: pointer;" id="copy-plans_call-transfer-area">
                    <article>
                        <div class="main_plans_call_article_left">
                            <h2 id="value-real-plans_call">ORIGEM DDD: <?= $call->origin ?> | DESTINO DDD: <?= $call->destiny ?></h2>
                            <p>De Cep: <?= $call->cepOrigin ?> para Cep: <?= $call->cepDestiny ?></p>
                            <p class="icon-compass">Origem: <?= $call->cityOrigin ?> Destino: <?= $call->cityDestiny ?></p>
                            <p class="icon-hour-glass">Ligação de <?= $call->minutes ?> min</p>
                        </div>
                        <div style="width: 80%">
                        <div class="main_plans_call_article_right">
                            <p class="icon-circle-right">FaleMais <?= $call->plan. " min" ?></p>
                        </div>
                        <div class="main_plans_call_article_right">
                            <p class="icon-coin-dollar">Pague R$ <strong><?= number_format($call->value, '2', ',', '.'); ?></strong></p>
                        </div>
                        </div>
                    </article>
                </a>
                <a style="cursor: pointer;" id="copy-plans_call-transfer-area">
                    <article>
                        <div class="main_plans_call_article_left">
                            <h2 id="value-real-plans_call">ORIGEM DDD: <?= $call->origin ?> | DESTINO DDD: <?= $call->destiny ?></h2>
                            <p>De Cep: <?= $call->cepOrigin ?> para Cep: <?= $call->cepDestiny ?></p>
                            <p class="icon-compass">Origem: <?= $call->cityOrigin ?> Destino: <?= $call->cityDestiny ?></p>
                            <p class="icon-hour-glass">Ligação de <?= $call->minutes ?> min</p>
                        </div>
                        <div style="width: 80%">
                            <div class="main_plans_call_article_right">
                                <p class="icon-circle-right">Sem FaleMais <?= $call->plan. " min" ?></p>
                            </div>
                            <div class="main_plans_call_article_right">
                                <p class="icon-coin-dollar">Pague R$ <strong><?= number_format($call->originalValue, '2', ',', '.'); ?></strong></p>
                            </div>
                        </div>
                    </article>
                </a>
            <?php else: ?>
            <article style="padding: 50px">
                <h2>Ainda não existem Planos Cadastrados!</h2>
            </article>
        <?php endif; ?>
    </div>
</section>
