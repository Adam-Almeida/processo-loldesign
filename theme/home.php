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
<div class="banner_telzir_home">
</div>


