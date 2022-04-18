<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "Processo | Adam Almeida"; ?></title>

    <link rel="stylesheet" href="<?= url("theme/_cdn/fonticon.css"); ?>" type="text/css">
    <link rel="stylesheet" href="<?= url("theme/_cdn/boot.css"); ?>" type="text/css">
    <link rel="stylesheet" href="<?= url("theme/_cdn/style.css"); ?>" type="text/css">
    <link rel="stylesheet" href="<?= url("theme/_cdn/admin.style.css"); ?>" type="text/css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
<header class="main_header">

    <div class="main_header_content">
        <a href="<?= url(); ?>" class="logo">
            <img src="<?= url("theme/img/logo-telzir.svg"); ?>" width="70%"
                 alt="Bem Vindo a Minha Aplicação para o processo de testes PHP Developer">
        </a>
        <nav class="main_header_content_menu">
            <ul>
                <li><a href="<?= urlLink("/admin/dash"); ?>" class="icon-phone">LIGAÇÕES</a></li>
                <li><a href="<?= urlLink("/admin/planos"); ?>" class="icon-plus">PLANOS</a></li>
                <li><a href="<?= urlLink("/admin/sair"); ?>" class="icon-exit">SAIR</a></li>
            </ul>
        </nav>

        <nav class="main_header_content_menu_mobile">
            <ul>
                <li>
                    <span class="main_header_content_menu_mobile_obj icon-menu icon-notext "></span>
                    <ul class="main_header_content_menu_mobile_sub ds_none">
                        <li><a href="<?= urlLink("/admin/dash"); ?>" class="icon-phone">LIGAÇÕES</a></li>
                        <li><a href="<?= urlLink("/admin/especialidades"); ?>" class="icon-plus">PLANOS</a></li>
                        <li><a href="<?= urlLink("/admin/sair"); ?>" class="icon-exit">SAIR</a></li>
                        <li style="color: #004594; margin: 10px"><i class="icon-user"></i></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>

<main class="fadeIn">
    <?= flash(); ?>
    <!--  begin::content  -->
    <?= $this->section("content"); ?>
    <!--  end::content  -->
</main>


<footer class="main_footer">
    <div class="main_footer_content">
        <p>Aplicação desenvolvida por Adam Almeida para o processo seletivo de PHP Developer - DENTAL UNI - Agosto
            2021</p></div>
</footer>


<script src="<?= url("theme/_cdn/js/jquery-3.6.0.min.js"); ?>"></script>
<script src="<?= url("theme/_cdn/js/main.js"); ?>"></script>
<script src="<?= url("theme/_cdn/js/mask.js"); ?>"></script>

<?= $this->section("scripts"); ?>


</body>

</html>