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

    <link rel="stylesheet" href="<?= base_url("css/normalize.css") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.24.1/bootstrap-table.min.css" integrity="sha512-CPL36V8ZD92nblUPfrYxCPKrlykPHIsP6dp3C/9xXchzL84rSnDdyFeXnFEoTveGFxl5Ucamm4qHR8LynUTKdg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url("css/style.css?v=1.0.1") ?>">
    <?php if (isset($styles) && is_array($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <?= $style ?>
        <?php endforeach; ?>
    <?php else: ?>
        <?= isset($styles) ? $styles : "" ?>
    <?php endif; ?>

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("apple-touch-icon.png") ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url("favicon-32x32.png") ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url("favicon-16x16.png") ?>">
    <link rel="manifest" href="<?= base_url("site.webmanifest") ?>">
    <link rel="mask-icon" href="<?= base_url("safari-pinned-tab.svg") ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/901438e2f4.js" crossorigin="anonymous"></script>
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
                        <small>Creado: {{formatFecha fecha_creacion}}</small>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.24.1/bootstrap-table.min.js" integrity="sha512-SluUb5Wij76laheDMpw6UZXUuvefcSa3wbeMZoAzEwc8Fe9aVqUwAhG1n2FPDnZh8bExgmx5H6N3k2xzrd1nuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url("js/app.js?v=1.0.2") ?>"></script>
    <?php if (isset($scripts) && is_array($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <?= $script ?>
        <?php endforeach; ?>
    <?php else: ?>
        <?= isset($scripts) ? $scripts : "" ?>
    <?php endif; ?>
</body>

</html>