<?php

use Config\Profiles;

$profileConfig = new Profiles();
$menus = $profileConfig->menus[$perfil] ?? [];
?>
<!doctype html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? $title : "ADMIN" ?> - Intake</title>
    <meta name="description" content="<?= isset($description) ? $description : ""  ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="icon.png">

    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("css/style.css") ?>">
    <?= isset($styles) ? $styles : "" ?>


    <link rel="manifest" href="site.webmanifest">
    <meta name="theme-color" content="#fafafa">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d179c845aa.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script>
        const baseUrl = "<?= base_url() ?>";
        const usuario = <?= json_encode($usuario) ?>;
    </script>
</head>

<body>
    <div class="layout">
        <div class="layout-col menu">
            <div class="menu">
                <div class="menu-top">
                    <a href="#" class="menu-logo">
                        <img src="<?= base_url("img/logo.svg") ?>" alt="VERNAL" class="menu-logo-img">
                    </a>
                    <div class="menu-top-info">
                        <div><?= $usuario["nombre"] ?> <?= $usuario["apellido_paterno"] ?></div>
                        <div><?= $usuario["correo_electronico"] ?></div>
                    </div>
                </div>
                <div class="menu-options">
                    <a href="<?= base_url("/") ?>" class="menu-link" data-menu="/">
                        <div class="icon-container">
                            <i class="fa-duotone fa-house-chimney icon fa-fade"></i>
                        </div>
                        <span>Inicio</span>
                    </a>

                    <?php foreach ($menus as $menu) : ?>
                        <a href="<?= base_url($menu['url']) ?>" class="menu-link" data-menu="<?= $menu['url'] ?>">
                            <div class="icon-container">
                                <i class="<?= $menu['icon'] ?>"></i>
                            </div>
                            <span><?= $menu['label'] ?></span>
                        </a>
                    <?php endforeach; ?>

                </div>
                <div class="menu-footer">
                    <a href="<?= base_url('cuenta') ?>" class="menu-link">
                        <div class="icon-container">
                            <i class="fa-duotone fa-user-gear"></i>
                        </div>
                        <span>Cuenta</span>
                    </a>
                    <form action="<?= base_url("salir") ?>" method="post">
                        <button class="menu-link">
                            <div class="icon-container">
                                <i class="fa-duotone fa-arrow-right-from-bracket"></i>
                            </div>
                            <span>Salir</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="layout-col main">
            <div id="buscador" class="buscador">
                <div class="buscador-container">
                    <div class="buscador-group">
                        <input type="text" id="search" class="buscador-input" placeholder="Buscar casos o clientes...">
                        <i class="fa-sharp fa-solid fa-user-magnifying-glass"></i>
                    </div>
                    <div id="results" class="buscador-resultados"></div>
                </div>
            </div>
            <?= $renderBody ?>
        </div>
    </div>

    <template id="tplResultados">
        <ul class="list-group list-group-flush">
            {{#if casos}}
                <li class="list-group-item disabled">
                    CASOS
                </li>
                {{#each casos}}
                    <a href="<?= base_url("/") ?>clientes/{{id_cliente}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                        <div class="mb-1">Caso #{{id_caso}}: {{proceso}}</div>
                        <small>Creado: {{fecha_creacion}}</small>
                    </a>
                {{/each}}
            {{/if}}
        </ul>
        {{#if clientes}}
            <ul class="list-group list-group-flush">
                <li class="list-group-item disabled">
                    CLIENTES
                </li>
                {{#each clientes}}
                    <a href="<?= base_url("/") ?>clientes/{{id_cliente}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                        <div class="mb-1">{{nombre}}</div>
                        <small class="mb-1">Teléfono: {{telefono}}</small>
                    </a>
                {{/each}}
            </ul>
        {{/if}}
    </template>

    <script src="<?= base_url("js/vendor/modernizr-3.12.0.min.js") ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="<?= base_url("js/app.js") ?>"></script>
    <?= isset($scripts) ? $scripts : "" ?>
</body>

</html>